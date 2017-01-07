<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\User;
use App\AccessPermission;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{

    public function __construct()
    {
        //auth()->loginUsingId(1);

        $this->middleware('auth');
        $this->middleware('permissions');   //->only(['create', 'edit', 'save']);
    }

    // users grid
    public function index()
    {
        return view('adminlte::users');
    }

    public function edit(Request $request, User $user)
    {
        // Проверяем есть ли у юзера права на управление пользователями
        $accessLevel = $request->user()->hasAccessTo('settings_manage_users', 'edit', 0);
Log::info(__METHOD__.' $request->user()->user_id:'.$request->user()->user_id.' accessLevel:'.print_r($accessLevel, TRUE));
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        return view('adminlte::userform', compact('user'));
    }

    public function create(Request $request)
    {
        // Проверяем есть ли у юзера права на управление пользователями
        $accessLevel = $request->user()->hasAccessTo('settings_manage_users', 'edit', 0);
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        return view('adminlte::userform');
    }

    public function savePermissions(Request $request, User $user)
    {
        // Проверяем есть ли у юзера права на управление пользователями
        $accessLevel = $request->user()->hasAccessTo('settings_manage_users', 'edit', 0);
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        $fieldNameToPermissions = [
            'appointment_form_view'     =>[
                'object'        => 'appointment_form',
                'action'        => 'view',
                'object_id'     => NULL,
                'access_level'  => 1
            ],
            'appointment_create'     =>[
                'object'        => 'appointment',
                'action'        => 'create',
                'object_id'     => '0',
                'access_level'  => 1
            ],
            'appointment_edit'     =>[
                'object'        => 'appointment',
                'action'        => 'edit',
                'object_id'     => '0',
                'access_level'  => 1
            ],
            'appointment_delete'     =>[
                'object'        => 'appointment',
                'action'        => 'delete',
                'object_id'     => '0',
                'access_level'  => 1
            ],
            'appointment_client_data_view' =>[
                'object'        => 'appointment_client_data',
                'action'        => 'view',
                'object_id'     => '0',
                'access_level'  => 1
            ],

            'settings_view'     =>[
                'object'        => 'settings',
                'action'        => 'view',
                'object_id'     => NULL,
                'access_level'  => 1
            ],
            'settings_manage_users_edit'     =>[
                'object'        => 'settings_manage_users',
                'action'        => 'edit',
                'object_id'     => '0',
                'access_level'  => 1
            ],
            'service_edit'     =>[
                'object'        => 'service',
                'action'        => 'edit',
                'object_id'     => '0',
                'access_level'  => 1
            ],
            'service_delete'     =>[
                'object'        => 'service',
                'action'        => 'delete',
                'object_id'     => '0',
                'access_level'  => 1
            ],
            'employee_edit'     =>[
                'object'        => 'employee',
                'action'        => 'edit',
                'object_id'     => '0',
                'access_level'  => 1
            ],
            'employee_delete'     =>[
                'object'        => 'employee',
                'action'        => 'delete',
                'object_id'     => '0',
                'access_level'  => 1
            ],
            'schedule_edit'     =>[
                'object'        => 'schedule',
                'action'        => 'edit',
                'object_id'     => '0',
                'access_level'  => 1
            ]
        ];

        $userCurrPermissions = $user->accessPermissions();

        // Для чекбоксов (для селектов и других расширенных пермишенсов надо будет добавить обработку)
        $formData = $request->all();
        foreach ($formData AS $field=>$data) {
            $hasSuchPermission = FALSE;
            foreach ($userCurrPermissions AS $permission) {
                if ($permission->object == $fieldNameToPermissions[$field]['object'] AND $permission->action == $fieldNameToPermissions[$field]['action']) {
                    $hasSuchPermission = TRUE;
                    if ($permission->access_level != $data) {
                        $permission->access_level = $data;
                        $permission->save();
                    }
                }

                // Если такое разрешение еще не было установлено, создаем его
                if (!$hasSuchPermission) {
                    $accessPermission = new AccessPermission();
                    $accessPermission->object = $fieldNameToPermissions[$field]['object'];
                    $accessPermission->action = $fieldNameToPermissions[$field]['action'];
                    $accessPermission->access_level = $data;
                    if ($field == 'appointment_form_view' OR $field == 'settings_view') {
                        $accessPermission->object_id = NULL;
                    } else {
                        $accessPermission->object_id = '0';
                    }
                    $accessPermission->save();
                }
            }
        }

        redirect('/users');
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:110',
            'info' => 'max:255',
            'email' => 'required|max:70|email',
            'phone' => 'required|phone_crm'
        ]);

        $userId = $request->input('user_id');
        // определить создание это или редактирование (по наличию поля user_id)

        if (!is_null($userId)) {  // редактирование
            $user = User::find($userId);
            if (is_null($user)) {
                return 'Record doesn\'t exist';
            }

        } else {    // создание
            $user = new User();
            $user->is_admin = 0;
        }

        $user->name = $request->input('name');
        $user->info = $request->input('phone');
        $user->email = $request->input('email');
        $user->phone = $user->normalizePhoneNumber($request->input('phone'));
        $user->save();

        // TODO: create default access right records?
        redirect('/users');
    }
}
