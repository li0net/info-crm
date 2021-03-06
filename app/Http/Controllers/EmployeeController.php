<?php

namespace App\Http\Controllers;

use App\CalculatedWage;
use App\Item;
use App\ScheduleScheme;
use App\Schedule;
use App\WageScheme;
use Dompdf\Exception;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Employee;
use App\EmployeeSetting;
use App\Position;
use App\Card;
use App\ServiceCategory;
use App\Service;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Validator;
use Carbon\Carbon;
use \Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permissions')->only(['update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::select('employee_id', 'name', 'email', 'phone', 'position_id', 'avatar_image_name')
            ->where('organization_id', $request->user()->organization_id)
            ->with(['position' => function($query) { $query->select('position_id', 'title'); }])
            ->with(['settings' => function($query) { $query->select('employee_id', 'is_rejected'); }])
            ->get()
            ->filter(function ($employee) {
                return 1 !== $employee->settings->is_rejected;
            });

//        dd($employees);

        $user = $request->user();
        $positions = Position::where('organization_id', $request->user()->organization_id)->orderBy('title')->pluck('title', 'position_id');

        $page = Input::get('page', 1);
        $paginate = 10;

        $offset = ($page * $paginate) - $paginate;
        $itemsForCurrentPage = $employees->slice($offset, $paginate);
        $employees = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($employees), $paginate, $page);
        $employees->setPath('employee');

        return view('employee.index', compact('user', 'employees', 'positions'));
    }

    public function indexFiltered(Request $request)
    {
        $employees = Employee::select('employee_id', 'name', 'email', 'phone', 'position_id', 'avatar_image_name')
            ->where('organization_id', $request->user()->organization_id)
            ->with(['settings' => function($query) { $query->select('employee_id', 'is_rejected'); }])
            ->get();

        if('' !== $request->position_id) {
            $position_id =  $request->position_id;
            $employees = $employees->filter(function ($employee) use ($position_id) {
                return $employee->position_id == $position_id;
            });
        }

        if('' !== $request->is_fired) {
            $is_fired = $request->is_fired;
            $employees = $employees->filter(function ($employee) use ($is_fired) {
               return $employee->settings->is_rejected == $is_fired;
            });
        }
//        TODO : Реализовать фильтр по признаку is_deleted
//        if('' !== $request->employee_id) {
//            $payments->where('beneficiary_type', 'employee')->where('beneficiary_id', $request->employee_id);
//        }

        $page = (0 == $request->page) ? 1 : $request->page;
        $paginate = 10;

        $offset = ($page * $paginate) - $paginate;
        $itemsForCurrentPage = $employees->slice($offset, $paginate);
        $employees = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($employees), $paginate, $page);
        $employees->setPath('employee');
        $employees->appends(['index' => 'filtered']);

        return View::make('employee.list', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $positions = Position::where('organization_id', $request->user()->organization_id)->orderBy('title')->pluck('title', 'position_id');

        return view('employee.create', compact('positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:150',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|phone_crm'
        ]);

        $employee = new Employee;
        $settings = new EmployeeSetting;

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->spec = $request->spec;
        $employee->descr = $request->descr;
        $employee->organization_id = $request->user()->organization_id;
        $employee->position_id = $request->position_id;
        if ($request->file('avatar') !== null) {
            $imageName = time().'.'.$request->file('avatar')->getClientOriginalExtension();

            $request->file('avatar')->move(public_path('images'), $imageName);

            $employee->avatar_image_name = $imageName;
        }

        $employee->save();

        $settings->employee_id = $employee->employee_id;
        $settings->session_start = '0';
        $settings->session_end = '0';
        $settings->revenue_pctg = 50;
        $settings->wage_scheme_id = 0;
        $settings->schedule_id = 0;
        $settings->reg_permitted = 1;	// по умолчанию разрешаем запись через виджет
        $settings->reg_permitted_nomaster = 1;

        $settings->save();

        Session::flash('success', 'Новый сотрудник успешно сохранен!');

        return redirect()->route('employee.show', $employee->employee_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::where('organization_id', request()->user()->organization_id)->where('employee_id', $id)->first();

        if (!$employee) {
            return 'No such record!';
        }

        return view('employee.show', ['user' => request()->user()])->withEmployee( $employee );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $dash = '---';
        $employee = Employee::where('employee_id', $id)->where('organization_id', $request->user()->organization_id)->first();
        if (!$employee) {
            abort(404, 'No such employee found');
        }
        $settings = EmployeeSetting::where('employee_id', $employee->employee_id)->get()->all();

        $items = Position::where('organization_id', $request->user()->organization_id)->orderBy('title')->pluck('title', 'position_id');

        $sessionStart = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 15, 'c ', '', 'H:i');
        $sessionEnd = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 15, 'по ', '', 'H:i');
        $addInterval = $this->populateTimeIntervals(strtotime('00:45:00'), strtotime('04:00:00'), 15, '', '', 'H:i');
        array_unshift($addInterval, $dash);
        $service_duration_hours = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('09:00:00'), 60, '', ' ч', 'G');
        $service_duration_minutes = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('00:45:00'), 15, '', ' мин', 'i');
        //Log::info(__METHOD__.' $service_duration_hours:'.print_r($service_duration_hours, TRUE));

        $service_routings = Card::where('organization_id', $request->user()->organization_id)->pluck('title', 'card_id');
        $serviceCategories = ServiceCategory::where('organization_id', $request->user()->organization_id)->with('services')->get();
        $employee_services = [];
        foreach($serviceCategories AS $sc) {
            $services = $sc->services()->get();
            foreach($services AS $service) {
                $employee_services[$service->service_id] = $service->name;
            }
        }
        //Log::info(__METHOD__.' $employee_services:'.print_r($employee_services, TRUE));

        $employee_attached_services = $employee->services()->with('resources')->get();
        //$resources_attached_service = $services->resources()->get();
        $resources_attached_service = [];
        foreach($employee_attached_services AS $es) {
            $resources_attached_service[] = $es->resource;
            //Log::info(__METHOD__.' $employee_attached_services elem:'.$es->pivot->duration);
            Log::info(__METHOD__.' $employee_attached_services elem:'.$es->pivot->service_id);
        }

        // по умолчанию получаем расписание для текущей ненедели
        $sheduleStartDate = Carbon::parse('this monday')->toDateString();

        return view('employee.edit', [
            'employee' => $employee,
            'settings' => $settings,
            'items' => $items,
            'sessionStart' => $sessionStart,
            'sessionEnd' => $sessionEnd,
            'addInterval' => $addInterval,
            'wageSchemeOptions' => $this->getWageSchemeOptions(),
            'employee_attached_services' => $employee_attached_services,
            'resources_attached_service' => $resources_attached_service,
            'employee_services' => $employee_services,
            'service_duration_hours' => $service_duration_hours,
            'service_duration_minutes' => $service_duration_minutes,
            'service_routings' => $service_routings,
            'crmuser' => $request->user(),
            'shedule_data' => json_encode($this->getScheduleData($employee, $sheduleStartDate))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Проверяем есть ли у юзера права на редактирование Персонала
        $accessLevel = $request->user()->hasAccessTo('employee', 'edit', 0);
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        $this->validate($request, [
            // 'name' => 'required'
            // 'email' => 'required',
            // 'phone' => 'required'
            // 'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $validator = Validator::make($request->all(), [
            'online_reg_notify' => 'exists'
        ]);

        $employee = Employee::where('organization_id', $request->user()->organization_id)->where('employee_id', $id)->first();
        if (is_null($employee)) {
            return 'No such employee';
        }

        $settings = EmployeeSetting::where('employee_id', $employee->employee_id)->get()->all();
        if (is_null($settings)) {
            return 'No such settings';
        }

        if ($request->input('id') == 'employee_form__info') {
            $employee->name = $request->input('name');
            // $employee->email = $request->input('email');
            // $employee->phone = $request->input('phone');
            $employee->spec = $request->input('spec');
            $employee->descr = $request->input('descr');
            $employee->position_id = $request->position_id;

            if ($request->file('avatar') !== null) {
                $imageName = time().'.'.$request->file('avatar')->getClientOriginalExtension();

                $request->file('avatar')->move(public_path('uploaded_images'), $imageName);

                $employee->avatar_image_name = $imageName;
            }

            $employee->save();
        }

        if ($request->input('id') == 'employee_form__settings') {
            $settings[0]->online_reg_notify = $request->input('online_reg_notify');
            $settings[0]->phone_reg_notify = $request->input('phone_reg_notify');
            $settings[0]->online_reg_notify_del = $request->input('online_reg_notify_del');
            $settings[0]->phone_for_notify = $request->input('phone_for_notify');
            $settings[0]->email_for_notify = $request->input('email_for_notify');
            $settings[0]->online_reg_notify = $request->input('online_reg_notify');
            $settings[0]->client_data_notify = $request->input('client_data_notify');
            $settings[0]->reg_permitted = $request->input('reg_permitted');
            $settings[0]->reg_permitted_nomaster = $request->input('reg_permitted_nomaster');

            //TODO: Обрабатывать значения этих полей
            $settings[0]->session_start = $request->input('session_start');
            $settings[0]->session_end = $request->input('session_end');
            $settings[0]->add_interval = $request->input('add_interval');

            $settings[0]->show_rating = $request->input('show_rating');
            $settings[0]->is_rejected = $request->input('is_rejected');
            $settings[0]->is_in_occupancy = $request->input('is_in_occupancy');
            $settings[0]->revenue_pctg = $request->input('revenue_pctg');
            $settings[0]->sync_with_google = $request->input('sync_with_google');
            $settings[0]->sync_with_1c = $request->input('sync_with_1c');

            $settings[0]->save();
        }

        Session::flash('success', 'Данные сотрудника успешно сохранены!');

        return redirect()->route('employee.show', $employee->employee_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::where('organization_id', request()->user()->organization_id)->where('employee_id', $id)->first();
        $settings = EmployeeSetting::where('employee_id', $employee->employee_id)->get()->all();

        if ($employee) {
            $employee->delete();
            $settings[0]->delete();
            Session::flash('success', 'Сотрудник был успешно удален!');
        } else {
            Session::flash('error', 'Сотрудник не найден');
        }

        return redirect()->route('employee.index');
    }

    /**
     * Сохраняет связь работника со схемой начисления зарплаты
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateWageScheme(Request $request) {
        // employee_id
        // wage_scheme_id
        // scheme_start

        //Проверяем есть ли у юзера права на редактирование Персонала
        $accessLevel = $request->user()->hasAccessTo('employee', 'edit', 0);
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }
        $accessLevel = $request->user()->hasAccessTo('wage_schemes', 'edit', 0);
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        $validator = Validator::make($request->all(),
            [
                'employee_id' => 'required|numeric',
                'scheme_start' => 'date',
                'wage_scheme_id' => 'numeric'
            ]
        );
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                //->with('clientCategoriesOptions', $this->prepareClientCategoriesOptions())
                ->withInput();
        }

        $employee = Employee::where('organization_id', $request->user()->organization_id)->where('employee_id', $request->input('employee_id'))->first();
        if (!$employee) {
            abort(403, 'Unauthorized action or employee has been deleted.');
        }

        $ws = WageScheme::where('organization_id', $request->user()->organization_id)->where('scheme_id', $request->input('wage_scheme_id'))->first();
        if (!$ws) {
            abort(403, 'Unauthorized action or wage scheme has been deleted.');
        }

        $scheme_start = $request->input('scheme_start').' 00:00:00';

        if ( ! $employee->wageSchemes()->sync([$ws->scheme_id => ['scheme_start' => $scheme_start]])) {
            echo json_encode(['success' => false, 'error' => 'Internal server error when adding category']);
            Session::flash('error', trans('main.employee:sync_wage_schemes_error_message'));
            return redirect()
                ->back()
                ->withInput();
        }

        Session::flash('success', trans('main.employee:sync_wage_schemes_success_message'));
        return redirect()->route('employee.show', $employee->employee_id);
    }

    public function updateServices(Request $request) {
        /*
        array:7 [▼
          "_method" => "PUT"
          "_token" => "f24KpyJHKEyyXLQVpzAFaOYXvO19jvN9m1t8NefI"
          "employee_id" => "3"
          "employee-service" => array:2 [▼
            0 => "1"
            1 => "12"
          ]
          "service-duration-hour" => array:2 [▼
            0 => "0"
            1 => "0"
          ]
          "service-duration-minute" => array:2 [▼
            0 => "15"
            1 => "45"
          ]
          3 => ""
        ]
        */

        //Проверяем есть ли у юзера права на редактирование Персонала
        $accessLevel = $request->user()->hasAccessTo('employee', 'edit', 0);
        if ($accessLevel < 1) {
            throw new AccessDeniedHttpException('You don\'t have permission to access this page');
        }

        $validator = Validator::make($request->all(),
            [
                'employee_id' => 'required|numeric'
            ]
        );
        if ($validator->fails()) {
            // TODO: передавать все списки необходимые для построения формы
            return redirect()
                ->back()
                ->withErrors($validator)
                //->with('clientCategoriesOptions', $this->prepareClientCategoriesOptions())
                ->withInput();
        }

        $employee = Employee::where('organization_id', $request->user()->organization_id)->where('employee_id', $request->get('employee_id'))->first();
        if (!$employee) {
            return response()->json(['success' => false, 'error' => '']);
        }

        //$employee->services()->detach();
        $input = $request->input();
        if (isset($input['employee-service'])) {
            $dataToSync = [];
            for ($i = 0; $i < count($input['employee-service']); $i++) {
                $time = Carbon::createFromTime(
                    $input['service-duration-hour'][$i],
                    $input['service-duration-minute'][$i],
                    0
                );

                $serviceRouting = null;
                if (isset($input['service-routing'][$i])) {
                    $serviceRouting = $input['service-routing'][$i];
                }

                $dataToSync[$input['employee-service'][$i]] = ['duration' => $time, 'routing_id' => $serviceRouting];
            }

            Log::info(__METHOD__.' preparing to sync:'.var_export($dataToSync, TRUE));
            if (count($dataToSync) > 0) {
                $employee->services()->sync(
                    $dataToSync
                );
            }
        }

        return redirect()->to('/employee');
    }

    protected function populateTimeIntervals($startTime, $endTime, $interval, $modifier_before, $modifier_after, $time_format) {
        $timeIntervals = [];

        while ($startTime <= $endTime) {
            $timeStr = date($time_format, $startTime);
            $timeIntervals[$timeStr] = $modifier_before.$timeStr.$modifier_after;

            $startTime += 60*$interval;
        }

        return $timeIntervals;
    }

    protected function getWageSchemeOptions() {
        $wageSchemeOptions = [];
        $ws = WageScheme::where('organization_id', request()->user()->organization_id)->get();

        foreach ($ws AS $scheme) {
            $wageSchemeOptions[] = [
                'value'     => $scheme->scheme_id,
                'label'     => $scheme->scheme_name     // возможно стоит добавить параметры в кратком виде, например "50%/30%/500p(er)d(ay)"
            ];
        }

        return $wageSchemeOptions;
    }

    public function getServiceOptions(Request $request) {
        if($request->ajax()){
            $options = Service::join('service_categories', 'service_categories.service_category_id', '=', 'services.service_category_id')->
                where('service_categories.organization_id', $request->user()->organization_id)->pluck('services.name', 'services.service_id');
            $data = view('services.options', compact('options'))->render();
            return response()->json(['options' => $data]);
        }
    }

    /**
     * получение массива данных для построения расписания сотрудника
     * @param Employee $employee
     * @param $scheduleStartDate
     * @return array
     */
    private function getScheduleData(Employee $employee, $scheduleStartDate) {
        //метод должен возпрашщать массив, даже если расписания нет  -
        //в таком случае подмассивы в $shData.schedule протсо должны быть пусты
        $schedule = [
            0 => [], 1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => []
        ];

        //$scheduleScheme = $employee->scheduleScheme()->first();

        // если есть расписание на заданную дату, заполяем массив
        $scheduleScheme = $employee->getScheduleSchemeByDate($scheduleStartDate);
        if ($scheduleScheme) {
            $tmpSchedule = json_decode($scheduleScheme->schedule);
            foreach ($tmpSchedule AS $day => $hours) {
                $schedule[$day] = $hours;
            }

            $scheduleStartDate = $scheduleScheme->start_date;
        }
        $lastDate = strtotime("$scheduleStartDate + 6 days");

        $shData = [
            'employee_id' => $employee->employee_id,
            'start_date'  => $scheduleStartDate,
            'schedule'    => $schedule,
            'fill_weeks' => $scheduleScheme ? $scheduleScheme->fill_weeks : 0,
            'lastDate' => date('Y-m-d', $lastDate)
        ];

        return $shData;
    }

    /**
     * Получение расписания по ajax
     * @param Request $request
     * @return mixed
     */
    public function getSchedule(Request $request) {
        $empId = $request->get('employee_id');
        if (is_null($empId)) {
            return response()->json([
                'res' => false,
                'error' => 'Invalid employee id given'
            ]);
        }

        $employee = Employee::where('organization_id', $request->user()->organization_id)->where('employee_id', $empId)->first();
        if (!$employee) {
            return response()->json([
                'res' => false,
                'error' => 'No such employee found'
            ]);
        }

        if($request->ajax()){
            $result = [
                'res' => true,
                'shedule_data' => $this->getScheduleData($employee, $request->start_date)
            ];
            return response()->json($result);
        }
    }

    /**
     * обработчки сабмита настройки расписания сотрудника
     * @param Request $request
     * @return mixed
     */
    public function updateSchedule(Request $request) {
        $formData = $request->input('scheduleData');
        if (!$formData) {
            return response()->json([
                'res' => false,
                'error' => 'No schedule data'
            ]);
        }

        /*
        array:5 [
            "employee_id" => "3"
            "start_date" => "2017-04-24"
            "schedule" => array:7 [
              0 => array:5 [
                0 => "1"
                1 => "4"
                2 => "8"
                3 => "10"
                4 => "16"
              ]
              1 => array:3 [
                0 => "9"
                1 => "12"
                2 => "19"
              ]
              2 => array:1 [
                0 => "23"
              ]
              3 => array:2 [
                0 => "0"
                1 => "7"
              ]
            ]
            "fill_weeks" => "3"
        ]
        */

        $validator = Validator::make($formData, [
            'employee_id'   => 'required',
            'start_date'    => 'required|date_format:"Y-m-d"',    // date
            'fill_weeks'    => 'required|numeric|max:30',
            'schedule'      => 'required'
        ]);
        if ($validator->fails()) {
            $errs = $validator->messages();
            //Log::info(__METHOD__.' validation errors:'.print_r($errs, TRUE));

            return response()->json([
                'res' => false,
                'error' => 'Validation error',
                'validation_errors' => $errs
            ]);
        }

        Log::info(__METHOD__." formData:".var_export($formData, TRUE));

        $employee = Employee::where('organization_id', $request->user()->organization_id)->where('employee_id', $formData['employee_id'])->first();
        if (is_null($employee)) {
            return response()->json([
                'res' => false,
                'error' => 'Incorrect employee'
            ]);
        }

        $startDate = $formData['start_date'];
        if (1 != date('w', strtotime($startDate))) {       // проверяем, что переданная дата является понедельником
            return response()->json([
                'res' => false,
                'error' => 'Start date should be monday'
            ]);
            // можно просто автоматически брать понедельник на неделе в которую попадает переданная дата
            // $diff = (int)date('w', strtotime($startDate)) - 1;
            // $monday = date('Y-m-d', strtotime($startDate." +$diff days"));
        }

        $scheduleArr = $formData['schedule'];
        $scheduleIntervals = [];

        foreach($scheduleArr AS $dCount=>$hours) {
            if ((int)$dCount < 0 OR (int)$dCount > 6) {
                //return json_encode([
                return response()->json([
                    'res' => false,
                    'error' => 'Incorrect schedule data (day)'
                ]);
            }

            // если мы перескочили на новый день, а интервал не закрыт, нужно записать последний час предыдущей итерации цикла (дня) как конец открытого интервала
            if (count($scheduleIntervals) > 0 AND !isset($scheduleIntervals[count($scheduleIntervals)-1]['end'])) {
                // предполагаем, что как минимум одна итерация уже была, иначе $lastDayNum и $prevHour будут неопределены
                $prevHourEnd = $prevHour + 1;       // если выбран, к примеру 9й час, то это значит что расписание будет действовать до начала 10го часа, т.е. до 10:00
                $prevIntervalTs = strtotime("$startDate + $lastDayNum days $prevHourEnd hours");
                $scheduleIntervals[count($scheduleIntervals)-1]['end'] = date('Y-m-d H:i:s', $prevIntervalTs);
            }

            $prevHour = null;
            foreach ($hours AS $hour) {
                if ((int)$hour < 0 OR (int)$hour > 23) {
                    return response()->json([
                        'res' => false,
                        'error' => 'Incorrect schedule data (hour)'
                    ]);
                }

                if (is_null($prevHour)) $prevHour = $hour;

                $intervalTs = strtotime("$startDate + $dCount days $hour hours");
                $intervalDate = date('Y-m-d H:i:s', $intervalTs);   // "2017-03-26 08:00:00"

                /*
                $scheduleIntervals = [
                    0 => [
                        'start' => "2017-03-26 08:00:00",
                        'end'   => "2017-03-26 12:00:00"
                    ]
                ]
                */

                if (count($scheduleIntervals) == 0 OR isset($scheduleIntervals[count($scheduleIntervals)-1]['end'])) {  // если нет ни одного элемента или интервал уже закрыт
                    $key = (count($scheduleIntervals) == 0) ? 0 : count($scheduleIntervals);
                    $scheduleIntervals[$key]['start'] = $intervalDate;

                } else {    // если еще не нашли конец интервала
                    $key = count($scheduleIntervals) - 1;
                    if ((int)$hour - (int)$prevHour > 1) {      // если есть разрыв в часах, закрываем интервал
                        $prevHourEnd = $prevHour + 1;       // если выбран, к примеру 9й час, то это значит что расписание будет действовать до начала 10го часа, т.е. до 10:00
                        $prevIntervalTs = strtotime("$startDate + $dCount days $prevHourEnd hours");
                        $scheduleIntervals[$key]['end'] = date('Y-m-d H:i:s', $prevIntervalTs);   // "2017-03-26 08:00:00"

                        $scheduleIntervals[$key+1]['start'] = $intervalDate;
                    }
                }

                if (substr($scheduleIntervals[count($scheduleIntervals)-1]['start'], 8) == '23:00:00') {
                    $scheduleIntervals[count($scheduleIntervals)-1]['end'] = date('Y-m-d H:i:s', strtotime($startDate." + 1 day"));
                }

                $prevHour = $hour;
                $lastDayNum = $dCount;
            }
        }

        // если мы закончили цикл по дням, а интервал не закрыт, нужно записать последний час последней итерации цикла как конец открытого интервала
        if (count($scheduleIntervals) > 0 AND !isset($scheduleIntervals[count($scheduleIntervals)-1]['end'])) {
            $prevHourEnd = $prevHour + 1;       // если выбран, к примеру 9й час, то это значит что расписание будет действовать до начала 10го часа, т.е. до 10:00
            $prevIntervalTs = strtotime("$startDate + $lastDayNum days $prevHourEnd hours");
            $scheduleIntervals[count($scheduleIntervals)-1]['end'] = date('Y-m-d H:i:s', $prevIntervalTs);
        }
        Log::info(__METHOD__." scheduleIntervals:".var_export($scheduleIntervals, TRUE));

        // заполняем на N недель
        // у нас на форме есть вариант 0 недель, либо он бессмысленный, либо надо прибавлять 1
        $fillWeeks = (int)$formData['fill_weeks'] + 1;
        if ($fillWeeks > 1) {
            if ($fillWeeks > 31) {      // позволяем заполнять максимум 30 недель за раз
                return response()->json([
                    'res' => false,
                    'error' => 'Incorrect weeks num'
                ]);
            }

            $firstWeekIntervals = $scheduleIntervals;
            for($i=2; $i<=$fillWeeks; $i++) {      // перебираем все недели, начиная от 2ой с start_date (первую мы уже заполнили выше)
                foreach ($firstWeekIntervals AS $singleInterval) {
                    $scheduleIntervals[] = array(
                        'start'     => date('Y-m-d H:i:s', strtotime($singleInterval['start']." +".($i-1)." week")),
                        'end'       => date('Y-m-d H:i:s', strtotime($singleInterval['end']." +".($i-1)." week"))
                    );
                }
            }
        }
        //Log::info(__METHOD__." scheduleIntervals after expanding:".var_export($scheduleIntervals, TRUE));

        // Очищаем расписание на заполняемые недели
        // DELETE FROM schedule WHERE employee_id=? AND work_end>FIRST_NEW_WORK_START AND work_start<LAST_NEW_WORK_END
        $newScheduleFirstWorkStart = $scheduleIntervals[0]['start'];
        $newScheduleLastWorkEnd = $scheduleIntervals[count($scheduleIntervals)-1]['end'];
        // получаем последний день на который есть расписание
        /*
        // получаем исходя из последнего фактически рабочего дня (на который есть рабочие интервалы)
        if (substr('2017-04-12 00:00:00', -8) == '00:00:00') {
            $lastDay = strtotime($newScheduleLastWorkEnd." - 1 day");
        } else {
            $lastDay = strtotime($newScheduleLastWorkEnd);
        }
        $lastDay = date('Y-m-d', $lastDay);
        */
        // "округляем" до конца недели
        $lastDay = date('Y-m-d', strtotime("{$startDate} + ".(($fillWeeks * 7) - 1)." days"));
        Log::info(__METHOD__." startDate:{$startDate} - fillWeeks:$fillWeeks - lastDay:$lastDay\n"."{$startDate} + ".(($fillWeeks * 7) - 1)." days");

        DB::beginTransaction();
        $deletedRows = Schedule::where('employee_id', $employee->employee_id)
            ->where([
                ['work_end', '>', $newScheduleFirstWorkStart],
                ['work_start', '<', $newScheduleLastWorkEnd],
            ])->delete();
        Log::info(__METHOD__." Schedule deleted rows:".$deletedRows);
        foreach($scheduleIntervals AS $singleInterval) {
            $schedule = new Schedule([
                'work_start'    => $singleInterval['start'],
                'work_end'    => $singleInterval['end'],
                //'employee_id' => $employee->employee_id
            ]);
            //$schedule->save();

            try {
                $res = $employee->schedules()->save($schedule);
            } catch(Exception $e) {
                Log::info(__METHOD__." error caught:".$e->getMessage());
            }
        }
        ScheduleScheme::updateOrCreate(
            ['employee_id' => $employee->employee_id],
            [
                'start_date' => $startDate,
                'end_date' => $lastDay,
                'schedule' => json_encode($formData['schedule']),
                'fill_weeks' => $formData['fill_weeks']
            ]
        );
        DB::commit();

        return response()->json([
            'res' => true,
            'error' => ''
        ]);
    }


    public function calculateWage(Request $request) {
        $empId = $request->get('employee_id');
        $month = $request->get('month');

        if (empty($empId) OR empty($month)) {
            return response()->json([
                'res' => false,
                'error' => 'Invalid data'
            ]);
        }

        $employee = Employee::where('organization_id', $request->user()->organization_id)->where('employee_id', $empId)->first();
        if (is_null($employee)) {
            return response()->json([
                'res' => false,
                'error' => 'Incorrect employee'
            ]);
        }

        $tr = preg_match('/^2\d\d\d-(0|1)\d?$/', $month, $matches);
        if ($tr !== 1) {
            return response()->json([
                'res' => false,
                'error' => 'Invalid month'
            ]);
        }

        $periodStart = $month . '-01 00:00:00';
        $periodEnd = date("Y-m-t", strtotime($periodStart)) . ' 23:59:59';

        $calculatedWage = CalculatedWage::where('employee_id', $empId)->where('wage_period_start', $periodStart)->get();
        if (count($calculatedWage) > 0) {
            return response()->json([
                'res' => false,
                'error' => 'Wage for this month already calculated'
            ]);
        }

        $calcRes = $employee->calculateWage($periodStart, $periodEnd);
		Log::info(__METHOD__." calculate wage result:".print_r($calcRes, TRUE));

        return response()->json([
            'res' => $calcRes['res'],
            'error' => $calcRes['error']
        ]);
    }

    public function getPayroll(Request $request, $cwId) {
        /*
        $servicesInfo = [
            '2017-04-10 10:30:00' => [
                '5' => [
                    'start'         => '2017-04-10 10:30:00',
                    'end'           => '2017-04-10 12:00:00',
                    'title'         => 'Haircut long title here and it\'s going on and on',
                    'price'         => '200',
                    'discount'      => '',
                    'total'         => '200',
                    'percent_earned' => '40',
                    'client_name'   => 'Joe Wilder',
                ],
                '7' => [
                    'start'         => '2017-04-10 13:00:00',
                    'end'           => '2017-04-10 13:30:00',
                    'title'         => 'Haircut 2',
                    'price'         => '500',
                    'discount'      => '',
                    'total'         => '500',
                    'percent_earned' => '100',
                    'client_name'   => 'Jinny Carrano',
                ]
            ],
            '2017-04-11 09:00:00' => [
                '9' => [
                    'start'         => '2017-04-11 09:30:00',
                    'end'           => '2017-04-11 11:00:00',
                    'title'         => 'Haircut3',
                    'price'         => '300',
                    'discount'      => '',
                    'total'         => '300',
                    'percent_earned' => '50',
                    'client_name'   => 'Joe Popper',
                ]
            ]
        ];

        $salaryData = [
            'wage_rate' => 100,
            'wage_period' => 'day',
            'num_periods' => 5,
            'total' => 500
        ];
        */

        $cw = \App\CalculatedWage::where('cw_id', $cwId)->with('employee')->first();
        if (!$cw) {
            Log::error(__METHOD__." Non existent calculated_wade id given:$cwId");
            return false;
        }
        if ($cw->employee->organization_id != $request->user()->organization_id) {
            Log::error(__METHOD__." Given calculated_wade id does not belong to curr organization:{$request->user()->organization_id}");
            return false;
        }

        //$emp->generatePayroll(690, $servicesInfo, null, $salaryData);
        $sData = json_decode($cw->salary_data, true);
        Log::info(__METHOD__." cwId:$cwId salary:".print_r($sData, true));
        view()->share([
            'apps' =>  json_decode($cw->appointments_data, true),
            'products' => json_decode($cw->products_data, true),
            'salary' => json_decode($cw->salary_data, true),
            'total_wage' => $cw->total_amount,
            'employee_name' => $cw->employee->name,
            'period_start' => $cw->wage_period_start,
            'period_end'   => $cw->wage_period_end,
        ]);
        //if(request()->has('download')){
            $pdf = \PDF::loadView('employee.pdf.payroll');
            return $pdf->download(str_replace(' ', '_', $cw->employee->name).'_payroll.pdf');
        //}
        //return view('employee.pdf.payroll');
    }

    public function payWage(Request $request, $cwId) {
        $cw = \App\CalculatedWage::where('cw_id', $cwId)->with('employee')->first();
        if (!$cw) {
            return response()->json([
                'res' => false,
                'error' => 'Invalid calculated wage id given'
            ]);
        }
        if ($cw->employee->organization_id != $request->user()->organization_id) {
            return response()->json([
                'res' => false,
                'error' => 'Invalid calculated wage id given'
            ]);
        }

        try {
            $cw->employee->payWage($cw);
        } catch(Exception $e) {
            Log::error(__METHOD__." Exception caught when trying to pay calculated wage:".$e->getMessage());
            return response()->json([
                'res' => false,
                'error' => 'Internal server error'
            ]);
        }

        return response()->json([
            'res' => true,
            'error' => ''
        ]);
    }
}
