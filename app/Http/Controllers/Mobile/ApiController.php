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

    public function getUserData(Request $request) {
        $clientId = $request->input('client_id');
        if (is_null($clientId)) {
            return response('Invalid request data', 403);
        }

        $client = Client::where('client_id', $clientId)->where('organization_id', $request->user()->organization_id)->first();
        if (!$client) {
            return response('Invalid client id', 403);
        }

        $gender = trans('main.client:gender_unknown');
        if ($client['gender'] === '1') {
            $gender = trans('main.client:gender_men');
        } elseif ($client['gender'] === '0') {
            $gender = trans('main.client:gender_woman');
        }

        $clientData = [
            'name'  => $client['name'],
            'phone' => $client['phone'],
            'email' => $client['email'],
            'gender' => $gender,
            'discount' => $client['discount'],
            'birthday' => $client['birthday'],
            'comment' => $client['comment'],
            'total_bought' => $client['total_bought'],
            'total_paid' => $client['total_paid'],
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
                "c.name as client_name, c.phone as client_phone, c.email as client_email, ".
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
}