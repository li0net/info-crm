<?php

namespace App\Http\Controllers;
use App\ServiceCategory;
use App\Service;
use App\Card;
use App\Employee;
use App\Resource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Session;

class ServicesController extends Controller
{

	protected $durationOptions;

	public function __construct()
	{
		// TODO: убрать после доработки логина
		//auth()->loginUsingId(1);

		$this->middleware('auth');
		$this->middleware('permissions');   //->only(['create', 'edit', 'save']);

		$this->durationOptions = [
			[
				'value' => '00:15:00',
				'label' => '0:15'
			],
			[
				'value' => '00:30:00',
				'label' => '0:30',
				'selected' => true
			],
			[
				'value' => '00:45:00',
				'label' => '0:45'
			],
			[
				'value' => '01:00:00',
				'label' => '1:00'
			],
			[
				'value' => '01:15:00',
				'label' => '1:15'
			],
			[
				'value' => '01:30:00',
				'label' => '1:30'
			],
			[
				'value' => '01:45:00',
				'label' => '1:45'
			],
			[
				'value' => '02:00:00',
				'label' => '2:00'
			],
			[
				'value' => '02:30:00',
				'label' => '2:30'
			],
			[
				'value' => '03:00:00',
				'label' => '3:00'
			],
			[
				'value' => '03:30:00',
				'label' => '3:30'
			],
			[
				'value' => '04:00:00',
				'label' => '4:00'
			]
		];
	}


