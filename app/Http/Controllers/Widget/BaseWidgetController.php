<?php

namespace App\Http\Controllers\Widget;

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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

use \App\Http\Controllers\Controller;

class BaseWidgetController extends Controller
{
    private $superOrganization = NULL;
    private $organization = NULL;

    /*
    $user = App\User::find(1);
    // Creating a token without scopes...
    $token = $user->createToken('TestWidgetToken')->accessToken;
    // Creating a token with scopes...
    $token = $user->createToken('TestWidgetToken', ['place-orders'])->accessToken;
    */

    public function __construct()
    {
        //$this->middleware('auth');
        //$this->middleware('permissions');   //->only(['create', 'edit', 'save']);

        // Hardcode
        // TODO: get super organization id from token
        $this->superOrganization = superOrganization::find('1');
        // шарим superOrganization чтобы была доступна в основном темплейте виджета
        view()->share('superOrganization', $this->superOrganization);

        if (Input::get('org_id')) {
            // TODO: проверить соответсвие организации и токена
            $this->organization = Organization::find(Input::get('org_id')); // post параметр org_id - organization id
            if (!$this->organization) {
                abort(401, '401 Unauthorized.');
            }
        }
    }

    /**
     *
     * загрузка основного экрана виджета с пустым контентом
     * @param Request $request
     * @return View|string
     */
    public function getInitScreen(Request $request)
    {
        return view('widget.layouts.main', [
            'superOrganization' => $this->superOrganization
        ]);
    }

    /**
     *
     * Отображение списка филиалов.
     * елси у суперогранизации есть филиала - переходим к экрану выбора филиала
     * если нет - переходим к экрану категорий услуг
     * @param Request $request
     * @return View|string
     */
    public function getDivisions(Request $request)
    {
        // отображение отделения организации, если их больше 1
        $organizations = $this->superOrganization->organizations();

        if ($organizations->count() > 1) {
            // Отрисовка экрана виджета на этапе выбора филиала
            $view = View::make('widget.pages.divisions', [
                'organizations' => $organizations->getResults()
            ]);
            return $view->render();
        } else {
            // если филиал только один, сразу показываем набор доступных категорий услуг
            $this->organization = $organizations->first();
            return $this->getServiceCategories($request);
        }
    }


    /**
     * Отрисовка этапа выбора категории услуг
     * @param Request $request
     * @return View
     */
    public function getServiceCategories(Request $request)
    {
        // отображение услуг в данном отделении (или всей организации, если отделение только одно)
        if (is_null($this->organization)) {
            abort(500, 'Internal server error. Organization not set.');
        }

        $sc = $this->organization->serviceCategories();

        if ($sc->count() == 0) {
            abort(500, 'Internal server error. No service categories.');
        }

        if ($sc->count() == 1) {
            return $this->getServices($request, $sc->first());
        }

        $view = View::make('widget.pages.categories', [
            'categories' => $sc->getResults()
        ]);
        return $view->render();
    }

    /**
     * Отрисовка этапа выбора услуг
     * @param Request $request
     * @return View
     */
    public function getServices(Request $request, ServiceCategory $sc = NULL)
    {
        // может не существовать, если у организации только одна категория услуг
        $serviceCategoryId = $request->input('sc_id'); // post параметр sc_id - service category id

        if (empty($serviceCategoryId)) {
            if (is_null($sc)) {
                abort(500, 'Internal server error. Service category not set.');
            }
        } else {
            $sc = ServiceCategory::where('service_category_id', $serviceCategoryId)
                ->where('organization_id', $this->organization->organization_id)
                ->first();
            if (!$sc) {
                abort(500, 'Internal server error. Service category error.');
            }
        }
        $services = $sc->services();
        if ($services->count() == 0) {
            abort(500, 'Internal server error. No services found.');
        }

        $view = View::make('widget.pages.services', [
            'services' => $services->getResults()
        ]);
        return $view->render();
    }

