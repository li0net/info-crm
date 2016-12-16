<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/***
 * Класс для подготовки данных для jqgrid
 */

class JqGridHandler
{

    /**
     * @var DB
     */
    public $db;

    public $rows;

    /**
     *@var boolean Использовать ли подсчет записей полученных главным запросом
     * Если FALSE, то класс будет пытатсья составить свой запрос для подсчета записей выборки
     */
    public $useMainQueryCount = FALSE;

    /**
     * @var null|DB Запрос, который используется для получения количества записей.
     * Работает при $this->useMainQueryCount = FALSE.
     * В запросе должно быть поле total которое и будет считаться гридом количеством записей
     */
    protected $countSql = NULL;

    /**
     * Опция включает новый формат результата. Его отличительной особенностью является то,
     * что данные для каждой строки отдаются не в виде массива, а в виде словаря.
     * Таким образом грид определяет в каком столбце отображать значение не по порядку следования элементов,
     * а по именам (ключам).
     */
    private $hashModeResult = FALSE;

    /**
     * Список полей, которые в гриде представлены как date, а в базе как datetime
     * Фильтры по таким полям будут по особому обрабатываться в addFilter()
     * @var array
     */
    public $dateFields = array();

    /**
     * @var array Соотвествие между переданными из грида условиями и sql-эквивалентами
     */
    protected $filterMap = array(
        'eq' => array('operation' => '='),
        'ne' => array('operation' => '<>'),
        'lt' => array('operation' => '<'),
        'le' => array('operation' => '<='),
        'gt' => array('operation' => '>'),
        'ge' => array('operation' => '>='),

        'bw' => array('operation' => 'LIKE', 'template' => "%s%%"),
        'bn' => array('operation' => 'NOT LIKE', 'template' => "%s%%"),
        'ew' => array('operation' => 'LIKE', 'template' => "%%%s"),
        'en' => array('operation' => 'NOT LIKE', 'template' => "%%%s"),
        'cn' => array('operation' => 'LIKE', 'template' => "%%%s%%"),
        'nc' => array('operation' => 'NOT LIKE', 'template' => "%%%s%%")
    );

    /**
     * @param bool $hashModeResult Управляет представление результата. TRUE - хеш, FALSE - массив
     */
    public function __construct($hashModeResult=FALSE) {
        $this->hashModeResult = $hashModeResult;
    }

    /**
     * Устанавливает отдельный запрос для подсчета числа строк грида
     * @param db $db Объект формирующий запрос
     */
    public function setCountQuery($db) {
        $this->useMainQueryCount = FALSE;
        $this->countSql = $db;
    }

    /**
     * Добавление фильтра к базовому запросу
     * @param object $rule Объект описывающий условие {op: operation, data: value, fields: fieldname}
     * @param string $operation Операция AND или OR для WHERE
     */
    protected function addFilter($rule, $operation = 'and') {
        $map = isset($this->filterMap[$rule->op]) ? $this->filterMap[$rule->op] : NULL;
        $searchString = (isset($map['template'])) ? sprintf($map['template'], $rule->data): $rule->data;
        $method = $operation.'_where';
        if($rule->op == 'in') { // Оператор IN
            $this->db->$method($rule->field, 'IN', json_decode($searchString));
        } else { // Все другие операторы (см. $this->filterMap)
            $this->db->$method($rule->field, $map['operation'], $searchString);
        }
    }

    /**
     * Версия метода addFilter для полей указанных в свойстве $this->dateFields
     * @param $rule
     * @param string $operation
     */
    protected function addDateFilter($rule, $operation = 'and') {

        $map = isset($this->filterMap[$rule->op]) ? $this->filterMap[$rule->op] : NULL;

        $ruleData = preg_replace('/[^\d\-]+/', '', $rule->data); // Защита от SQL-инъекций

        // Передан оператор "Не равно"
        if ($rule->op == 'ne') {
            $rule->field = DB::raw("DATE({$rule->field}) " . $map['operation'] . " '" . PDO::escape($ruleData) . "'");
            $this->addFilter($rule, $operation);
        }

        // Равно
        if ($rule->op == 'eq') {
            $beginDate = new DateTime("{$ruleData} 00:00:00");
            $endDate = new DateTime("{$ruleData} 23:59:59");
            $fromRule = clone $rule;
            $fromRule->data = $beginDate->format('Y-m-d H:i:s');
            $fromRule->op = 'ge';
            $this->addFilter($fromRule, $operation);
            $toRule = clone $rule;
            $toRule->data = $endDate->format('Y-m-d H:i:s');
            $toRule->op = 'le';
            $this->addFilter($toRule, $operation);
        }

        // Меньше
        if ($rule->op == 'lt') {
            $limitDate = new DateTime("{$ruleData} 00:00:00");
            $rule->data = $limitDate->format('Y-m-d H:i:s');
            $this->addFilter($rule, $operation);
        }

        // Меньше либо равно
        if ($rule->op == 'le') {
            $limitDate = new DateTime("{$ruleData} 23:59:59");
            $rule->data = $limitDate->format('Y-m-d H:i:s');
            $this->addFilter($rule, $operation);
        }

        // Больше
        if ($rule->op == 'gt') {
            $limitDate = new DateTime("{$ruleData} 23:59:59");
            $rule->data = $limitDate->format('Y-m-d H:i:s');
            $this->addFilter($rule, $operation);
        }

        // Больше или равно
        if ($rule->op == 'ge') {
            $limitDate = new DateTime("{$ruleData} 00:00:00");
            $rule->data = $limitDate->format('Y-m-d H:i:s');
            $this->addFilter($rule, $operation);
        }
    }

