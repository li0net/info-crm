<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('adminlte::auth.login');
    }

    /**
     * Where to redirect users after login.
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
        $this->middleware(
            'guest',
            [
                'except' => [
                    'logout',
                    'changeBranch'
                ]
            ]
        );
    }

    public function logout() {
        auth()->logout();
        return redirect('/home');
    }

    public function changeBranch(Request $request, $orgId) {
        /*
        1) проверить, что $orgId имеет тот же super_organization_id что и текущая организация юзера
        (2) проверить, что у юзера есть разрешенеи логинится в другие филиалы - ПОКА НЕ ДЕЛАЕМ
        3) получить и запомнить реферер
        4) установить в сессию branch_id
        5) редиректить на запомненный реферер (если это какая-то запись или любая привязанная к организации сущность - будет ошибка) - ПРОСТО РЕДИРЕКТИМ на главную
        */

        $branches = $request->user()->organization->superOrganization->organizations;
        $found = false;
        foreach($branches AS $branch) {
            if ($orgId == $branch->organization_id) {
                $found = true;
                break;
            }
        }

        if ($found) {
            $request->session()->put('branch_id', $orgId);
            return response()->redirectTo('/home');
        }

        //echo $request->session()->get('branch_id', 'NOT FOUND');
    }
}
