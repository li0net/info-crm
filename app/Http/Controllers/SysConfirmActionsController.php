<?php

namespace App\Http\Controllers;

use App\User;
use View;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class SysConfirmActionsController extends Controller
{

    /**
     * Проверяет код и производит смену email для юзера
     *
     * @param $uid string user id
     * @param $code string secret code
     */
    public function confirmEmailChange($uid, $code) {
        $user = User::where('user_id', $uid)->where('confirmation_code', $code)->whereNotNull('new_email')->first();
        $isChanged = false;

        if ($user) {
            $user->email = $user->new_email;
            $user->new_email = null;
            $user->confirmation_code = null;
            $user->save();
            $isChanged = TRUE;
        }

        return view(
            'user.change_email_result',
            [
                'crmuser' => $user,
                'isChanged' => $isChanged
            ]
        );
    }
}