<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
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
        $appointments = Appointment::select('appointment_id', 'employee_id', 'client_id', 'service_id', 'start', 'end')->get();
        //$employees = Employee::select('name')->where('organization_id', $request->user()->organization_id)->pluck('name', 'name');
        $employees = Employee::select('employee_id', 'name')->where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');
        $services = Service::select('name')->pluck('name', 'name');
        $sessionStart = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 15, '');
        $sessionEnd = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 15, '');

        //dump($request->input('filter_employee'), $request->input('filter_service'), $request->input('filter_start_time'), $request->input('filter_end_time'));

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
        $appointments = Appointment::select('appointment_id', 
                                            'employee_id', 
                                            'client_id', 
                                            'service_id', 
                                            'start', 
                                            'end')->where('employee_id', $request->input('filter_employee'))->get();

        // $employees = Employee::select('employee_id', 'name')->where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');
        // $services = Service::select('name')->pluck('name', 'name');
        // $sessionStart = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 15, '');
        // $sessionEnd = $this->populateTimeIntervals(strtotime('00:00:00'), strtotime('23:45:00'), 15, '');

        //dump($request->input('filter_employee'), $request->input('filter_service'), $request->input('filter_start_time'), $request->input('filter_end_time'));

        return View::make('adminlte::appointmentlist', ['appointments' => $appointments]);
    }

    protected function populateTimeIntervals($startTime, $endTime, $interval, $modifier) {
        $timeIntervals = [];
        
        while ($startTime <= $endTime) {
            $timeStr = date('H:i', $startTime);
            $timeIntervals[] = $modifier.' '.$timeStr;

            $startTime += 60*$interval; 
        }
        
        return $timeIntervals;
    }
}