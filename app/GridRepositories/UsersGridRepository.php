<?php

namespace App\GridRepositories;

use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Request;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class UsersGridRepository extends EloquentRepositoryAbstract {

    public function __construct()
    {
        $orgId = Request::user()->organization_id;

        $this->Database = DB::table('users')
            //->join('access_permissions', 'users.users_id', '=', 'access_permissions.user_id')
            ->where('users.organization_id', $orgId);

        $this->visibleColumns = [
            'users.user_id',
            'users.name',
            'users.phone',
            'users.email',

            //'access_permissions.object',
            //'access_permissions.action'
        ];
        // TODO: не уверен что нужно делать эту выборку, будет множество строк на кадлого юзера (по кол-ву access_permissions для него)
        //  возможно, лучше делать запрос к access_permissions для каждого юзера
        //   или, что более эффективно, переопределить запрос для поссчета строк (по users без join)
        //   и обрабатывать результирующий массив для jqgrid, оставляя только уникальных users
        // TODO: process 'access_permissions.object', 'access_permissions.action' into one human readable description

        $this->orderBy = [
            array('users.name', 'asc'),
            //array('table_1.name', 'desc')
        ];
    }
}