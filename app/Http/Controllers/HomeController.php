<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Appointment;
use App\Employee;
use App\Client;
use App\EmployeeSetting;
use App\Service;
use Response;
use View;
use Session;
use Illuminate\Support\Facades\Input;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$appointments = Appointment::select('appointment_id', 'employee_id', 'client_id', 'service_id', 'start', 'end')
			->where('organization_id', $request->user()->organization_id)
			->with('employee', 'client', 'service')
			->get()->all();

		$employees = Employee::select('employee_id', 'name')->where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');
		$services = Service::select('service_id', 'name')->pluck('name', 'service_id');
		$clients = Client::where('organization_id', $request->user()->organization_id)->pluck('name', 'client_id');
		$sessionStart = collect($this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 15, ''));
		$sessionEnd = collect($this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 15, ''));

		$filtered = Input::get('index');

		$page = Input::get('page', 1);
		$paginate = 10;

		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = array_slice($appointments, $offset, $paginate, true);
		$appointments = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($appointments), $paginate, $page);
		$appointments->setPath('home');

		return view('adminlte::home', compact('appointments', 'employees', 'services', 'clients', 'sessionStart', 'sessionEnd'));
	}

	public function indexFiltered(Request $request)
	{
		$appointments = Appointment::where('organization_id', $request->organization_id);

		if('' !== $request->filter_employee_id) {
			$appointments = $appointments->where('employee_id', $request->filter_employee_id);
		}

		if('' !== $request->filter_service_id) {
			$appointments = $appointments->where('service_id', $request->filter_service_id);
		}

		if('' !== $request->filter_client_id) {
			$appointments->where('client_id', $request->filter_client_id);
		}

		if('' !== $request->filter_appointment_status) {
			$appointments->where('state', $request->filter_appointment_status);
		}
		
		$filter_start_time = date_create($request->filter_date_from.'00:00:00');
		date_format($filter_start_time, 'U = Y-m-d 0:0:0');

		$filter_end_time = date_create($request->filter_date_to.'23:59:59');
		date_format($filter_end_time, 'U = Y-m-d 23:59:59');

		$appointments->whereBetween('start', [$filter_start_time, $filter_end_time]);
		$appointments->whereBetween('end', [$filter_start_time, $filter_end_time]);

		$appointments = $appointments->with('employee', 'client', 'service')->get();

		$page = (0 == $request->page) ? 1 : $request->page;
		$paginate = 10;

		$offset = ($page * $paginate) - $paginate;
		$itemsForCurrentPage = $appointments->slice($offset, $paginate);

		$appointments = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, count($appointments), $paginate, $page);
		// $appointments->setPath('home');
		$appointments->appends(['index' => 'filtered']);

		return View::make('adminlte::appointmentlist', compact('appointments'));
	}

	protected function populateTimeIntervals($startTime, $endTime, $interval, $modifier) {
		$timeIntervals = [];
		
		while ($startTime <= $endTime) {
			$timeStr = date('H:i', $startTime);
			$timeIntervals[$modifier.$timeStr] = $modifier.$timeStr;

			$startTime += 60*$interval; 
		}
		
		return $timeIntervals;
	}
}