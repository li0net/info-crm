<?php

namespace App\Http\Controllers\Auth;

use App\Organization;
use App\SuperOrganization;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;

/**
 * Class RegisterController
 * @package %%NAMESPACE%%\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('adminlte::auth.register');
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'orgname' => 'required|max:150',
            'name' => 'required|max:110',
            'phone' => 'max:25',
            'email' => 'required|email|max:70|unique:users',
            'password' => 'required|min:5|confirmed',
            'terms' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),

        ];
        if (isset($data['phone']) AND trim($data['phone'])!=='') {
            $userData['phone'] = trim($data['phone']);
        }

        DB::beginTransaction();
        $su = SuperOrganization::forceCreate([
            'name' => $data['orgname']
        ]);

        $org = Organization::forceCreate([
            'name' => $data['orgname'],
            'super_organization_id' => $su->super_organization_id,
            'email' => $data['email']
        ]);

        $usr = new User();
        $usr->fill($userData);
        $usr->organization_id = $org->organization_id;      // устанавливаем отдельно, т.к. пакетная установка этого поля запрещена
        $usr->save();
        DB::commit();

        return $usr;
    }
}
