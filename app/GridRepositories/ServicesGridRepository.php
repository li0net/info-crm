<?php

namespace App\GridRepositories;

use \Illuminate\Support\Facades\DB;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class ServicesGridRepository extends EloquentRepositoryAbstract {

    public function __construct()
    {
        $this->Database = DB::table('services')
            ->join('service_categories', 'services.service_category_id', '=', 'service_categories.service_category_id');

        $this->visibleColumns = [
            'services.service_id',
            'services.name',
            'service_categories.name AS service_category_id',
            'services.description',
            'services.price_min',
            'services.price_max',
            'services.duration'
        ];

        $this->orderBy = [
            array('services.name', 'asc'),
            //array('table_1.name', 'desc')
        ];
    }
}