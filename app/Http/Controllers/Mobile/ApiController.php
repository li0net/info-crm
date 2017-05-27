<?php

namespace App\Http\Controllers\Mobile;

use App\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\User;
use App\Employee;
use App\Service;
use App\SuperOrganization;
use App\Organization;
use App\Client;
use App\Appointment;
use App\AccessPermission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Config;

use \App\Http\Controllers\Controller;

class ApiController extends Controller
{

    // TODO: при фейле авторизации по токену кидает на логин страницу, нужно отдавать хедер 401 Unauthorized
    // The response MUST include a WWW-Authenticate header field (section 14.47) containing a challenge applicable to the requested resource.
    public function __construct() {
        $lang = request()->input('lang');
        $languages = array_keys(Config::get('app.languages'));

        if ( in_array($lang, $languages) ) {
            //$locale = Config::get('app.locale');
            App::setLocale($lang);
            //Session::put('locale', $locale);
        }
    }

    public function getClientData(Request $request) {
        $clientId = $request->input('client_id');
        if (is_null($clientId)) {
            return response('Invalid request data', 403);
        }

        $client = Client::where('client_id', $clientId)
            ->where('organization_id', $request->user()->organization_id)
            ->where('is_active', 1)
            ->first();
        if (!$client) {
            return response('Invalid client id', 403);
        }

        $gender = trans('main.client:gender_unknown');
        if ($client['gender'] === '1') {
            $gender = trans('main.client:gender_men');
        } elseif ($client['gender'] === '0') {
            $gender = trans('main.client:gender_woman');
        }

        $phone = trans('main.user:grid_phone_hidden_message');
        // проверяем есть у юзера права на просмотр телефонов клиентов
        $showPhone = $request->user()->hasAccessTo('clients_phone', 'view', null);
        if ($showPhone) {
            $phone = trans('main.user:grid_phone_hidden_message');
        }

        $clientData = [
            'name'  => $client['name'],
            'phone' => $phone,
            'email' => $client['email'],
            'gender' => $gender,
            'discount' => $client['discount'],
            'birthday' => $client['birthday'],
            'comment' => $client['comment'],
            'total_bought' => round($client['total_bought'], 2),
            'total_paid' => round($client['total_paid'], 2),
            'online_reservation_available' => $client['online_reservation_available']
        ];

        return response()->json($clientData);
    }

    /*
    Поиск клиента
    Запрос: Адрес + язык + телефон/имя/имейл
    Ответ: Вернуть айди клиента
    */
    public function searchClient(Request $request) {
        $searchStr = $request->input('search_str');
        if (is_null($searchStr)) {
            return response('Invalid request data', 403);
        }

        $phoneStr = $request->user()->normalizePhoneNumber($searchStr);
        $emailStr = $request->user()->normalizeEmail($searchStr);

        $clients = Client::where('organization_id', $request->user()->organization_id)
            ->where(function ($query) use ($searchStr, $phoneStr, $emailStr) {
                $query->where('name', 'like', "%$searchStr%")
                    ->orWhere('phone', 'like', "%$phoneStr%")
                    ->orWhere('email', 'like', "%$emailStr%");
            })
            ->get();

        $foundClients = [];
        foreach($clients AS $client) {
            $foundClients[] = $client->client_id;
        }

        return response()->json($foundClients);
    }