    /**
     * Отрисовка списка сотрудников
     * @param Request $request
     * @return mixed
     */
    public function getEmployees(Request $request)
    {
        // отображение сотрудников оказывающих эту услугу
        // + вариант "Мастер не важен"

        $serviceId = $request->input('service_id'); // post параметр service_id - service id

        if (empty($serviceId)) {
            abort(501, 'Internal server error. Service not set.');
        }

        $service = Service::where('service_id', $serviceId)
            ->join('service_categories', 'services.service_category_id', '=', 'service_categories.service_category_id')
            ->where('service_categories.organization_id', $this->organization->organization_id)
            ->first();

        if ( ! $service) {
            abort(501, 'Internal server error. Service error.');
        }

        // Отображаем только тех, что разрешили онлайн запись (в employee_settings)
        $employees = DB::table('employees')
            ->join('employee_provides_service', 'employees.employee_id', '=', 'employee_provides_service.employee_id')
            ->join('employee_settings', 'employees.employee_id', '=', 'employee_settings.employee_id')
            ->join('positions', 'employees.position_id', '=', 'positions.position_id')
            ->select('employees.*','employees.avatar_image_name as avatar', 'employee_settings.*', 'positions.title as position_name' , 'positions.description as description')
            ->where('employees.organization_id', $this->organization->organization_id)
            ->where('employee_provides_service.service_id', $service->service_id)
            ->where('employee_settings.reg_permitted', 1)
            ->get();

        if ( $employees->count() == 0 ) {
            abort(500, 'Internal server error. No employees for service found.');
            // TODO: такой вариант не является аномалией, нужно придусмотреть view для него
        }

        $view = View::make('widget.pages.employees', [
            'employees' => $employees
        ]);

        return $view->render();
        // TODO: добавить вариант "Мастер не важен"
        // TODO: во view также передаем service_id и пишем его в скрытое поле
    }

    /**
     * Отображает календарь с днями доступными для записи к выбранному мастеру на выбранную услугу
     * @param Request $request
     * @return mixed
     */
    public function getAvailableDays(Request $request)
    {
        $formData = $request->only(['service_id', 'employee_id']); // post параметр service_id, employee_id
        $validator = Validator::make($formData, [
            'service_id'    => 'required|max:10',
            'employee_id'    => 'required|max:10'
        ]);
        if ($validator->fails()) {
            // TODO: Что делать - просто отобразить ошибку или сделать редирект?
        }
        /*// фейковый массив
        $days = array();
        $days[0] = array(
            'day' => '2017-02-24',
            'is_available' => false,
            'is_nonworking' => false
        );
        $days[1] = array(
            'day' => '2017-02-25',
            'is_available' => true,
            'is_nonworking' => false
        );
        $days[2] = array(
            'day' => '2017-02-26',
            'is_available' => true,
            'is_nonworking' => false
        );
        $days[3] = array(
            'day' => '2017-02-27',
            'is_available' => false,
            'is_nonworking' => false
        );
        $days[4] = array(
            'day' => '2017-02-28',
            'is_available' => true,
            'is_nonworking' => false
        );*/

        $employee = Employee::find($request->input('employee_id'));
        $days = $employee->getFreeWorkDaysForCurrMonth();

        $view = View::make('widget.pages.days', [
            'days' => $days
        ]);


        return $view->render();
    }

    /**
     *  Отображает доступное время для записи для выбранного дня
     * @param Request $request
     * @return mixed
     */
    public function getAvailableTime(Request $request)
    {
        $formData = $request->only(['service_id', 'employee_id', 'date']);  // post параметр service_id, employee_id, day

        $employee = Employee::find($request->input('employee_id'));
        $service = Service::find($request->input('service_id'));
        $date = $request->input('date');
        $times = $employee->getFreeWorkTimesForDay($date, $service);
        // фейковый массив

//        $times = array();
//        $times[0] = array(
//        'work_end' => '2017-02-10 09:30:00',
//        'work_end' => '2017-02-10 13:00:00'
//        );

        $view = View::make('widget.pages.times', [
            'times' => $times

        ]);
        return $view->render();
        }

           /**
            * Отображает форму с полями для ввода имени, телефона, адреса электронной почты и т.д.
            * @param Request $request
            */
    public function getUserInformationForm(Request $request)
    {
        // все собранные данные для отображения на форме
        $data = array(
            'time' => $request->input('time'),
            'date' => $request->input('date'),
            'employeeId' => $request->input('employee_id'),
            'organizationId' => $request->input('org_id'),
            'serviceId' => $request->input('service_id'),
        );

        $view = View::make('widget.pages.clientform', [
            'data' => $data
        ]);
        return $view->render();
    }

