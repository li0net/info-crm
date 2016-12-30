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
            'AppointmentsJournalController'        => [     // контроллер для работы с существующими Записями визитов (отображение на календаре и в расписании)
                'objectName'    => 'appointments',
                'action'        => 'view',
                'objectId'      => NULL,
                'accessLevel'  => 1
            ],
            'AppointmentsController'        => [
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