    /**
     * Получение выборки для грида с учетом выбранной страницы и фильтров
     *
     * @param array|string $userData Дополнительные данные, передаваемые в грид. Например для строки ИТОГО
     * @param string $stage Стадия, до которой будет идти выполнение метода. Значения: cells - идти до самого конца; raw - результат sql-выборки без учета пагинации
     * @return GridRequestHandlerResponse|'Illuminate\Database\Eloquent\Collection' Готовый массив с данными для каждой ячейки грида либо sql-результат
     */
    public function handle($userData='', $stage = 'cells') {
        $request = new Request();

        $this->changeAjaxData();
        $this->applySearchFilters();
        $page = (int) $request->input('page', 1); //page number
        $limit = (int) $request->input('rows', 10); //rows per page
        $sidx = $request->input('sidx', 'id'); //sort index
        $sord = $request->input('sord', 'desc'); //sort order

        // Закрываем возможность sql-инъекции
        if((preg_replace('/[^A-Za-z0-9_\.]+/', '', $sidx)!=$sidx) OR strlen($sidx)>30) {
            $sidx = 'id';
        }

        if($sord!='desc' AND $sord!='asc') {
            $sord = 'desc';
        }

        if($stage == 'raw') { // Возвращенм результат выборки с учетом фильтров
            return $this->db->get();
        }

        $response = new GridRequestHandlerResponse;
        $response->page = $page;

        $dbCount = clone $this->db;

        if($this->useMainQueryCount) { // Используем подсчет строк основного запроса
            $response->records = $dbCount->get()->count();
        } else { // Самостоятельно формируем запрос на подсчет общего числа строк
            if(empty($this->countSql)) {
                $response->records =  $dbCount->getCountForPagination();        // ->count() ?
            } else { // использовать указанный запрос для подсчета количества записей грида
                $response->records = $this->countSql->get()->first()->total;
            }
        }

        $response->total = $response->records > 0 ? ceil($response->records / $limit) : 0;

        $response->userdata = $userData;

        $offset = $limit * $page  - $limit;
        $this->db->orderBy($sidx, $sord);
        $this->db->offset($offset)->limit($limit);

        $rows = $this->db->get()->as_array();

        // Формируем данные для строк
        $i = 0;
        foreach ($rows as $row) {
            if ($this->hashModeResult) { // Отдаем hash для каждой строки
                if(!isset($response->rows[$i])) {
                    $response->rows[$i] = array();
                }
                foreach($row as $key => $value) {
                    $response->rows[$i][$key] = ($value=='0.0000') ? '0' : $value;
                }
            } else { // Отдаем массив для каждой строки
                if(isset($row['id'])) {
                    $response->rows[$i]['id']	= $row['id'];
                }
                $cells = array();
                foreach($row as $cell) {
                    $cells[] = ($cell=='0.0000') ? '0' : $cell;
                }
                $response->rows[$i]['cell']	= $cells;
            }
            $i++;
        }

        return $response;
    }

    /**
     * В потомках может переопределять GET-данные. Используется в некоторых гридах (Грид с папками пользователя)
     */
    protected function changeAjaxData() {}

    /**
     * Обработка параметров поиска
     */
    protected function applySearchFilters() {
        $request = new Request();

        $search = $request->input('_search', 'false');
        $searchField = $request->input('searchField', NULL);
        $searchOper = $request->input('searchOper', NULL);
        $searchString = $request->input('searchString', '');
        $filters = $request->input('filters', NULL);
        // Обрабатываем поисковые параметры
        if ($search == 'true') {
            if(isset($filters) AND ! empty($filters)) {
                // Если фильтр задан через параметр filters (например jqGrid Smart Search)
                $filters = json_decode($filters);
                $rules = $filters->rules;
                $operation = ($filters->groupOp=="AND") ? 'and' : 'or';

                // TODO: разобрать чем заменить в Eloquent ORM
                $this->db->and_open();
                foreach($rules as $rule) {
                    if(in_array($rule->field, $this->dateFields)) {
                        $this->addDateFilter($rule, $operation);
                    } else {
                        $this->addFilter($rule, $operation);
                    }
                }
                $this->db->close();
            }
            if(!empty($searchField)) {
                // Если задан фильтр через searchField, searchOper, searchString
                $this->db->and_open();
                $rule = array (
                    'field' => $searchField,
                    'op' => $searchOper,
                    'data' => $searchString
                );
                $this->addFilter((object) $rule);
                $this->db->close();
            }
        }
    }


}



class GridRequestHandlerResponse
{
    public $page;
    public $records;
    public $total;
    public $rows = array();
    public $userdata;
}