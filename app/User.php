<?php

namespace App;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Support\Facades\Log;


/**
 * App\User
 *
 * @property int $user_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $organization_id
 * @property string $lang
 * @property string $city
 * @property bool $is_admin
 * @property string $phone
 * @property string $info
 * @property string $remember_token
 * @property bool $send_news_inf_emails
 * @property bool $send_marketing_offer_emails
 * @property bool $send_system_inf_emails
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $new_email
 * @property string $new_phone
 * @property string $confirmation_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AccessPermission[] $accessPermissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereConfirmationCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLang($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereNewEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereNewPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereSendMarketingOfferEmails($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereSendNewsInfEmails($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereSendSystemInfEmails($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUserId($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'name',
        'lang',
        'city',
        'phone',
        'send_news_inf_emails',
        'send_marketing_offer_emails',
        'send_system_inf_emails',
        'info'
        //'email',
        //'password',
        //'organization_id',
        //'remember_token',
        //'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function accessPermissions()
    {
        return $this->hasMany(AccessPermission::class);
    }

    /**
     * Позволяет проверить, есть ли у текущего пользователя доступ к определенной области сайта
     * @param string $objectName имя раздела сайта либо сущности
     * @param string $action тип действия ('view', 'create', 'update', 'delete')
     * @param int $objectId идентификатор объекта, 0 для доступа ко всем объектам данного типа
     *
     * @return mixed FALSE|int FALSE если доступ запрещен, int access_level если доступ есть
     * */
    public function hasAccessTo($objectName, $action, $objectId = NULL)
    {
        /*
        id,
        user_id,
        object,
        object_id,
        access_level,
        created_at,
        updated_at,

        action enum('view', 'create', 'update', 'delete'),
        updated_by integer unsigned not null,

        FROM `crm`.`access_permissions`;
        */

        $hasAccess = FALSE;

        /*
        Представление пунктов настроект доступа в БД

        *Журнал записей
        object	= appointments
        object_id = NULL
        action	= view
        access_level = 1|0		(0 - нет доступа, 1 - есть доступ)

        журнал записей для Должности
        object	= appointments_by_position
        object_id = POSITION_ID или 0
        action	= view
        access_level = 1|0

        журнал записей для Сотрудника
        object	= appointments_by_employee
        object_id = EMPLOYEE_ID или 0
        action	= view
        access_level = 1|0

        доступ к истории расписания и записей
        object	= appointments_history
        object_id = NULL
        action	= view
        access_level = 0 нет доступа, 1 - доступ к N дням (см additional_settings), 2 - доступ без ограничений
        additional_settings = {days_ago:15}

        показывать номера телефонов в журнале записей
        object	= appointments_phones
        object_id = NULL
        action	= view
        access_level = 1|0

        измениять график работы сотрудника их журнала записей
        object	= appointments_schedule
        object_id = NULL
        action	= edit
        access_level = 1|0


        *Окно записей
        object	= appointment_form
        object_id = NULL
        action	= view
        access_level = 1|0

        Создание записей
        object	= appointment
        object_id = 0
        action	= create
        access_level = 1|0

        Редактирование записей
        object	= appointment
        object_id = 0
        action	= edit
        access_level = 1|0

        Удление записей
        object	= appointment
        object_id = 0
        action	= delete
        access_level = 1|0

        Доступ к данным клиентов
        object	= appointment_client_data
        object_id = 0
        action	= view
        access_level = 1|0


        *Настройки
        object	= settings
        object_id = NULL
        action	= view
        access_level = 1|0

        Управление пользователями (crud и форма прав доступа?)
        object	= settings_manage_users
        object_id = 0
        action	= edit
        access_level = 1|0

        Редактирование услуг
        object	= service
        object_id = 0
        action	= edit
        access_level = 1|0

        Удаление услуг
        object	= service
        object_id = 0
        action	= delete
        access_level = 1|0

        Редактирование персонала
        object	= employee
        object_id = 0
        action	= edit
        access_level = 1|0

        Удаление персонала
        object	= employee
        object_id = 0
        action	= delete
        access_level = 1|0

        Редактирование графика работы
        object	= schedule
        object_id = 0
        action	= delete
        access_level = 1|0


        *Клиенты
        object	= clients
        object_id = NULL
        action	= view
        access_level = 1|0

        Показывать номера телефонов в списке клиентов
        object	= clients_phone
        object_id = NULL
        action	= view
        access_level = 1|0

        Показывать номера телефонов в карточке клиента
        object	= client_phone
        object_id = 0
        action	= view
        access_level = 1|0

        Выгружать список клиентов в xls
        object	= clients_export_xls
        object_id = NULL
        action	= view
        access_level = 1|0

        *Статистика
        object	= statistics
        object_id = NULL
        action	= view
        access_level = 1|0

        *Отправлять SMS
        object	= send_sms
        object_id = NULL
        action	= view
        access_level = 1|0
        */

        if ($this->is_admin) {
            //return TRUE;
            return 255;     // максимальный уровень доступа
        }

        $permission = $this->accessPermissions()
            ->where('object', $objectName)
            ->where('action', $action);
        if (!is_null($objectId)) {
            $permission->where('object_id', $objectId);
        }
        $permission = $permission->get()->first();
        if ($permission) {      // TODO: проверить, что это корректная проверка
            if ($permission->access_level == 0) {
                return FALSE;
            } else {
                return $permission->access_level;
            }
        }

        // TODO: ПОДУМАТЬ как передать  массив, если надо передать доп. настройки (например, количество дней на которые можно смотреть журнал записей)

        return $hasAccess;
    }

    public function normalizePhoneNumber($phoneNum) {
        //' +7 (927) 342-23 45 '

        $phoneNum = trim($phoneNum);
        $phoneNum = str_replace(
            [' ', '(', ')', '-', '—', '–', '-'],
            '',
            $phoneNum
        );

        // Для России заменяем код страны 8 на +7
        // могут быть проблемы с номерами где 8 это просто часть номера (городские, либо если указывают сразу код города без кода страны)
        //  ограничение на длину должно помочь
        if (substr($phoneNum, 0, 1) == '8' AND strlen($phoneNum) > 7) {
            // Хардкод hardcode для России
            $phoneNum = '+7'.substr($phoneNum, 1);
        }

        return $phoneNum;
    }

    /**
     * Нормализует имя юзера
     * Удаляет лишние пробелы, Капитализует первые буквы
     * @param $name
     * @return mixed|string
     */
    public function normalizeUserName($name) {
        // Удаляем лишние пробелы
        $name = preg_replace('/\s+/', ' ',trim($name));

        // капитализация первых символов
        $name = ucwords(strtolower($name));

        return $name;
    }

    /**
     * Нормализует email
     * @param $email
     * @return mixed|string
     */
    public function normalizeEmail($email) {
        // Удаляем лишние пробелы, приводинм к нижнему регистру
        $email = strtolower(trim($email));
        return $email;
    }

    public function getAvatarUri() {
        $avatarPath = public_path() . 'uploaded_images/avatar/' . $this->oranization_id . '/' . $this->user_id . 'jpg';
        if (file_exists($avatarPath)) {
            $avatarUri = asset('uploaded_images/avatar/' . $this->oranization_id . '/' . $this->user_id . 'jpg');
        } else {
            // дефолтный аватар
            //$avatarUri = asset('img/crm/avatar/avatar100.jpg');

            //TODO {Сергей} можно вместо этого получать автатарку через Gravatar::get($user->email)
            //TODO {Сергей} он генерит ту же дефолтную картинку, елси аватарки у юзера нет
            $avatarUri = Gravatar::get($this->email);
        }

        return $avatarUri;
    }

    /**
     * Get the organization/branch id
     *
     * @param  string  $value
     * @return string
     */
    public function getOrganizationIdAttribute($value)
    {
        if (!\App::runningInConsole()) {
            $branchId = Request::session()->get('branch_id', null);
            if (is_null($branchId)) {
                return $value;
            }

            // TODO: кешировать
            $branchSoData = DB::select(
                "SELECT super_organization_id, organization_id FROM organizations WHERE organization_id=:branchId OR organization_id=:orgId",
                [':branchId' => $branchId, ':orgId' => $value]
            );

            if (count($branchSoData) > 0) {
                $orgSorg = [];
                foreach($branchSoData AS $row) {
                    $orgSorg[$row->organization_id] = $row->super_organization_id;
                }
                //Log::debug('User orgSorg:'.print_r($orgSorg, TRUE));

                if (isset($orgSorg[$value]) AND isset($orgSorg[$branchId])) {
                    if ($orgSorg[$value] == $orgSorg[$branchId]) return $branchId;
                }
            }
        }

        return $value;
    }
}
