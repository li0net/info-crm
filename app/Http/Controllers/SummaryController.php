<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;

class SummaryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSummary(Request $request)
    {
        $organization_id = $request->user()->organization_id;

        $appointments = Appointment::select('appointment_id', 'employee_id', 'client_id', 'service_id', 'start', 'end', 'state')
            ->where('organization_id', $request->user()->organization_id)
            ->with('employee', 'client', 'service')
            ->orderBy('start', 'desc')
            ->get()->all();

        $dts = Appointment::selectRaw('DATE_FORMAT(start, "%d-%m-%Y") as date')
            ->where('organization_id', $request->user()->organization_id)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()->all();

//        $appointments = Appointment::orderBy('start', 'desc')
//            ->groupBy('employee_id')
//            ->having('employee_id', '>', 2)
//            ->get();

        return view('summary', compact('organization_id', 'appointments', 'dts'));
    }
}