    // Отображает форму с полями для ввода имени, телефона, адреса электронной почты и т.д.
    public function handleUserInformationForm(Request $request)
    {
        /*
        time:"11:00"
        date:"2017-02-27"
        employee_id:"5"
        organization_id:""
        service_id:""

        client_name:"name_entered"
        client_phone:"+7854522221122"
        client_comment:"commentaryi"
        agree:"on"
        */

        $validator = Validator::make($request->all(), [
            'agree'         => 'accepted',
            'time'          => 'required',
            'date'          => 'required|date_format:"Y-m-d"',
            'employee_id'   => 'required|max:12',
            'organization_id' => 'required|max:12',
            'service_id'     => 'required|max:12|exists:services,service_id',
            'client_name'   => 'required|max:120',
            'client_phone'  => 'required|phone_crm' // custom validation rule
        ]);

        if ($validator->fails()) {
            return json_encode(array(
                'success'   => false,
                'errors'    => $validator->messages()
            ));
        }

        $service = Service::where('service_id', $request->input('service_id'))
            ->join('service_categories', 'services.service_category_id', '=', 'service_categories.service_category_id')
            ->where('service_categories.organization_id', $request->input('organization_id'))
            ->first();
        if (!$service) return json_encode($this->getCommonError());

        $appStart = $request->input('date').' '.$request->input('time').':00';
        if (!preg_match('/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/', $appStart)) return json_encode($this->getCommonError());

        $appStartTs = strtotime($appStart);
        if ($appStartTs === false) return json_encode($this->getCommonError());

        list($sDurationHours, $sDurationMinutes, $sDurationSeconds) = explode(':', $service->duration);
        $endTs = strtotime($appStart.' + '.$sDurationHours.' hours '.$sDurationMinutes.' minutes');
        $appEnd = date('Y-m-d H:i:s', $endTs);

        // Проверка что данное время все еще свободно у мастера
        $employee = Employee::find($request->input('employee_id'))->where('organization_id', $request->input('organization_id'))->first();
        if (!$employee) return json_encode($this->getCommonError());
        $freeTimesForService = $employee->getFreeWorkTimesForDay($request->input('date'), $service);
        if ($freeTimesForService === FALSE OR count($freeTimesForService) == 0) {
            return json_encode($this->getCommonError(trans('main.widget:error_time_already_taken')));
        }
        $timeIsFree = false;
        foreach ($freeTimesForService AS $freeTime) {
            if ($request->input('time') == $freeTime) {
                $timeIsFree = true;
                break;
            }
        }
        if (!$timeIsFree) {
            return json_encode($this->getCommonError(trans('main.widget:error_time_already_taken')));
        }

        // Ищем клиента
        // TODO: искать клиента по комбинации имени-номера телефона-имейла ??
        //  имя и телефон нормализуем (имя - каждое слово с заглавной буквы, лишние пробелы между словами и до/после убираем, номер телефона - храним в стандартном формате)
        $usr = new User();
        $clientPhone = $usr->normalizePhoneNumber($request->input('client_phone'));
        $client = Client::where('organization_id', $request->input('organization_id'))
            ->where('phone', $clientPhone)
            ->first();

        // если такой клиент уже есть (поиск по номеру телефона) - добавляем ему email, если не было, иначе не апдейтим его
        //  а его id прописываем в $appointment->client_id
        if (is_null($client)) {
            $client = new Client();
            $client->name = $request->input('client_name');      // TODO: нормализовать
            $client->phone = $clientPhone;
            /*
            if ($request->input('client_email')) {
                $client->email = $request->input('client_email');
            }
            */
            $client->organization_id = $request->input('organization_id');
            $client->save();

        } else {
            // показывать в иджете поле для ввода email ?
            //if (empty($client->email) AND !empty($request->input('client_email'))) {
            //    $client->email = $request->input('client_email');
            //    $client->save();
            //}
        }

        // TODO: проверять что данный диапазон времени (start - end) не занят у работника
        $appointment = new Appointment();
        $appointment->organization_id = $request->input('organization_id');
        $appointment->client_id = $client->client_id;
        $appointment->service_id = $request->input('service_id');
        $appointment->start = $appStart;
        $appointment->end = $appEnd;
        $appointment->employee_id = $request->input('employee_id');
        if (!empty($request->input('client_comment'))) {
            $appointment->note = $request->input('client_comment');
        }
        // TODO: поменять, когда появится поддержка 'Мастер не важен'
        $appointment->is_employee_important = 1;
        $appointment->source = 'widget';

        $appointment->save();

        //TODO обработка ошибок
        //TODO экран завершения
        $result=array(
            'res' => TRUE
        );
        return json_encode($result);
    }


    public function getOrgInformation(Request $request)
    {
        $this->organization = Organization::find(Input::get('org_id'));
        if (!$this->organization) {
            abort(401, '401 Unauthorized.');
        }

        $view = View::make('widget.pages.org_info', [
            'organization' =>  $this->organization
        ]);
        $contents = $view->render();
        return $contents;
    }

    private function getCommonError($msg = 'Data error') {
        return array(
            'success' => false,
            'errors' => $msg
        );
    }
}