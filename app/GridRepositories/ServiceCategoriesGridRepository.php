<?php

namespace App\GridRepositories;

use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Request;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class ServiceCategoriesGridRepository extends EloquentRepositoryAbstract {

    public function __construct()
    {
        $orgId = Request::user()->organization_id;

        $this->Database = DB::table('service_categories')
            ->where('organization_id', $orgId);

        $this->visibleColumns = [
            'service_category_id',
            'name',
            'online_reservation_name',
            'gender'
        ];

        $this->orderBy = [
            array('service_categories.name', 'asc'),
            //array('table_1.name', 'desc')
        ];
    }
}