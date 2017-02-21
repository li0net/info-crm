<?php

namespace App\Http\Controllers\Widget;

use App\ServiceCategory;
use Illuminate\Http\Request;
use App\User;
use App\SuperOrganization;
use App\Organization;
use App\AccessPermission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Symfony\Component\EventDispatcher\Tests\Service;

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
        $this->superOrganization = SuperOrganization::find('1');

        if (Input::get('org_id')) {
            // TODO: проверить соответсвие организации и токена
            $this->organization = Organization::find(Input::get('organization_id'));         // post параметр org_id - organization id
            if (!$this->organization) {
                abort(401, '401 Unauthorized.');
            }
        }
    }

    // Отображает филиалы организации
    public function getDivision(Request $request)
    {
        // отображение отделения организации, если их больше 1
        $orgs = $this->superOrganization->organizations();

        if ($orgs->count() > 1) {
            return $orgs->getResults();
            // TODO: load view to list all divisions
        } else {
            $this->organization = $orgs->first();
            // если отделение только одно сразу показываем набор доступных услуг
            return $this->getServiceCategories($request);
        }
    }

    // Отображает категории услуг
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

        if ($sc->count()==1) {
            return $this->getServices($request, $sc->first());
        }

        return $sc->getResult();
        // TODO: load view to list all service categories
    }

    // Отображает услуги
    public function getServices(Request $request, ServiceCategory $sc = NULL)
    {
        // может не существовать, если у организации только одна категория услуг
        $serviceCategoryId = $request->input('sc_id');                                  // post параметр sc_id - service category id
        if (empty($serviceCategoryId))
        {
            if (is_null($sc))
            {
                abort(500, 'Internal server error. Service category not set.');
            }
        } else
        {
            $sc = ServiceCategory::where('service_category_id', $serviceCategoryId)
                ->where('organization_id', $this->organization->organization_id)
                ->first();
            if (!$sc)
            {
                abort(500, 'Internal server error. Service category error.');
            }
        }

        $services = $sc->services();
        if ($services->count() == 0)
        {
            abort(500, 'Internal server error. No services found.');
        }

        // В любом случае, надо показать название услуги, даже если она всего одна
        //if ($services->count() == 1) {
        //    return $this->getEmployees($request, $services->first());
        //}

        return $services->getResults();
        // TODO: load view to list all services
        /*
        foreach($services AS $service) {
            {{$service->name}}
            {{$service->price_min}}
        }
        */
    }


    // Отображает сотрудников
    public function getEmployees(Request $request)
    {
        // отображение сотрудников оказывающих эту услугу
        // + вариант "Мастер не важен"

        $serviceId = $request->input('service_id');                                     // post параметр service_id - service id
        if (empty($serviceId))
        {
            abort(500, 'Internal server error. Service not set.');
        }

        $service = Service::where('service_id', $serviceId)
            ->where('organization_id', $this->organization->organization_id)
            ->first();
        if (!$service)
        {
            abort(500, 'Internal server error. Service error.');
        }

        $employees = $service->employees();
        if ($employees->count() == 0) {
            abort(500, 'Internal server error. No employees for service found.');
            // TODO: такой вариант не является аномалией, нужно придусмотреть view для него
        }

        return $employees->getResults();
        // TODO: добавить вариант "Мастер не важен"
        // TODO: во view также передаем service_id и пишем его в скрытое поле
    }

    // Отображает календарь с днями доступными для записи к выбранному мастеру на выбранную услугу
    public function getAvailableDays(Request $request)
    {
        $formData = $request->only(['service_id', 'employee_id']);                        // post параметр service_id, employee_id

        $validator = Validator::make($formData, [
            'service_id'    => 'required|max:10',
            'employee_id'    => 'required|max:10'
        ]);
        if ($validator->fails()) {
            // TODO: Что делать - просто отобразить ошибку или сделать редирект?
            return redirect('/clients/create')
                ->withErrors($validator)
                ->withInput();
        }

        // TODO: получить массив дат этого месяца с атрибутами 'день доступен для записи', 'день недоступен для записи'
    }

    // Отображает доступное время для записи для выбранного дня
    public function getAvailableTime(Request $request)
    {
        $formData = $request->only(['service_id', 'employee_id']);                        // post параметр service_id, employee_id, day
    }

    // Отображает форму с полями для ввода имени, телефона, адреса электронной почты и т.д.
    public function getUserInformationForm(Request $request)
    {
        $formData = $request->only(['service_id', 'employee_id', 'date', 'time']);         // post параметр service_id, employee_id
    }
}