    /*
    Журнал
    Запрос: Адрес + язык + айди организации/клиента + день
    Ответ: Информация о записях на день
    */
    public function getAppointments(Request $request) {
        /*
        GET:http://localhost:8000/api/v1/mobile/appointmentsForDate?day=2017-02-27&lang=ru
        или
        GET:http://localhost:8000/api/v1/mobile/appointmentsForDate?day=2017-02-27&lang=ru&client_id=23

        [
          {
            "note": "dfdfdf",
            "state": "created",
            "service_sum": null,
            "employee_name": "Adolfo Nitzsche",
            "employee_id": 5,
            "service_id": 12,
            "service_name": "molestiae",
            "client_name": "Widget Client",
            "client_phone": "+7888965542",
            "client_email": null,
            "start": "2017-02-27 11:00:00",
            "end": "2017-02-27 11:30:00"
          },
          {
            "note": "test",
            "state": "finished",
            "service_sum": "500.00",
            "employee_name": "Serenity Kilback",
            "employee_id": 3,
            "service_id": 13,
            "service_name": "distinctio",
            "client_name": "Yet another client",
            "client_phone": "+745455221",
            "client_email": null,
            "start": "2017-02-27 11:30:00",
            "end": "2017-02-27 12:15:00"
          },
        ...
        */

        $day = $request->input('day');
        $clientId = $request->input('client_id');

        if (is_null($day)) {
            return response('Invalid request data', 403);
        }

        $clientFilter = '';
        if (!is_null($clientId)) {
            $client = Client::where('client_id', $clientId)->where('organization_id', $request->user()->organization_id)->first();
            if (!$client) {
                return response('Invalid client id', 403);
            }
            $clientFilter = " AND a.client_id='{$client->client_id}'";
        }

        if (!preg_match('/^\d\d\d\d-\d\d-\d\d$/', $day)) {
            return response('Invalid day format', 403);
        }

        $startDateTime = $day . ' 00:00:00';
        $endDateTime = $day . ' 23:59:59';

        $appts = DB::select(
            "SELECT a.note, a.state, a.service_sum, e.name as employee_name, a.employee_id, a.service_id, s.name as service_name, ".
                "a.client_id, c.name as client_name, c.phone as client_phone, c.email as client_email, ".
            "(CASE WHEN a.start < '$startDateTime' THEN '$startDateTime' ELSE start END) AS start, ".
            "(CASE WHEN a.`end` > '$endDateTime' THEN '$endDateTime' ELSE `end` END) AS `end` ".
            "FROM appointments a ".
            "JOIN services s ON s.service_id=a.service_id ".
            "JOIN employees e ON e.employee_id=a.employee_id ".
            "JOIN clients c ON c.client_id=a.client_id ".
            "WHERE ((a.start BETWEEN '$startDateTime' AND '$endDateTime') OR (a.end BETWEEN '$startDateTime' AND '$endDateTime')) ".
                " $clientFilter AND a.organization_id=? ".
            "ORDER BY a.start ASC",
            [$request->user()->organization_id]
        );

        return response()->json($appts);
    }

    /*
    Филиал
    Запрос: Адрес + язык
    Ответ: Список филиалов, у каждого филиала: картинка + айди филиала
    */
    public function getBranches(Request $request) {
        // get user's super organization id
        // select organizations for that super org id
        $branches = [];
        $orgs = $request->user()->organization->superOrganization->organizations;
        foreach ($orgs AS $org) {
            $branches[] = [
                'org_id'    => $org->organization_id,
                'name'      => $org->name,
                'logo'      => $org->getLogoUri()
            ];
        }

        return response()->json($branches);
    }

    /*
    Список сотрудников - Запрос: Адрес + язык + айди филиала
    Ответ: Список сотрудников: Имя + Фамилия + Портрет
    */
    public function getBranchEmployees(Request $request) {
        $orgId = $request->input('branch_id');

        if (is_null($orgId)) {
            return response('Invalid request data', 403);
        }

        $orgs = $request->user()->organization->superOrganization->organizations;
        $employeesData = [];

        $branchFound = false;
        foreach ($orgs AS $org) {
            if ($org->organization_id == $orgId) {
                $branchFound = true;
                $emplsForOrg = $org->employees;
                foreach ($emplsForOrg AS $emp) {
                    $employeesData[] = [
                        'employee_id'   => $emp->employee_id,
                        'name'          => $emp->name,
                        'avatar'        => $emp->getAvatarUri()
                    ];
                }
            }
        }

        if (!$branchFound) {
            return response('Invalid branch id', 403);
        }

        return response()->json($employeesData);
    }

