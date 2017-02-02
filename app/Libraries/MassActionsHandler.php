<?php

namespace App\Libraries;

use \Illuminate\Support\Facades\Request;

class MassActionsHandler {

    /**
     * Database
     *
     * @var Illuminate\Database\Eloquent\Model or Illuminate\Database\Query
     *
     */
    protected $Database;

    public function __construct($db) {
        $this->Database = $db;
    }

    public function buildFiltersFromRequest() {
        $orgId = Request::user()->organization_id;
        $filters = Request()->input();

        $filters = $this->parseRequestFilters($filters);
        $this->applyFilters($filters);
        $this->Database->where('organization_id', $orgId);
        return $this->Database;
    }

    /**
     * Парсим фильтры переданные в jQGrid формате
     *
     * @param array get и post данные
     * @return array
     */
    protected function parseRequestFilters(array $postedData) {

        if(isset($postedData['filters']) && !empty($postedData['filters']))
        {
            $filters = json_decode(str_replace('\'','"',$postedData['filters']), true);
        }

        //filters: {"groupOp":"OR","rules":[{"field":"name","op":"cn","data":"Bryce"},{"field":"phone","op":"cn","data":"Bryce"}]}
        if(isset($filters['rules']) && is_array($filters['rules']))
        {
            foreach ($filters['rules'] as &$filter)
            {
                switch ($filter['op'])
                {
                    case 'eq': //equal
                        $filter['op'] = '=';
                        break;
                    case 'ne': //not equal
                        $filter['op'] = '!=';
                        break;
                    case 'lt': //less
                        $filter['op'] = '<';
                        break;
                    case 'le': //less or equal
                        $filter['op'] = '<=';
                        break;
                    case 'gt': //greater
                        $filter['op'] = '>';
                        break;
                    case 'ge': //greater or equal
                        $filter['op'] = '>=';
                        break;
                    case 'bw': //begins with
                        $filter['op'] = 'like';
                        $filter['data'] = $filter['data'] . '%';
                        break;
                    case 'bn': //does not begin with
                        $filter['op'] = 'not like';
                        $filter['data'] = $filter['data'] . '%';
                        break;
                    case 'in': //is in
                        $filter['op'] = 'is in';
                        break;
                    case 'ni': //is not in
                        $filter['op'] = 'is not in';
                        break;
                    case 'ew': //ends with
                        $filter['op'] = 'like';
                        $filter['data'] = '%' . $filter['data'];
                        break;
                    case 'en': //does not end with
                        $filter['op'] = 'not like';
                        $filter['data'] = '%' . $filter['data'];
                        break;
                    case 'cn': //contains
                        $filter['op'] = 'like';
                        $filter['data'] = '%' . $filter['data'] . '%';
                        break;
                    case 'nc': //does not contains
                        $filter['op'] = 'not like';
                        $filter['data'] = '%' . $filter['data'] . '%';
                        break;
                    case 'nu': //is null
                        $filter['op'] = 'is null';
                        $filter['data'] = '';
                        break;
                    case 'nn': //is not null
                        $filter['op'] = 'is not null';
                        $filter['data'] = '';
                        break;
                }
            }
        }
        else
        {
            $filters['rules'] = array();
        }

        return $filters;
    }

    /**
     * @param array $filters
     * @return Illuminate\Database\Query
     */
    protected function applyFilters(array $filters = array()) {
        return $this->Database->whereNested(function($query) use ($filters)
        {
            // Ruslan - не было поддержки OR для связи фильтров, добавил костыль
            $or = FALSE;
            if (isset($filters['groupOp']) AND strtolower($filters['groupOp']) == 'or') {
                $or = TRUE;
            }

            foreach ($filters['rules'] as $filter)
            {
                if($filter['op'] == 'is in')
                {
                    if (!$or) {
                        $query->whereIn($filter['field'], explode(',', $filter['data']));
                    } else {
                        $query->orWhereIn($filter['field'], explode(',', $filter['data']));
                    }
                    continue;
                }

                if($filter['op'] == 'is not in')
                {
                    if (!$or) {
                        $query->whereNotIn($filter['field'], explode(',', $filter['data']));
                    } else {
                        $query->orWhereNotIn($filter['field'], explode(',', $filter['data']));
                    }
                    continue;
                }

                if($filter['op'] == 'is null')
                {
                    if (!$or) {
                        $query->whereNull($filter['field']);
                    } else {
                        $query->orWhereNull($filter['field']);
                    }
                    continue;
                }

                if($filter['op'] == 'is not null')
                {
                    if (!$or) {
                        $query->whereNotNull($filter['field']);
                    } else {
                        $query->orWhereNotNull($filter['field']);
                    }
                    continue;
                }

                if (!$or) {
                    $query->where($filter['field'], $filter['op'], $filter['data']);
                } else {
                    $query->orWhere($filter['field'], $filter['op'], $filter['data']);
                }
            }
        });
    }
}