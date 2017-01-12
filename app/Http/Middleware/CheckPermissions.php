<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $protectedObjects = array(
            'AppointmentsJournalController'        => [     // TODO: актуализировать имя контроллера, когда он будет создан (контроллер для работы с существующими Записями визитов (отображение на календаре и в расписании))
                'objectName'    => 'appointments',
                'action'        => 'view',
                'objectId'      => NULL,
                'accessLevel'  => 1
            ],
            'AppointmentsController'        => [            // Окно записей в целом
                'objectName'    => 'appointment_form',
                'action'        => 'view',
                'objectId'      => NULL,
                'accessLevel'  => 1
            ],

            'AppointmentController@create' => [
                'objectName'    => 'appointment',
                'action'        => 'create',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],
            'AppointmentController@edit' => [
                'objectName'    => 'appointment',
                'action'        => 'edit',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],
            'AppointmentController@delete' => [
                'objectName'    => 'appointment',
                'action'        => 'delete',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],

            'AppointmentController@getClientInfo' => [      // Доступ к данным клиентов из Окна создания/редактирования Записи
                'objectName'    => 'appointment_client_data',
                'action'        => 'view',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],

            'ServicesController@edit' => [          // Редактирование услуг - редактировагние, в смысле управления, т.е. создание сюда тоже входит
                'objectName'    => 'service',
                'action'        => 'edit',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],
            'ServicesController@create' => [
                'objectName'    => 'service',
                'action'        => 'edit',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],
            'ServicesController@save' => [
                'objectName'    => 'service',
                'action'        => 'edit',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],
            'ServiceCategoriesController@create' => [
                'objectName'    => 'service',
                'action'        => 'edit',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],
            'ServiceCategoriesController@edit' => [
                'objectName'    => 'service',
                'action'        => 'edit',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],
            'ServiceCategoriesController@save' => [
                'objectName'    => 'service',
                'action'        => 'edit',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],

            'ServicesController@destroy' => [      // Удаление услуг
                'objectName'    => 'service',
                'action'        => 'delete',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],
            'ServiceCategoriesController@destroy' => [
                'objectName'    => 'service',
                'action'        => 'delete',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],

            'EmployeeController@update' => [      // Редактирование персонала
                'objectName'    => 'employee',
                'action'        => 'edit',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],
            'EmployeeController@destroy' => [      // Удаление персонала
                'objectName'    => 'employee',
                'action'        => 'delete',
                'objectId'      => 0,
                'accessLevel'  => 1    // 1|0
            ],

            /*
            object	= settings
            object_id = NULL
            action	= view
            access_level = 1|0
            */

            'UsersController'        => [     // Управление пользователями (crud и форма прав доступа?)
                'objectName'    => 'settings_manage_users',
                'action'        => 'edit',
                'objectId'      => 0,
                'accessLevel'  => 1
            ]

        );


        $user = $request->user();
        if (is_null($user)) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        // get current controller and method
        //$act = Route::getCurrentRoute()->getAction();
        $action = Route::currentRouteAction();      // App\Http\Controllers\AppointmentsController@create
        $controllerMethod = class_basename($action);      // AppointmentsController@create
        list($controller, $action) = explode('@', $controllerMethod); // 'AppointmentsController', 'create'

        Log::info(__METHOD__.' controller:'.$controller.' action:'.$action);

        // check permissions
        // сначала проверяем есть ли ограничение на весь контроллер целиком (например возможен запрет на доступ к Журналу записей)
        // TODO: такая схема может не подойти, нужна проверка (Журнал записей может состоять из нескольких контроллеров)
        //  в принципе ничего не мешает иметь в $protectedObjects несколько записей на одну защищаемую сущность
        if (isset($protectedObjects[$controller])) {

            $accessLevel = $user->hasAccessTo(
                $protectedObjects[$controller]['objectName'],
                $protectedObjects[$controller]['action'],
                $protectedObjects[$controller]['objectId']
            );
            if ($accessLevel == 0) {    // для запрета на доступ ко всему контроллеру предпологается только 2 состояния: разрешено/не разрешено
                throw new AccessDeniedHttpException('You don\'t have permission to access this page');
            }
        }

        if (isset($protectedObjects[$controllerMethod])) {
            $accessLevel = $user->hasAccessTo(
                $protectedObjects[$controllerMethod]['objectName'],
                $protectedObjects[$controllerMethod]['action'],
                $protectedObjects[$controllerMethod]['objectId']
            );
            if ($accessLevel < $protectedObjects[$controllerMethod]['accessLevel']) {
                throw new AccessDeniedHttpException('You don\'t have permission to access this page');
            }

        }

        return $next($request);
    }
}
