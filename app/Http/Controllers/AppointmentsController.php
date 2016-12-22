<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Appointment;
use App\Service;
use App\Employee;
use App\Client;

class AppointmentsController extends Controller
{
    public function __construct() {
        // TODO: убрать после доработки логина
        auth()->loginUsingId(1);

        $this->middleware('auth');
    }


    public function view(ServiceCategory $appointment) {
        return view('adminlte::servicecategoryview', compact('serviceCategory'));
    }

    // форма создания Записи
    public function create(Request $request) {
        $servicesOptions = $this->prepareServicesSelectData($request);
        $timeOptions = $this->prepareTimesSelectData();
        $durationSelects = $this->prepareDurationSelects();

        return view('adminlte::appointmentform', [
            'servicesOptions' => $servicesOptions,
            'timeOptions' => $timeOptions,
            'hoursOptions' => $durationSelects['hours'],
            'minutesOptions' => $durationSelects['minutes']
        ]);
    }

    // форма редактирования Записи
    public function edit(Request $request, Appointment $appt) {
        // TODO: выводить ошибку в красивом шаблоне
        if ($request->user()->organization_id != $appt->employee->organization_id) {
            return 'You don\'t have access to this item';
        }

        $appt->client->load();

        $servicesOptions = $this->prepareServicesSelectData($request);
        //$employeesOptions = prepareEmployeesSelectData($request);

        return view('adminlte::servicecategoryform', ['servicesOptions' => $servicesOptions, 'appointment' => $appt]);
    }

    public function save(Request $request) {
        //dd($request->all());
        /*
        array:10 [
            "_token" => "U5A6pdfeskwBrbBYvNVWRmUZu9zeaV6ymMdzJbBs"
            "client_name" => "Имечко фамилия"
            "client_phone" => "986463466"
            "client_email" => "dfdffd"
            "service_id" => "17"
            "employee_id" => "4"
            "date_from" => "12/27/2016"
            "time_from" => "11:30"
            "duration_hours" => "00"
            "duration_minutes" => "45"
        ]
        */

        $this->validate($request, [
            'client_name' => 'required|max:120',
            //'client_phone' => 'unique:users,email_address',       // TODO: write phone validation rule
            'client_email' => 'email',
            'service_id' => 'required|max:10|exists:services',
            'employee_id' => 'max:10|exists:employees',
            'date_from' => 'required|date',
            'time_from' => "required|date_format:'H:i:s'"
        ]);
        // TODO: валидация duration_minutes и duration_hours (проверяем что они есть в списке из prepareDurationSelects())

        // TODO: если такой клиент уже есть (поиск по номеру телефона) - добавляем ему email, если не было, иначе не апдейтим его
        // TODO: а его id прописываем в $appointment->client_id

        $appId = $request->input('appointment_id');
        // определить создание это или редактирование (по наличию поля service_category_id)
        // если редактирвоание - проверить что объект принадлежить текущему пользователю
        if (!is_null($appId)) {  // редактирование

        } else {    // создание

            $appointment = new Appointment();

            // TODO: клиента ищем по комбинации имени-номера телефона-имейла
            // имя и телефон нормализуем (имя - каждое слово с заглавной буквы, лишние пробелы между словами и до/после убираем, номер телефона - храним в стандартном формате)

            // TODO: искать существующего клиента
            $clientFound = FALSE;

            if (!$clientFound) {
                $client = Client::create(
                    [
                        'name'  => $request->input('client_name'),      // TODO: нормализовать
                        'phone' => $request->input('client_phone'),      // TODO: нормализовать
                        'email' => $request->input('client_email'),      // TODO: нормализовать
                    ]
                )->save();
            } else {

            }

            $appointment->client_id = $client->client_id;
            // преобразовываем date_from, time_from в timestamp start
            $appointment->start = $request->input('date_from').' '.$request->input('time_from');
            // преобразовываем duration_hours, duration_minutes в timestamp end
            $endTs = strtotime($appointment->start.' + '.$request->input('duration_hours').' hours '.$request->input('duration_minutes').' minutes');
            $appointment->end = date('Y-m-d H:i:s', $endTs);

            // TODO: проверять что данный диапазон времени (start - end) не занят у работника (если работник не важен - искать хотябы одного свободного с этой услугой?)

            $appointment->save();
        }

        //return redirect()->to('/serviceCategories');
        return redirect()->to('/');

        /*
        $this->validate($request, [
            'name' => 'required|max:140',
            'online_reservation_name' => 'max:140',
            'gender' => 'required'
        ]);

        $scId = $request->input('service_category_id');
        // определить создание это или редактирование (по наличию поля service_category_id)
        // если редактирвоание - проверить что объект принадлежить текущему пользователю
        if (!is_null($scId)) {  // редактирование
            $sc = ServiceCategory::
            where('organization_id', $request->user()->organization_id)
                ->where('service_category_id', $scId)
                ->first();
            if (is_null($sc)) {
                return 'Record doesn\'t exist';
            }

            $gender = $request->input('gender');
            if (in_array($gender, ['null', '1', '0'])) {
                if ($gender == 'null') $gender = NULL;
                $sc->gender = $gender;
            }

        } else {
            $sc = new ServiceCategory();
            $sc->organization_id = $request->user()->organization_id;      // curr users's org id

            $gender = $request->input('gender');
            if ($gender !== 'null') {
                if ($gender == '1') {
                    $sc->gender = 1;
                } elseif ($gender == '0') {
                    $sc->gender = 0;
                }
            }
        }

        $sc->name = $request->input('name');
        $sc->online_reservation_name = $request->input('online_reservation_name');

        $sc->save();

        return redirect()->to('/serviceCategories');
        */
    }

