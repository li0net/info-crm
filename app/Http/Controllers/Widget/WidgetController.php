<?php

namespace App\Http\Controllers\Widget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Organization;
use App\ServiceCategory;
use Illuminate\Support\Facades\DB;

class WidgetController extends Controller
{




    // Отображает услуги
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





























    /**
     * Отрисовка первого экрана виджета на этапе выбора категории услуг
     * @param Request $request
     * @return View
     */
    private function getServiceCategoriesStartScreen(Request $request){
        $sc = $this->getServiceCategories($request);

        if ( ! $sc) {
            abort(500, 'Internal server error. No service categories.');
        }

        if ($sc->count()==1) {
            return $this->getServices($request, $sc->first());
        }

        return $sc->getResults();
        if ($sc->count()==1) {
            return $this->getServices($request, $sc->first());
        }


        return view('widget.pages.categories', [
            'categories' => $this->getServiceCategories($request)
        ]);
    }

    /**
     * Получение вьюхи со списком категорий услуг
     * обращение по ajax
     * @param Request $request
     * @return bool
     */
    public function getServiceCategoriesScreen(Request $request){
        if (Input::get('org_id')) {
            // TODO: проверить соответсвие организации и токена
            $this->organization = Organization::find(Input::get('org_id'));
            if (!$this->organization) {
                abort(401, '401 Unauthorized.');
            }
//
            $view = View::make('widget.pages.categories_lite', [
                'categories' => $this->getServiceCategories($request)
            ]);
            $contents = $view->render();
            return $contents;
        } else {
            //TODO: добавить обработчик ошибки
            return FALSE;
        }
        //return json_encode($result);
    }


    /**
     * ПОлучает список категорйи услуг
     *
     * @param Request $request
     * @return mixed
     */
    private function getServiceCategories1(Request $request)
    {
        // отображение услуг в данном отделении (или всей организации, если отделение только одно)
        if (is_null($this->organization)) {
            abort(500, 'Internal server error. Organization not set.');
        }

        $sc = $this->organization->serviceCategories();
        if ($sc->count() == 0) {
            return FALSE;
        }
        return $sc->getResults();
    }

    // Отображает услуги
    public function getServicesAjax(Request $request, ServiceCategory $sc = NULL)
    {
        // может не существовать, если у организации только одна категория услуг
        $serviceCategoryId = $request->input('sc_id');
        // post параметр sc_id - service category id
        if (empty($serviceCategoryId))
        {
            if (is_null($sc))
            {
                abort(500, 'Internal server error. Service category not set.');
            }
        } else {
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

        $view = View::make('widget.pages.services', [
            'services' => $services->getResults()
        ]);
        $contents = $view->render();
        return $contents;

//        $result = array(
//            'res' => 'true',
//            'services' => $services->getResults()
//        );
//
//        return json_encode($result);

        // TODO: load view to list all services
        /*
        foreach($services AS $service) {
            {{$service->name}}
            {{$service->price_min}}
        }
        */
    }

    public function getServices1(Request $request, ServiceCategory $sc = NULL)
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
            abort(501, 'Internal server error. Service not set.');
        }
        $service = Service::where('service_id', $serviceId)
            ->join('service_categories', 'services.service_category_id', '=', 'service_categories.service_category_id')
            ->where('service_categories.organization_id', $this->organization->organization_id)
            ->first();

        if (!$service)
        {
            abort(502, 'Internal server error. Service error.');
        }

        //$employees = $service->employees();
        // Отображаем только тех, что разрешили онлайн запись (в employee_settings)
        $employees = DB::table('employees')
            ->join('employee_provides_service', 'employees.employee_id', '=', 'employee_provides_service.employee_id')
            ->join('employee_settings', 'employees.employee_id', '=', 'employee_settings.employee_id')
            ->select('employees.*','employees.avatar_image_name as avatar', 'employee_settings.*')
            ->where('employees.organization_id', $this->organization->organization_id)
            ->where('employee_provides_service.service_id', $service->service_id)
            ->where('employee_settings.reg_permitted', 1)
            ->get();

        if ($employees->count() == 0) {
            abort(500, 'Internal server error. No employees for service found.');
            // TODO: такой вариант не является аномалией, нужно придусмотреть view для него
        }
//        dd($employees);die;
        $view = View::make('widget.pages.employees', [
            'employees' => $employees
        ]);
        $contents = $view->render();
        return $contents;
//        return $employees->getResults();
        // TODO: добавить вариант "Мастер не важен"
        // TODO: во view также передаем service_id и пишем его в скрытое поле
    }

    // Отображает календарь с днями доступными для записи к выбранному мастеру на выбранную услугу
    public function getAvailableDays(Request $request)
    {
        $formData = $request->only(['service_id', 'employee_id']); // post параметр service_id, employee_id
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

        // фейковый массив
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
        );

        $view = View::make('widget.pages.days', [
            'days' => $days
        ]);
        $contents = $view->render();
        return $contents;
    }

    // Отображает доступное время для записи для выбранного дня
    public function getAvailableTime(Request $request)
    {
        $formData = $request->only(['service_id', 'employee_id', 'date']);  // post параметр service_id, employee_id, day

        // фейковый массив
        $times = array('10:00', '10:30', '11:00', '14:00', '16:30');
        $view = View::make('widget.pages.times', [
            'times' => $times
        ]);
        $contents = $view->render();
        return $contents;
    }

    // Отображает форму с полями для ввода имени, телефона, адреса электронной почты и т.д.
    public function getUserInformationForm(Request $request)
    {
        $formData = $request->only(['service_id', 'employee_id', 'date', 'time']);         // post параметр service_id, employee_id
        $this->organization = Organization::find(Input::get('org_id'));         // post параметр org_id - organization id
    }

    // Отображает форму с полями для ввода имени, телефона, адреса электронной почты и т.д.
    public function handleUserInformationForm(Request $request)
    {
        return json_encode(Input::get());
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
