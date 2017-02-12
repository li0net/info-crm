<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('adminlte::auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

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
     * Проверяет код и производит смену email для юзера
     *
     * @param $uid string user id
     * @param $code string secret code
     */
    public function confirmEmailChange($uid, $code) {
        $user = User::where('user_id', $uid)->where('confirmation_code', $code)->first();
        $isChanged = false;

        if ($user) {
            $user->email = $user->new_email;
            $user->new_email = null;
            $user->save();
            $isChanged = TRUE;
        }

        return view(
            'user::change_email_result',
            [
                'crmuser' => $user,
                'isChanged' => $isChanged
            ]
        );
    }
}
