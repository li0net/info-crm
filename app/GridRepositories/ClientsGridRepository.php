<?php

namespace App\GridRepositories;

use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Request;
use \Illuminate\Support\Facades\Log;
use App\Libraries\EloquentGridRepositoryCustom;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ClientsGridRepository extends EloquentGridRepositoryCustom {

    public function __construct()
    {
        $orgId = Request::user()->organization_id;

        $this->Database = DB::table('clients')
            //->join('access_permissions', 'users.users_id', '=', 'access_permissions.user_id')
            ->where('organization_id', $orgId)
            ->where('is_active', true);

        $this->visibleColumns = [
            'client_id',
            'name',
            'phone',
            'total_bought',
            'discount',

            'email',        // не отоюражается отдельной колонкой в гриде, но нужно для добавления в колонку Контакты вместе с телефоном
            'importance'
        ];

        $this->orderBy = [
            array('name', 'asc'),
            //array('table_1.name', 'desc')
        ];
    }


    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(), $nodeId = null, $nodeLevel = null, $exporting)
    {
        if ($exporting !== false) {
            // проверяем есть у юзера права на xls экспорт списка клиентов
            $allowExporting = Request::user()->hasAccessTo('clients_export_xls', 'view', null);
            //Log::info(__METHOD__.' allowExporting:'.var_export($allowExporting, TRUE).' exporting:'.var_export($exporting, TRUE));
            if (!$allowExporting) {
                throw new AccessDeniedHttpException('You don\'t have permission to access this page');
            }
        }

        $rows = parent::getRows($limit, $offset, $orderBy, $sord, $filters, $nodeId, $nodeLevel, $exporting);

        // проверяем есть у юзера права на просмотр телефонов клиентов
        $showPhone = Request::user()->hasAccessTo('clients_phone', 'view', null);

        foreach ($rows AS &$row) {
            if (!$showPhone) {
                $row['phone'] = trans('main.user:grid_phone_hidden_message');
            }

            if (trim($row['email']) != '') {
                if (!$exporting) {
                    $row['phone'] .= '<br/><span style="color: #595959; font-size: 80%">' . $row['email'];
                    unset($row['email']);
                } else {
                    $row['phone'] .= " - " . $row['email'];
                }
            }
            //unset($row['email']);

            if (!$exporting) {
                $row['name'] = "<a href='/client/{$row['client_id']}'>{$row['name']}</a>";
            }

            $row['total_bought'] = round($row['total_bought'], 2);
        }

        return $rows;
    }
}