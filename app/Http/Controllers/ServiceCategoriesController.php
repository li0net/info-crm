<?php

namespace App\Http\Controllers;

use App\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceCategoriesController extends Controller
{

    public function __construct()
    {
        // TODO: убрать после доработки логина
        auth()->loginUsingId(1);

        $this->middleware('auth');
    }


    /**
     * Show the service categories list
     *
     * @return Response
     */
    public function index()
    {
        return view('adminlte::servicecategories');
    }

    /*
     * Data source for the grid
     * */
    public function gridData(Request $request)
    {
        //GET:rows=30&page=1&sidx=name&sord=asc
        /*
        {
            "total": "1",
            "page": "1",
            "records": "2",
            "rows" : [
                {
                    "id" :"1",
                    "cell" : [
                        "1",
                        "Мужские стрижки",
                        "Мужские стрижки фэшн",
                        "м"
                    ]
                },
                {
                    "id" :"2",
                    "cell" : [
                        "2",
                        "Женские стрижки",
                        "Женские стрижки фэшн",
                        "ж"
                    ]
                }
            ]
        }
        */

        // TODO: Add filter from GET

        $page = $request->input('page', 1);
        $numRows = $request->input('rows', 30);
        $orderBy = $request->input('sidx', 'name');
        $sortOrder = $request->input('sord', 'asc');

        if ($sortOrder != 'asc' AND $sortOrder != 'desc') $sortOrder = 'asc';
        if ($page < 1) $page = 1;
        if ($numRows < 1) $numRows = 30;

        $usr = $request->user();
        $usr->organization_id;

        $dbRes = DB::table('service_categories')
                ->select('service_category_id', 'name', 'online_reservation_name', 'gender')
                ->where('organization_id', $usr->organization_id)
                ->orderBy($orderBy, $sortOrder)
                ->offset(($page-1)*$numRows)
                ->limit($numRows)
                ->get();

        //$dbRes->to_array();
        // new stdClass();

        $data = new \stdClass();
        $data->page = $page;
        $data->rows = array();

        foreach ($dbRes AS $row) {
            $data->rows[] = new \stdClass();
            $data->rows[count($data->rows)-1]->id = $row->service_category_id;      // для общего случая $row->primaryKey ?

            // TODO: посмотреть форматировние на стороне jqGid ?
            if (is_null($row->gender)) {
                $gender = 'все';
            } elseif ($row->gender == 1) {
                $gender = 'м';
            } else {
                $gender = 'ж';
            }

            $data->rows[count($data->rows)-1]->cell = [
                $row->service_category_id, $row->name, $row->online_reservation_name, $gender
            ];
        }

        // получение общего количества записей в таблице, удовлетворяющих условиям
        // total number of records for the query
        $data->records = DB::table('service_categories')
            ->where('organization_id', $usr->organization_id)
            ->count();
        // total pages for the query
        $data->total = ceil($data->records/$numRows);

        echo json_encode($data);
    }

    public function view(ServiceCategory $serviceCategory) {
        return view('adminlte::servicecategoryview', compact('serviceCategory'));
    }

    // форма создания Категории услуг
    public function create() {
        $genderOptions = [
            [
                'value' => 'null',
                'label' => trans('main.service_category:gender_all')
            ],
            [
                'value' => '1',
                'label' => trans('main.service_category:gender_men')
            ],
            [
                'value' => '0',
                'label' => trans('main.service_category:gender_woman')
            ],
        ];
        return view('adminlte::servicecategoryform', compact('genderOptions'));
    }

    public function edit(ServiceCategory $serviceCategory) {

    }

    public function save(Request $request) {
        /*$request->all()

        Array
        (
            [_token] => 6Dsrc6u9SdMlj2Owzp1XxEPtrkTQBkz7YaHGYotp
            [name] => Спа
            [online_reservation_name] => Спа эксклюзив
            [gender] => 1
        )
        */

        $this->validate($request, [
            'name' => 'required|max:140',
            'online_reservation_name' => 'max:140',
            'gender' => 'required'
        ]);

        $scId = $request->input('service_category_id');
        // определить создание это или редактирование (по наличию поля service_category_id)
        // если редактирвоание - проверить что объект принадлежить текущему пользователю
        if (!is_null($scId)) {  // редактирование
            // update

        } else {
            $sc = new ServiceCategory();
            $sc->organization_id = $request->user()->organization_id;      // curr users's org id
            $sc->name = $request->input('name');
            $sc->online_reservation_name = $request->input('online_reservation_name');

            $gender = $request->input('gender');
            if ($gender !== 'null') {
                if ($gender == '1') {
                    $sc->gender = 1;
                } elseif ($gender == '0') {
                    $sc->gender = 0;
                }
            }
            $sc->save();
        }

        return redirect()->to('/serviceCategories');
    }
}
