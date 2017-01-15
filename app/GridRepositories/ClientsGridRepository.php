<?php

namespace App\GridRepositories;

use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Request;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class ClientsGridRepository extends EloquentRepositoryAbstract {

    public function __construct()
    {
        $orgId = Request::user()->organization_id;

        $this->Database = DB::table('clients')
            //->join('access_permissions', 'users.users_id', '=', 'access_permissions.user_id')
            ->where('organization_id', $orgId);

        $this->visibleColumns = [
            'client_id',
            'name',
            'phone',
            'total_bought',
            'discount',
            //'email',
            //'category_id',
            //'importance',
            //'gender',
            //'birthday',
            //'comment',
            //'do_not_send_sms',
            //'birthday_sms',
            //'online_reservation_available',
            //'total_paid'
        ];

        $this->orderBy = [
            array('name', 'asc'),
            //array('table_1.name', 'desc')
        ];
    }
}