    protected function prepareServicesSelectData($request)
    {
        /*
        $employeesOptions = array();
        $empsDb = Employee::where('organization_id', $request->user()->organization_id)
            ->orderby('name', 'asc')
            ->get();
        foreach ($empsDb AS $employee) {
            $serviceCategoriesOptions[] = [
                'value'     => $employee->employee_id,
                'label'     => $employee->name
            ];
        }
        */

        // Все услуги организации
        $servicesDb = DB::table('services')
            ->join('service_categories', 'services.service_category_id', '=', 'service_categories.service_category_id')
            ->select('services.name', 'services.service_id')
            ->where('service_categories.organization_id', '=', $request->user()->organization_id)
            ->orderBy('services.name', 'asc')
            ->get();

        $servicesOptions = array();
        foreach ($servicesDb AS $service) {
            $servicesOptions[] = [
                'value'     => $service->service_id,
                'label'     => $service->name
            ];
        }

        return $servicesOptions;
    }

    protected function prepareEmployeesSelectData($request)
    {
        // Все сотрудники организации
        $employeesOptions = array();
        $empsDb = Employee::where('organization_id', $request->user()->organization_id)
            ->orderby('name', 'asc')
            ->get();
        foreach ($empsDb AS $employee) {
            $employeesOptions[] = [
                'value'     => $employee->employee_id,
                'label'     => $employee->name
            ];
        }

        return $employeesOptions;
    }

    protected function prepareTimesSelectData() {
        $timeOptions = array();

        $startTs = strtotime('00:00:00 today');
        // 96 интервалов по 15 минут в сутках (последний нам не нужен для отображения)
        for($i=1; $i<=95; $i++) {
            $timeStr = date('H:i', $startTs);
            $timeOptions[] = [
                'label' => $timeStr,
                'value' => $timeStr
            ];

            $startTs += 60*15;      // переходим к следующему 15минутному интервалу
        }

        return $timeOptions;
    }

    protected function prepareDurationSelects() {
        $selects = array();

        // TODO: localization (можно просто h. вместо полного слова в разных формах)
        $selects['hours'] = [
            [
                'label' => '0 '.trans_choice('main.hours_in_day', 0),
                'value' => '00'
            ],
            [
                'label' => '1 '.trans_choice('main.hours_in_day', 1),
                'value' => '01'
            ],
            [
                'label' => '2 '.trans_choice('main.hours_in_day', 2),
                'value' => '02'
            ],
            [
                'label' => '3 '.trans_choice('main.hours_in_day', 3),
                'value' => '03'
            ],
            [
                'label' => '4 '.trans_choice('main.hours_in_day', 4),
                'value' => '04'
            ],
            [
                'label' => '5 '.trans_choice('main.hours_in_day', 5),
                'value' => '05'
            ],
            [
                'label' => '6 '.trans_choice('main.hours_in_day', 6),
                'value' => '06'
            ],
            [
                'label' => '7 '.trans_choice('main.hours_in_day', 7),
                'value' => '07'
            ],
            [
                'label' => '8 '.trans_choice('main.hours_in_day', 8),
                'value' => '08'
            ]
        ];

        $selects['minutes'] = [
            [
                'label' => '0 '.trans('main.minutes_short'),
                'value' => '00'
            ],
            [
                'label' => '15 '.trans('main.minutes_short'),
                'value' => '15'
            ],
            [
                'label' => '30 '.trans('main.minutes_short'),
                'value' => '30'
            ],
            [
                'label' => '45 '.trans('main.minutes_short'),
                'value' => '45'
            ]
        ];

        return $selects;
    }

    // источник данных для селекта Услуга на форме Записи (обновляется ajax'ом при смене сотрудника в селекте)
    public function getEmployeesForServices(Service $service)
    {
        $employees = $service->employees()->get();
        $employeesOptions = [];

        foreach($employees AS $employee)
        {
            $employeesOptions[] = ['value' => $employee->employee_id, 'label' => $employee->name];
        }

        echo json_encode($employeesOptions);
    }
}
