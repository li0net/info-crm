<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Appointment;
use App\Service;
use App\Employee;
use App\Storage;
use App\Client;
use App\Product;
use App\StorageTransaction;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\Facades\Log;

class AppointmentsController extends Controller
{
    public function __construct() {
        // TODO: убрать после доработки логина
        //auth()->loginUsingId(1);

        $this->middleware('auth');

        $this->middleware('permissions')->only(['create', 'edit', 'save']);
    }

    public function view(ServiceCategory $appointment) {
        return view('adminlte::servicecategoryview', compact('serviceCategory'));
    }

    // форма создания Записи
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request) {
        $servicesOptions = $this->prepareServicesSelectData($request);
        $timeOptions = $this->prepareTimesSelectData();
        $durationSelects = $this->prepareDurationSelects();
        $storages = Storage::where('organization_id', $request->user()->organization_id)
            ->orderBy('title')
            ->with('products')
            ->get()
            ->pluck('products', 'storage_id');

        return view('adminlte::appointmentform', [
            'servicesOptions' => $servicesOptions,
            'timeOptions' => $timeOptions,
            'hoursOptions' => $durationSelects['hours'],
            'minutesOptions' => $durationSelects['minutes'],
            'user' => $request->user(),
            'storages' => $storages
        ]);
    }

    // форма редактирования Записи
    /**
     * @param Request $request
     * @param Appointment $appt
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit(Request $request, Appointment $appt) {
        // TODO: выводить ошибку в красивом шаблоне
        if ($request->user()->organization_id != $appt->employee->organization_id) {
            return 'You don\'t have access to this item';
        }

        $servicesOptions = $this->prepareServicesSelectData($request);
        $timeOptions = $this->prepareTimesSelectData();
        $durationSelects = $this->prepareDurationSelects();
        $transactions = StorageTransaction::where('appointment_id', $appt->appointment_id)->get();
        $storages = Storage::where('organization_id', $request->user()->organization_id)
            ->orderBy('title')
            ->with('products')
            ->get()
            ->pluck('products', 'storage_id');

        /*
        // закомментировано, т.к. преобразовываем в часы и минуты во вьюшке
        // при добавлении таймзон, нужно будет делать это здесь
        $dtStart = new \DateTime($appt->start);
        $dtEnd = new \DateTime($appt->end);
        $appInterval = $dtStart->diff($dtEnd);
        if ($appInterval === FALSE) {
            return 'Error 01';
        }
        */

        $employees = $appt->service->employees()->get();
        $employeesOptions = [];
        foreach($employees AS $employee)
        {
            $employeesOptions[] = ['value' => $employee->employee_id, 'label' => $employee->name];
        }

        $employees = Employee::where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');

        // Готовим данные клиента
        $clientInfo = '';
        $clientDataAccessLevel = $request->user()->hasAccessTo('appointment_client_data', 'view', 0);
        if ($clientDataAccessLevel > 0) {
            $clientData = DB::table('appointments')
                ->select(DB::raw('count(*) AS num_visits, MAX(start) AS last_visit'))
                ->where('organization_id', $request->user()->organization_id)
                ->where('client_id', $appt->client_id)
                ->whereRaw('appointments.start <= NOW()')
                ->get();
            $clientData = $clientData->first();
            if ($clientData->num_visits > 0) {
                $clientInfo = view('appointment.tpl.clientinfo', ['clientData' => $clientData])->render();
            }
        }

        return view('adminlte::appointmentform', [
            'appointment' => $appt,
            'servicesOptions' => $servicesOptions,
            'timeOptions' => $timeOptions,
            'hoursOptions' => $durationSelects['hours'],
            'minutesOptions' => $durationSelects['minutes'],
            'employeesOptions' => $employeesOptions,
            'employees'=> $employees,
            'transactions'=> $transactions,
            'storages'=> $storages,
            'user' => $request->user(),
            'clientInfo' => $clientInfo
        ]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function save(Request $request)
    {
        // TODO: добавить поле с заметкой
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
            "note" => "Может опоздать на 20 минут"
        ]
        */

        /*
        $this->validate($request, [
            'client_name' => 'required|max:120',
            'client_phone' => 'required|phone_crm', // custom validation rule
            'client_email' => 'email',
            'service_id' => 'required|max:10|exists:services',
            'employee_id' => 'required|max:10|exists:employees',
            'date_from' => 'required|date_format:"Y-m-d"',    // date
            'time_from' => 'required',      // date_format:'H:i'
            'duration_hours' => 'required',
            'duration_minutes' => 'required'
        ]);
        */

        Log::info(__METHOD__ . ' before validation');
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|max:120',
            'client_phone' => 'required|phone_crm', // custom validation rule
            'client_email' => 'email',
            'service_id' => 'required|max:10|exists:services',
            'employee_id' => 'required|max:10|exists:employees',
            'date_from' => 'required|date_format:"Y-m-d"',    // date
            'time_from' => 'required',      // date_format:'H:i'
            'duration_hours' => 'required',
            'duration_minutes' => 'required',
            'state' => 'alpha'
        ]);
        if ($validator->fails()) {
            $errs = $validator->messages();
            //Log::info(__METHOD__.' validation errors:'.print_r($errs, TRUE));

            return json_encode([
                'success' => false,
                'validation_errors' => $errs
            ]);
        }

        // валидация duration_minutes и duration_hours (проверяем что они есть в списке из prepareDurationSelects())
        $durationSelects = $this->prepareDurationSelects();
        $isInArr = FALSE;
        foreach ($durationSelects['hours'] AS $option) {
            if ($option['value'] == $request->input('duration_hours')) {
                $isInArr = TRUE;
                break;
            }
        }
        if (!$isInArr) {
            return json_encode([
                'success' => false,
                'error' => 'Duration value is invalid.'
            ]);
        }
        $isInArr = FALSE;
        foreach ($durationSelects['minutes'] AS $option) {
            if ($option['value'] == $request->input('duration_minutes')) {
                $isInArr = TRUE;
                break;
            }
        }
        if (!$isInArr) {
            return json_encode([
                'success' => false,
                'error' => 'Duration value is invalid.'
            ]);
        }
        // не позволяем создать запись с 0 длительностью
        if ($request->input('duration_hours') == '00' AND $request->input('duration_minutes') == '00') {
            return json_encode([
                'success' => false,
                'validation_errors' => ['duration_minutes' => [trans('main.appointment:error_duration_not_selected')]]
            ]);
        }

        // Ищем клиента
        // TODO: искать клиента по комбинации имени-номера телефона-имейла ??
        //  имя и телефон нормализуем (имя - каждое слово с заглавной буквы, лишние пробелы между словами и до/после убираем, номер телефона - храним в стандартном формате)
        $clientPhone = $request->user()->normalizePhoneNumber($request->input('client_phone'));
        $client = Client::where('organization_id', $request->user()->organization_id)
            ->where('phone', $clientPhone)
            ->first();

        // если такой клиент уже есть (поиск по номеру телефона) - добавляем ему email, если не было, иначе не апдейтим его
        //  а его id прописываем в $appointment->client_id
        $clientFound = FALSE;

        if (is_null($client)) {
            $client = new Client();
            $client->name = $request->input('client_name');      // TODO: нормализовать
            $client->phone = $clientPhone;
            if ($request->input('client_email')) {
                $client->email = $request->input('client_email');
            }
            $client->organization_id = $request->user()->organization_id;
            $client->save();

        } else {
            if (empty($client->email) AND !empty($request->input('client_email'))) {
                $client->email = $request->input('client_email');
                $client->save();
            }
        }

        $appId = $request->input('appointment_id');
        // определить создание это или редактирование (по наличию поля service_category_id)
        // если редактирвоание - проверить что объект принадлежит текущему пользователю
        if (!is_null($appId)) {  // редактирование
            // Проверяем есть ли у юзера права на редактирование Записи
            $accessLevel = $request->user()->hasAccessTo('appointment', 'edit', 0);
            if ($accessLevel < 1) {
                throw new AccessDeniedHttpException('You don\'t have permission to access this page');
            }

            $appointment = Appointment::
            where('organization_id', $request->user()->organization_id)
                ->where('appointment_id', $appId)
                ->first();
            if (is_null($appointment)) {
                return json_encode([
                    'success' => false,
                    'error' => 'Data error. Record doesn\'t exist'
                ]);
            }
            if (empty($request->input('note'))) {
                $appointment->note = NULL;
            }
            $appointment->state = 'created'; //TODO: Правильно считывать состояние визита

            //Cторнирование складских операций по продаже товаров и восстановление остатков на складах
            $transactions = StorageTransaction::where('organization_id', $request->user()->organization_id)->where('appointment_id', $appointment->appointment_id)->get();
            foreach($transactions as $transaction) {
                $product = Product::where('organization_id', $request->user()->organization_id)->where('product_id', $transaction->product_id)->get()->first();
                $product->amount += $transaction->amount;
                $product->save();
                $transaction->delete();
            }
        } else {    // создание
            // Проверяем есть ли у юзера права на создание Записи
            $accessLevel = $request->user()->hasAccessTo('appointment', 'create', 0);
            if ($accessLevel < 1) {
                throw new AccessDeniedHttpException('You don\'t have permission to access this page');
            }

            $appointment = new Appointment();
            $appointment->organization_id = $request->user()->organization_id;
        }
        // TODO: проверять что данный диапазон времени (start - end) не занят у работника (если работник не важен - искать хотябы одного свободного с этой услугой?)

        $appointment->client_id = $client->client_id;
        $appointment->service_id = $request->input('service_id');
        // преобразовываем date_from, time_from в timestamp start
        $appointment->start = $request->input('date_from') . ' ' . $request->input('time_from');
        // преобразовываем duration_hours, duration_minutes в timestamp end
        $endTs = strtotime($appointment->start . ' + ' . $request->input('duration_hours') . ' hours ' . $request->input('duration_minutes') . ' minutes');
        $appointment->end = date('Y-m-d H:i:s', $endTs);
        $appointment->employee_id = $request->input('employee_id');
        if (!empty($request->input('note'))) {
            $appointment->note = $request->input('note');
        }

        $appointment->save();

        for ($i = 0; $i < count($request->storage_id); $i++) {
            $transaction = new storageTransaction;

            $transaction->appointment_id = $appointment->appointment_id;
            $transaction->date = date_create($request->input('date-from') . $request->input('time-from'));
            date_format($transaction->date, 'U = Y-m-d H:i:s');

            $transaction->type = 'expenses';
            $transaction->client_id = 0;
            $transaction->employee_id = $request->master_id[$i];
            $transaction->storage1_id = $request->storage_id[$i];
            $transaction->storage2_id = 0;
            $transaction->partner_id = 0;
            $transaction->account_id = 0;
            $transaction->description = 'Продажа товара во время визита клиента.';
            $transaction->is_paidfor = true;
            $transaction->product_id = $request->product_id[$i];
            $transaction->price = $request->price[$i];
            $transaction->amount = $request->amount[$i];
            $transaction->discount = $request->discount[$i];
            $transaction->sum = $request->sum[$i];
            $transaction->code = 0;
            $transaction->organization_id = $request->user()->organization_id;
            $transaction->transaction_items = '';

            $product = Product::where('organization_id', $request->user()->organization_id)->where('product_id', $transaction->product_id)->get()->first();
            $product->amount -= $transaction->amount;
            $product->save();

            $transaction->save();
        }

        //return redirect()->route('appointments.index');
        echo json_encode(array('success' => true, 'error' => ''));
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->hasAccessTo('appointments', 'delete', 0)) {
            $appointment = Appointment::where('organization_id', $request->user()->organization_id)->where('appointment_id', $id)->first();

            if ($appointment) {
                $appointment->delete();
                Session::flash('success', trans('main.appointments:delete_successful'));
            } else {
                Session::flash('error', trans('main.appointments:delete_not_found'));
            }

        } else {
            Session::flash('error', trans('main.appointments:no_permission_to_delete'));
        }

        return redirect()->route('appointments.index');
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

    public function populateEmployeeOptions(Request $request)
    {
        if($request->ajax()){
            $options = Employee::where('organization_id', $request->user()->organization_id)->pluck('name', 'employee_id');
            $data = view('services.options', compact('options'))->render();
            return response()->json(['options' => $data]);
        }
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

    /**
     * Метод для ajax получения информации о клиенте (в интерфейсе создания/редактирования Записи)
     * @param Request $request
     *
     */
    public function getClientInfo(Request $request) {
        // Если юзеру не разрешено просматривать данные клиентов, возвращаем пустую строку
        $accessLevel = $request->user()->hasAccessTo('appointment_client_data', 'view', 0);
        if ($accessLevel < 1) {
            echo '';
            return;
        }

        // будем искать клиента по номеру телефона
        // TODO: искать по email и комбинации phone+email
        $phone = $request->input('phone');
        if (empty($phone)) {
            echo '';
            return;
        }

        $phone = $request->user()->normalizePhoneNumber($phone);

        //"SELECT count(*) AS num_visits, MAX(start) AS last_visit FROM appointments a JOIN clients c ON a.client_id=c.client_id WHERE c.phone=:phone AND a.start<=NOW()";
        $clientData = DB::table('appointments')
            ->select(DB::raw('count(*) AS num_visits, MAX(appointments.start) AS last_visit'))
            ->join('clients', 'appointments.client_id', '=', 'clients.client_id')
            ->where('clients.is_active', true)
            ->where('clients.phone', $phone)
            ->whereRaw('appointments.start <= NOW()')
            ->get();
        $clientData = $clientData->first();
        if ($clientData->num_visits == 0) {
            echo '';
            exit;
        }
        //echo print_r($clientData, TRUE); exit;

        echo view('appointment.tpl.clientinfo', ['clientData' => $clientData])->render();
    }
}
