<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\User;
use App\AccessPermission;
use Illuminate\Support\Facades\Log;
use Session;

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
        $newUserUrl = action('UsersController@create');
        return view('adminlte::users', compact('newUserUrl'));
    }

    public function edit(Request $request, User $user)
    {
        // Проверяем есть ли у юзера права на управление пользователями
        $accessLevel = $request->user()->hasAccessTo('settings_manage_users', 'edit', 0);
        //Log::info(__METHOD__.' $request->user()->user_id:'.$request->user()->user_id.' accessLevel:'.print_r($accessLevel, TRUE));
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        return view('adminlte::userform', ['crmuser' => $user]);
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
            'service_edit'      =>[
                'object'        => 'service',
                'action'        => 'edit',
                'object_id'     => '0',
                'access_level'  => 1
            ],
            'service_delete'    =>[
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
            'employee_delete'   =>[
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
            ],
            'clients_view'      =>[
                'object'        => 'clients',
                'action'        => 'view',
                'object_id'     => NULL,
                'access_level'  => 1
            ]
        ];

        $userCurrPermissions = $user->accessPermissions()->get();

        // Для чекбоксов (для селектов и других расширенных пермишенсов надо будет добавить обработку)
        $formData = $request->all();
        unset($formData['_token'], $formData['user_id']);
        foreach ($fieldNameToPermissions AS $inputName => $data) {
            if (!isset($formData[$inputName])) {
                $formData[$inputName] = '0';
            }
        }

        foreach ($formData AS $field=>$data) {
            $hasSuchPermission = FALSE;
            foreach ($userCurrPermissions AS $permission) {
                //Log::info(__METHOD__ . ' user current permission:' . $permission->object . ' action:' . $permission->action);
                if ($permission->object == $fieldNameToPermissions[$field]['object'] AND $permission->action == $fieldNameToPermissions[$field]['action']) {
                    $hasSuchPermission = TRUE;
                    if ($permission->access_level != $data) {
                        $permission->access_level = $data;
                        $permission->updated_by = $request->user()->user_id;
                        $permission->save();
                    }
                }
            }

            // Если такое разрешение еще не было установлено, создаем его
            if (!$hasSuchPermission) {
                $accessPermission = new AccessPermission();
                $accessPermission->user_id = $user->user_id;
                $accessPermission->object = $fieldNameToPermissions[$field]['object'];
                $accessPermission->action = $fieldNameToPermissions[$field]['action'];
                $accessPermission->access_level = $data;
                if ($field == 'appointment_form_view' OR $field == 'settings_view') {
                    $accessPermission->object_id = NULL;
                } else {
                    $accessPermission->object_id = '0';
                }
                $accessPermission->updated_by = $request->user()->user_id;
                $accessPermission->save();

                $hasSuchPermission = FALSE;
            }
        }

        return redirect('/users');
    }

    public function save(Request $request)
    {
        // нужно подготовить (нормализовать) номер телефона, чтобы при дальнейшей валидации можно было проверить его уникальность
        if ($request->input('phone')) {
            $user = new User();
            $request->merge(array('phone' => $user->normalizePhoneNumber($request->input('phone'))));
        }

        $this->validate($request, [
            'name' => 'required|max:110',
            'info' => 'max:255',
            'email' => 'required|max:70|email|unique:users,email',
            'phone' => 'required|phone_crm|unique:users,phone',
            'password' => 'required_with:user_id|min:7'
        ]);

        $userId = $request->input('user_id');
        // определить создание это или редактирование (по наличию поля user_id)

        $isCreating = FALSE;
        if (!is_null($userId)) {  // редактирование
            $user = User::where('organization_id', request()->user()->organization_id)->where('user_id', $userId)->first();
            if (is_null($user)) {
                return 'Record doesn\'t exist';
            }

        } else {    // создание
            $isCreating = TRUE;
            $user = new User();
            $user->organization_id = $request->user()->organization_id;
            $user->is_admin = 0;
            $user->password = bcrypt($request->input('password'));
        }

        $user->name = $request->input('name');
        $user->info = $request->input('info');
        $user->email = $request->input('email');
        $user->phone = $user->normalizePhoneNumber($request->input('phone'));
        $user->save();

        // TODO: create default access right records?

        if ($isCreating) {
            Session::flash('success', trans('main.user:creation_success_message'));
        }
        return redirect('/users');
    }

    public function editOwnSettings(Request $request) {
        return view('user.cabinet', [
            'crmuser' => $request->user()
        ]);
    }

    public function saveAvatar(Request $request) {
        //dd($_FILES);
        $data = $request->all();
        dd($data);

        //$request->input('avatar');
        $result = ['success' => FALSE, 'error' => ''];

        // Проверяем, действительно ли загруженный файл - изображение
        if(isset($_FILES["avatar"]["tmp_name"]) AND trim($_FILES["avatar"]["tmp_name"]) != '') {
            $targetDir = public_path()."/uploaded_images/avatar/";
            $imageUploadErrors = array();
            $imageFileType = pathinfo($targetDir.basename($_FILES["avatar"]["name"]), PATHINFO_EXTENSION);
            $targetDir = $targetDir . $request->user()->organization_id . '/';
            $targetFile = $targetDir . $request->user()->user_id . '.' .$imageFileType;

            $check = getimagesize($_FILES["avatar"]["tmp_name"]);
            if($check === false) {
                $imageUploadErrors[] = "File is not an image";
            }

            // не более 5Мбайт
            if ($_FILES["logo_image"]["size"] > 5242880) {
                $imageUploadErrors[] = "Sorry, your file is too large (images smaller than 5Mb supported)";
            }

            if (count($imageUploadErrors) > 0) {
                /*return back()
                    ->withErrors( new MessageBag(array('logo_image' => $imageUploadErrors)) )
                    ->withInput();
                */
                $result['error'] = implode("\n", $imageUploadErrors);
                return json_encode($result);

            } else {
                // if everything is ok, try to upload file
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                if (!move_uploaded_file($_FILES["logo_image"]["tmp_name"], $targetFile)) {
                    Log::error('Failed to move uploaded file', ['targetFile' => $targetFile]);
                }
            }

            $result['success'] = true;
        }

        return json_encode($result);
    }

    public function saveMailingSettings(Request $request) {
        $data = $request->all();
        dd($data);
    }
}