	/**
	 * Show the service categories list
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$newServiceUrl = action('ServicesController@create');
		return view('adminlte::services', [
			'newServiceUrl' => $newServiceUrl,
			'crmuser' => $request->user()
		]);
	}

	// форма создания услуги
	public function create(Request $request)
	{
		$serviceCategoriesOptions = $this->prepareSelectData($request);
		$durationOptions = $this->durationOptions;
		$service_routings = Card::where('organization_id', $request->user()->organization_id)->pluck('title', 'card_id');
		$service_employees = Employee::where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');

		$service_duration_hours = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('09:00:00'), 60, '', ' ч', 'G');
		$service_duration_minutes = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('01:00:00'), 15, '', ' мин', 'i');

		return view(
			'adminlte::serviceform', 
			compact(
				'durationOptions', 
				'serviceCategoriesOptions', 
				'service_duration_hours', 
				'service_duration_minutes',
				'service_routings',
				'service_employees'
			)
		);
	}

	// форма редактирования услуги
	public function edit(Request $request, Service $service)
	{
		// TODO: выводить ошибку в красивом шаблоне
		if ($service->serviceCategory()->first()->organization_id != $request->user()->organization_id) {
			return 'You don\'t have access to this item';
		}

		$serviceCategoriesOptions = $this->prepareSelectData($request);
		$durationOptions = $this->durationOptions;
		$service_routings = Card::where('organization_id', $request->user()->organization_id)->pluck('title', 'card_id');
		$service_employees = Employee::where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');

		$service_duration_hours = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('09:00:00'), 60, '', ' ч', 'G');
		$service_duration_minutes = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('01:00:00'), 15, '', ' мин', 'i');

		$service_attached_employees = $service->employees;
		$resources_attached_service = $service->resources;

		return view(
			'adminlte::serviceform', 
			compact(
				'durationOptions', 
				'serviceCategoriesOptions', 
				'service_duration_hours', 
				'service_duration_minutes',
				'service_routings',
				'service_employees',
				'service',
				'service_attached_employees',
				'resources_attached_service'
			)
		);
	}

	public function save(Request $request)
	{
		$this->validate($request, [
			'service_category_id' => 'required|max:10',
			'name' => 'required|max:255',
			'description' => 'present',
			'price_min' => 'required|numeric',
			'price_max' => 'required|numeric',
			'duration'  => 'required|date_format:"H:i:s"',
			'max_num_appointments' => 'integer|max:3'
		]);

		$sId = $request->input('service_id');
		// определить создание это или редактирование (по наличию поля service_id)
		// если редактирвоание - проверить что объект принадлежить текущему пользователю
		if (!is_null($sId)) {  // редактирование
			// Проверяем есть ли у юзера права на редактирование Услуг
			$accessLevel = $request->user()->hasAccessTo('service', 'edit', 0);
			if ($accessLevel < 1) {
				throw new AccessDeniedHttpException('You don\'t have permission to access this page');
			}

			$service = Service::find($sId);
			if (is_null($service)) {
				return 'Record doesn\'t exist';
			}
			if ($service->serviceCategory()->first()->organization_id != $request->user()->organization_id) {
				return 'Record doesn\'t exist';
			}

		} else {
			$service = new Service();
		}

		$service->service_category_id = $request->input('service_category_id');
		$service->name = $request->input('name');
		if (trim($request->input('description')) != '') {
			$service->description = $request->input('description');
		}
		$service->price_min = $request->input('price_min');
		$service->price_max = $request->input('price_max');
		$service->duration = $request->input('duration');
		$service->max_num_appointments = $request->input('max_num_appointments');

        $service->save();

       	$input = $request->input();

       	$service->employees()->detach();
       	$service->resources()->detach();

        if (isset($input['service-employee'])) {
			for ($i = 0; $i < count($input['service-employee']); $i++) {
				$time = Carbon::createFromTime(
					$input['service-duration-hour'][$i],
					$input['service-duration-minute'][$i],
					0
				);

                $serviceRouting = null;
				if (isset($input['service-routing'][$i])) {
                    $serviceRouting = $input['service-routing'][$i];
                }
				$service->employees()->attach(
					$input['service-employee'][$i],
					['duration' => $time, 'routing_id' => $serviceRouting]
				);
			}
		}

		if (isset($input['service-resource'])) {
			for ($i = 0; $i < count($input['service-resource']); $i++) {
				$service->resources()->attach(
					$input['service-resource'][$i],
					['amount' => $input['amount'][$i]]
				);
			}
		}

        return redirect()->to('/services');
	}

	protected function prepareSelectData($request) {
		$serviceCategoriesOptions = array();
		$scDb = ServiceCategory::where('organization_id', $request->user()->organization_id)
			->orderby('name', 'asc')
			->get();
		foreach ($scDb AS $serviceCategory) {
			$serviceCategoriesOptions[] = [
				'value'     => $serviceCategory->service_category_id,
				'label'     => $serviceCategory->name
			];
		}
		return $serviceCategoriesOptions;
	}

	public function populateEmployeeOptions(Request $request)
    {
    	if($request->ajax()){
    		$options = Employee::where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');
    		$data = view('services.options', compact('options'))->render();
    		return response()->json(['options' => $data]);
    	}
    }

    public function populateRoutingOptions(Request $request)
    {
    	if($request->ajax()){
    		$options = Card::where('organization_id', $request->user()->organization_id)->pluck('title', 'card_id');
    		
    		$data = view('services.options', compact('options'))->render();
    		return response()->json(['options' => $data]);
    	}
    }

    public function populateResourceOptions(Request $request)
    {
    	if($request->ajax()){
    		$options = Resource::where('organization_id', $request->user()->organization_id)->pluck('name', 'resource_id');
    		
    		$data = view('services.options', compact('options'))->render();
    		return response()->json(['options' => $data]);
    	}
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

	/**
	 * Удаляет услугу из БД
	 *
	 * @param  int  $serviceId
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($serviceId)
	{
		$service = Service::join('service_categories', 'services.service_category_id', '=', 'service_categories.service_category_id')
			->where('service_categories.organization_id', request()->user()->organization_id)->where('services.service_id', $serviceId)->first();

		if ($service) {
			$service->delete();
			//Session::flash('success', 'Услуга удалена!');
			Session::flash('success', trans('main.service:delete_success_message'));
		} else {
			Session::flash('error', trans('main.service:delete_error_message'));
		}

		return redirect()->to('/services');
	}

}