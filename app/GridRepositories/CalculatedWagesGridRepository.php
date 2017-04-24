<?php

namespace App\GridRepositories;

use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Request;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use \Illuminate\Support\Facades\Log;

class CalculatedWagesGridRepository extends EloquentRepositoryAbstract {

    public function __construct($empId)
    {
        $orgId = Request::user()->organization_id;
        $employee = \App\Employee::where('organization_id', $orgId)->where('employee_id', $empId)->first();
        if (!$employee) {
            Log::error(__METHOD__." invalid employee_id:$empId given for organization $orgId");
            exit(0);
        }

        $this->Database = DB::table('calculated_wages')
            //->join('service_categories', 'services.service_category_id', '=', 'service_categories.service_category_id')
            ->where('employee_id', $empId);

        /*
        {index: 'cw_id', name: 'cw_id', key: true, width: 60, hidden: true, search: false},
            {index: 'wage_period_start', name: 'wage_period_start', width: 100, search: false},
            {index: 'wage_period_end', name: 'wage_period_end', width: 100, search: false},
            {index: 'total_amount', align:'left', name: 'total_amount', width: 70, search: false},
            {index: 'date_payed', align:'left', name: 'date_payed', width: 60, search: false},
            {index: 'pay_button', align:'left', name: 'pay_button', width: 60, search: false}
        */
        $this->visibleColumns = [
            'cw_id',
            'wage_period_start',
            'wage_period_end',
            'total_amount',
            'date_payed'
        ];

        $this->orderBy = [
            array('wage_period_start', 'desc'),
            //array('table_1.name', 'desc')
        ];
    }

    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(), $nodeId = null, $nodeLevel = null, $exporting)
    {
        $rows = parent::getRows($limit, $offset, $orderBy, $sord, $filters, $nodeId, $nodeLevel, $exporting);

        // проверяем есть у юзера права на просмотр телефонов клиентов
        //$showPhone = Request::user()->hasAccessTo('clients_phone', 'view', null);

        foreach ($rows AS $i=>$row) {
            if ($row['wage_period_start'] != '') {
                $rows[$i]['wage_period_start'] = date('Y-m-d G:i', strtotime($row['wage_period_start']));
            }
            if ($row['wage_period_end'] != '') {
                $rows[$i]['wage_period_end'] = date('Y-m-d G:i', strtotime($row['wage_period_end']));
            }

            $rows[$i]['total_amount'] = "<a href='/employees/downloadPayroll/{$row['cw_id']}'>{$row['total_amount']}</a>";
        }

        return $rows;
    }
}