    /*
    Создать запись в журнал Запрос:  Данные для записи(дата, время, услуга, мастер и т.д.)
    Ответ: Ок/Ошибка
    */
    public function createAppointment(Request $request) {
        /*
        array:10 [
            "client_name" => "Имечко фамилия"
            "client_phone" => "986463466"
            "client_email" => "dfdffd"
            "service_id" => "17"
            "employee_id" => "4"
            "date_from" => "2016-12-27"
            "time_from" => "11:30"
            "duration_hours" => "00"
            "duration_minutes" => "45"
            "note" => "Может опоздать на 20 минут"
        ]
        */

        //Log::info(__METHOD__ . ' before validation');
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|max:120',
            'client_phone' => 'required|phone_crm', // custom validation rule
            'service_id' => 'required|max:10|exists:services',
            'employee_id' => 'required|max:10|exists:employees',
            'date_from' => 'required|date_format:"Y-m-d"',    // date
            'time_from' => 'required',      // date_format:'H:i'
            'duration_hours' => 'required',
            'duration_minutes' => 'required'
        ]);
        if ($validator->fails()) {
            $errs = $validator->messages();
            //Log::info(__METHOD__.' validation errors:'.print_r($errs, TRUE));

            return json_encode([
                'success' => false,
                'validation_errors' => $errs
            ]);
        }

        // Создать или найти клиента по client_phone и client_email
        $clientName =  $request->user()->normalizeUserName($request->input('client_name'));
        $clientPhone = $request->user()->normalizePhoneNumber($request->input('client_phone'));
        $clientEmail = ($request->input('client_email')) ? $request->user()->normalizeEmail($request->input('client_email')) : '';

        // Ищем клиента по телефону и email
        $client = Client::where('organization_id', $request->input('organization_id'))
            ->where('phone', $clientPhone)
            ->first();
        if (is_null($client) AND !empty($clientEmail)) {
            $client = Client::where('organization_id', $request->input('organization_id'))
                ->where('email', $clientEmail)
                ->first();
        }
        // если такой клиент уже есть (поиск по номеру телефона) - добавляем ему email, если не было, иначе не апдейтим его
        if (is_null($client)) {
            $client = new Client();
            $client->name = $clientName;
            $client->phone = $clientPhone;
            if ($request->input('client_email')) {
                $client->email = $clientEmail;
            }
            $client->organization_id = $request->user()->organization_id;
            $client->save();
        } else {
            if (empty($client->email) AND !empty($request->input('client_email'))) {
                $client->email = $clientEmail;
                $client->save();
            }
        }


        // не позволяем создать запись с 0 длительностью
        if ($request->input('duration_hours') == '00' AND $request->input('duration_minutes') == '00') {
            return response('Invalid duration data', 403);
        }

        // преобразовываем duration_hours, duration_minutes в timestamp end
        $endDateTime = strtotime(
            $request->input('date_from') . ' ' . $request->input('time_from') . ' + ' . $request->input('duration_hours') . ' hours ' . $request->input('duration_minutes') . ' minutes'
        );
        $endDateTime = date('Y-m-d H:i:s', $endDateTime);

        // Проверяем есть ли у юзера права на создание Записи
        $accessLevel = $request->user()->hasAccessTo('appointment', 'create', 0);
        if ($accessLevel < 1) {
            //throw new AccessDeniedHttpException('You don\'t have permission to access this page');
            return response('Permission denied', 403);
        }

        // Проверка что данное время все еще свободно у мастера
        $service = Service::where('service_id', $request->input('service_id'))
            ->join('service_categories', 'services.service_category_id', '=', 'service_categories.service_category_id')
            ->where('service_categories.organization_id', $request->user()->organization_id)
            ->first();
        if (!$service) return response()->json(array('success' => false, 'error' => 'Service data error'));

        $employee = Employee::find($request->input('employee_id'))->where('organization_id', $request->user()->organization_id)->first();
        if (!$employee) return response()->json(array('success' => false, 'error' => 'Employee data error'));

        $freeTimeIntervals = $employee->getFreeTimeIntervals($request->input('date_from') . ' ' . $request->input('time_from').':00', $endDateTime);
        if (count($freeTimeIntervals) != 1) {   // время свободно если возвращается один свободный интервал
            return response()->json(array('success' => false, 'error' => trans('main.widget:error_time_already_taken')));
        }
        if ($freeTimeIntervals[0]->work_start != $request->input('date_from') . ' ' . $request->input('time_from') . ':00' OR $freeTimeIntervals[0]->work_end != $endDateTime) {
            // если границы интервала не равны (тут могут быть только уже) тем которые передавались в качестве параметров, значит не весь диапазон времени свободен
            return response()->json(array('success' => false, 'error' => trans('main.widget:error_time_already_taken')));
        }

        $appointment = new Appointment();
        $appointment->organization_id = $request->user()->organization_id;
        if ($request->input('employee_id')) {
            $appointment->is_employee_important = 1;
        }


        $appointment->client_id = $client->client_id;
        $appointment->service_id = $request->input('service_id');
        // преобразовываем date_from, time_from в timestamp start
        $appointment->start = $request->input('date_from') . ' ' . $request->input('time_from');
        $appointment->end = $endDateTime;
        $appointment->employee_id = $request->input('employee_id');
        if (!empty($request->input('note'))) {
            $appointment->note = $request->input('note');
        }
        if ($request->input('service_price')) {
            $appointment->service_price = $request->input('service_price');
        }
        if ($request->input('service_discount')) {
            $appointment->service_discount = $request->input('service_discount');
        }
        if ($request->input('service_sum')) {
            $appointment->service_sum = $request->input('service_sum');
        }

        if ( $request->input('remind_by_sms_in')) {
            $appointment->remind_by_sms_in = $request->input('remind_by_sms_in_value');
        } else {
            $appointment->remind_by_sms_in = 0;
        }

        if ( $request->input('remind_by_email_in')) {
            $appointment->remind_by_email_in = $request->input('remind_by_email_in_value');
        } else {
            $appointment->remind_by_email_in = 0;
        }
        $appointment->state = 'created';  // пока поддерживаем только создание

        $appointment->save();

        return response()->json(array('success' => true, 'error' => ''));
    }
}