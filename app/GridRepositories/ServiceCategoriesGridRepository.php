<?php

namespace App\GridRepositories;

use \Illuminate\Support\Facades\DB;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class ServiceCategoriesGridRepository extends EloquentRepositoryAbstract {

    public function __construct()
    {
        $this->Database = DB::table('service_categories');
            //->join('table_2', 'table_1.id', '=', 'table_2.id');

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