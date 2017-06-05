<?php

namespace App\GridRepositories;

use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Request;
use \Illuminate\Support\Facades\Log;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;

class OrganizationsGridRepository extends EloquentRepositoryAbstract {

    public function __construct()
    {
        $sOId = Request::user()->organization->superOrganization->super_organization_id;

        $search = request()->input('_search', 'false');
        $filters = request()->input('filters', NULL);

        $this->Database = DB::table('organizations')
            ->where('super_organization_id', $sOId);

        $this->visibleColumns = [
            'organizations.organization_id',
            'organizations.name',
            'organizations.country',
            'organizations.city',
            'organizations.address',
            'organizations.phone_1'
        ];

        $this->orderBy = [
            array('organization_id', 'asc')
        ];
    }


    public function getRows($limit, $offset, $orderBy = null, $sord = null, array $filters = array(), $nodeId = null, $nodeLevel = null, $exporting)
    {
        $rows = parent::getRows($limit, $offset, $orderBy, $sord, $filters, $nodeId, $nodeLevel, $exporting);

        foreach ($rows AS &$row) {

            if (trim($row['address']) != '') {
                $row['address'] = '<span style="font-size: 80%">' . $row['address'] . '</span>';

            }
        }

        return $rows;
    }
}