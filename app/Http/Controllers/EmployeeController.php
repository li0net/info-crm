<?php

namespace App\Http\Controllers;

use App\WageScheme;
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
			->with(['position' => function($query) { $query->select('position_id', 'title'); }])->get()->all();

		$page = Input::get('page', 1);
		$paginate = 10;
		 
		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($employees, $offset, $paginate, true);
		$employees = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($employees), $paginate, $page);
		$employees->setPath('employee');
		 
		return view('employee.index', ['user' => $request->user()])->withEmployees($employees);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$items = Position::where('organization_id', $request->user()->organization_id)->orderBy('title')->pluck('title', 'position_id');

		return view('employee.create', ['items' => $items]);
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
            'crmuser' => $request->user()
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

				$request->file('avatar')->move(public_path('images'), $imageName);

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
                'employee_id' => 'required|numeric|max:10',
                'scheme_start' => 'date',
                'wage_scheme_id' => 'numeric|max:10'
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
                'employee_id' => 'required|numeric|max:10'
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
}
