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
use App\AccessPermission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
//use Symfony\Component\EventDispatcher\Tests\Service;

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
            ->select('employees.*','employees.avatar_image_name as avatar', 'employee_settings.*')
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
        $date = $request->input('date');
        $times = $employee->getFreeTimeIntervals($date, $date, TRUE);
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
            'organizationId' => $request->input('orgId'),
            'serviceId' => $request->input('serviceId'),
        );

        $view = View::make('widget.pages.clientform', [
            'data' => $data
        ]);
        return $view->render();
    }

    // Отображает форму с полями для ввода имени, телефона, адреса электронной почты и т.д.
    public function handleUserInformationForm(Request $request)
    {
        $formData = Input::get();
        //TODO сохранить заявку, создать клиента

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
}