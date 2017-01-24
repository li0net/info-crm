<?php

namespace App\GridRepositories;

use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use \Illuminate\Support\Facades\Request;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class ClientsCategoriesGridRepository extends EloquentRepositoryAbstract {

    public function __construct()
    {
        $orgId = Request::user()->organization_id;

        $this->Database = DB::table('client_categories')
            ->where('organization_id', $orgId);

        $this->visibleColumns = [
            'title',
            'cc_id',
            'color'
        ];

        $this->orderBy = [
            array('client_categories.title', 'asc')
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
            $row['title'] = "<a class='label' href='/clientCategories/edit/{$row['cc_id']}' style='background-color:#{$row['color']}; color: black;'>".
                    "<span class='fa fa-tag'>&nbsp;</span>".
                    "<span>{$row['title']}&nbsp;</span>".
                "</a>";
            unset($row['color']);
        }

        return $rows;
    }
}