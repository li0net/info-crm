<?php

namespace App\GridRepositories;

use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Request;
//use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
use App\Libraries\EloquentGridRepositoryCustom;

//class ClientsGridRepository extends EloquentRepositoryAbstract {
class ClientsGridRepository extends EloquentGridRepositoryCustom {

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

            'email',        // не отоюражается отдельной колонкой в гриде, но нужно для добавления в колонку Контакты вместе с телефоном
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


    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(), $nodeId = null, $nodeLevel = null, $exporting)
    {
        $rows = parent::getRows($limit, $offset, $orderBy, $sord, $filters, $nodeId, $nodeLevel, $exporting);

        //Log::info(__METHOD__.' Rows:'.print_r($rows, TRUE));
        /*
        Array
        (
            [0] => Array
                (
                    [title] => Вип
                    [cc_id] => 1
                )

        )
        */

        foreach ($rows AS &$row) {
            if (trim($row['email']) != '') {
                $row['phone'] .= '<br/><span style="color: #595959; font-size: 80%">'.$row['email'];
            }
            unset($row['email']);

            $row['name'] = "<a href='/client/{$row['client_id']}'>{$row['name']}</a>";

            $row['total_bought'] = round($row['total_bought'], 2);
        }

        return $rows;
    }
}