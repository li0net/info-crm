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

            if (empty($row['date_payed'])) {
                $rows[$i]['pay_button'] = "<a href='javascript:gridPayCW(\"{$row['cw_id']}\")'>".trans('main.calculated_wage:grid_pay_link')."</a>";
            } else {
                $rows[$i]['pay_button'] = '';
            }
        }

        return $rows;
    }
}