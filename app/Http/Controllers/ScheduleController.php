<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Employee;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Validator;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('permissions')->only(['update', 'destroy']);
    }

    public function create(Request $request)
    {
        /*
        'employee_id' => 2323,
        'start_date' => '2017-03-20'
        'schedule' => [
            0 => [8,9,10,14,15,16],
            1 => [12,13,14,15,16,17,18,19],
            2 => [],
            ...
        ],
        'fill_weeks' => 3
        */

        $validator = Validator::make($request->all(), [
            'employee_id'   => 'required|max:10',
            'start_date'    => 'required|date_format:"Y-m-d"',    // date
            'fill_weeks'    => 'required|numeric|max:2',
            'schedule'      => 'required'
        ]);
        if ($validator->fails()) {
            $errs = $validator->messages();
            //Log::info(__METHOD__.' validation errors:'.print_r($errs, TRUE));

            //return json_encode([
            return response()->json([
                'success' => false,
                'validation_errors' => $errs
            ]);
        }

        $employee = Employee::where('organization_id', $request->user()->organization_id)->where('employee_id', $request->get('employee_id'))->first();
        if (is_null($employee)) {
            //return json_encode([
            return response()->json([
                'success' => false,
                'error' => [
                    'Incorrect employee'
                ]
            ]);
        }

        $startDate = $request->get('start_date');
        if (1 != date('w', strtotime($startDate))) {       // проверяем, что переданная дата является понедельником
            //return json_encode([
            return response()->json([
                'success' => false,
                'error' => [
                    'Start date should be monday'
                ]
            ]);
        }

        $scheduleArr = $request->get('schedule');
        $scheduleIntervals = [];

        foreach($scheduleArr AS $dCount=>$hours) {
            if ((int)$dCount < 0 OR (int)$dCount > 6) {
                //return json_encode([
                return response()->json([
                    'success' => false,
                    'error' => [
                        'Incorrect schedule data (day)'
                    ]
                ]);
            }

            $prevHour = null;
            foreach ($hours AS $hour) {
                if ((int)$hour < 0 OR (int)$hour > 23) {
                    //return json_encode([
                    return response()->json([
                        'success' => false,
                        'error' => [
                            'Incorrect schedule data (hour)'
                        ]
                    ]);
                }

                $intervalTs = strtotime("$startDate + $hour hours");
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
                        $prevIntervalTs = strtotime("$startDate + $prevHour hours");
                        $intervalEndDate = date('Y-m-d H:i:s', $prevIntervalTs);   // "2017-03-26 08:00:00"
                        $scheduleIntervals[$key]['end'] = $intervalEndDate;

                        $scheduleIntervals[$key+1]['start'] = $intervalDate;
                    }
                }

                if (substr($scheduleIntervals[count($scheduleIntervals)-1]['start'], 8) == '23:00:00') {
                    $scheduleIntervals[count($scheduleIntervals)-1]['end'] = date('Y-m-d H:i:s', strtotime($startDate." + 1 day"));
                }

                $prevHour = $hour;
            }
        }

        $fillWeeks = (int)$request->get('fill_weeks');
        if ($fillWeeks > 1) {
            if ($fillWeeks > 12) {      // позволяем заполнять максимум 12 недель за раз
                //return json_encode([
                return response()->json([
                    'success' => false,
                    'error' => [
                        'Incorrect weeks num'
                    ]
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

        foreach($scheduleIntervals AS $singleInterval) {
            $schedule = new Schedule([
                'work_start'    => $singleInterval['start'],
                'work_end'    => $singleInterval['end']
            ]);

            $employee->schedules()->save($schedule);
        }

        //return json_encode([
        return response()->json([
            'success' => true,
            'error' => ''
        ]);
    }
}
