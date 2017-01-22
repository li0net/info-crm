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
use App\EmployeeSetting;
use App\Service;
use Response;
use View;

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
		$dash = '- все -';

		$appointments = Appointment::select('appointment_id', 'employee_id', 'client_id', 'service_id', 'start', 'end')->get();
		$employees = Employee::select('employee_id', 'name')->where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');
		$services = Service::select('service_id', 'name')->pluck('name', 'service_id');
		$sessionStart = collect($this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 15, ''));
		$sessionEnd = collect($this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 15, ''));

		$employees = $employees->put(0, $dash)->sort();
		$services = $services->put(0, $dash)->sort();

		return view('adminlte::home', [
			'appointments' => $appointments,
			'employees' => $employees,
			'services' => $services,
			'sessionStart' => $sessionStart,
			'sessionEnd' => $sessionEnd
		]);
	}

	public function indexFiltered(Request $request)
	{
		if(null !== ($request->input('date'))) {
			$filter_start_time = date_create($request->input('date').'00:00:00');
			date_format($filter_start_time, 'U = Y-m-d H:i:s');

			$filter_end_time = date_create($request->input('date').'23:45:00');
			date_format($filter_end_time, 'U = Y-m-d H:i:s');

			$appointments = Appointment::select('appointment_id', 
												'employee_id', 
												'service_id', 
												'client_id',
												'start', 
												'end') ->whereBetween('start', [$filter_start_time, $filter_end_time])
													   ->whereBetween('end', [$filter_start_time, $filter_end_time])->get();

			return View::make('adminlte::appointmentlist', ['appointments' => $appointments]);

		} else {
			$filter_employee = $request->input('filter_employee');
			$filter_service = $request->input('filter_service');
			
			$filter_start_time = date_create();
			date_format($filter_start_time, 'U = Y-m-d H:i:s');
			date_timestamp_set($filter_start_time, strtotime($request->input('filter_start_time')));

			$filter_end_time = date_create();
			date_format($filter_end_time, 'U = Y-m-d H:i:s');
			date_timestamp_set($filter_end_time, strtotime($request->input('filter_end_time')));
			
			$appointments = Appointment::select('appointment_id', 
												'employee_id', 
												'service_id', 
												'client_id',
												'start', 
												'end')->whereBetween('employee_id', $filter_employee != 0 ? [$filter_employee, $filter_employee] : [1, 9999])
													  ->whereBetween('service_id', $filter_service != 0 ? [$filter_service, $filter_service] : [1, 9999])
													  ->whereBetween('start', [$filter_start_time, $filter_end_time])
													  ->whereBetween('end', [$filter_start_time, $filter_end_time])->get();

			return View::make('adminlte::appointmentlist', ['appointments' => $appointments]);
		}
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