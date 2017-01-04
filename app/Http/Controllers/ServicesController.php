<?php

namespace App\Http\Controllers;
use App\ServiceCategory;
use App\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ServicesController extends Controller
{

    protected $durationOptions;

    public function __construct()
    {
        // TODO: убрать после доработки логина
        auth()->loginUsingId(1);

        $this->middleware('auth');

        $this->durationOptions = [
            [
                'value' => '00:15:00',
                'label' => '0:15'
            ],
            [
                'value' => '00:30:00',
                'label' => '0:30',
                'selected' => true
            ],
            [
                'value' => '00:45:00',
                'label' => '0:45'
            ],
            [
                'value' => '01:00:00',
                'label' => '1:00'
            ],
            [
                'value' => '01:15:00',
                'label' => '1:15'
            ],
            [
                'value' => '01:30:00',
                'label' => '1:30'
            ],
            [
                'value' => '01:45:00',
                'label' => '1:45'
            ],
            [
                'value' => '02:00:00',
                'label' => '2:00'
            ],
            [
                'value' => '02:30:00',
                'label' => '2:30'
            ],
            [
                'value' => '03:00:00',
                'label' => '3:00'
            ],
            [
                'value' => '03:30:00',
                'label' => '3:30'
            ],
            [
                'value' => '04:00:00',
                'label' => '4:00'
            ]
        ];
    }


    /**
     * Show the service categories list
     *
     * @return Response
     */
    public function index()
    {
        $newServiceUrl = action('ServicesController@create');
        return view('adminlte::services', compact('newServiceUrl'));
    }

    // форма создания услуги
    public function create(Request $request)
    {
        $serviceCategoriesOptions = $this->prepareSelectData($request);
        return view('adminlte::serviceform', ['durationOptions' => $this->durationOptions, 'serviceCategoriesOptions' => $serviceCategoriesOptions]);
    }

    // форма редактирования услуги
    public function edit(Request $request, Service $service)
    {
        // TODO: выводить ошибку в красивом шаблоне
        if ($service->serviceCategory()->first()->organization_id != $request->user()->organization_id) {
            return 'You don\'t have access to this item';
        }

        $serviceCategoriesOptions = $this->prepareSelectData($request);

        return view(
            'adminlte::serviceform',
            [
                'durationOptions' => $this->durationOptions,
                'serviceCategoriesOptions' => $serviceCategoriesOptions,
                'service' => $service
            ]
        );
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'service_category_id' => 'required|max:10',
            'name' => 'required|max:255',
            'description' => 'present',
            'price_min' => 'required|numeric',
            'price_max' => 'required|numeric',
            'duration'  => 'required|date_format:"H:i:s"'
        ]);

        $sId = $request->input('service_id');
        // определить создание это или редактирование (по наличию поля service_id)
        // если редактирвоание - проверить что объект принадлежить текущему пользователю
        if (!is_null($sId)) {  // редактирование
            // Проверяем есть ли у юзера права на редактирование Услуг
            $accessLevel = $request->user()->hasAccessTo('service', 'edit', 0);
            if ($accessLevel < 1) {
                throw new AccessDeniedHttpException('You don\'t have permission to access this page');
            }

            $service = Service::find($sId);
            if (is_null($service)) {
                return 'Record doesn\'t exist';
            }
            if ($service->serviceCategory()->first()->organization_id != $request->user()->organization_id) {
                return 'Record doesn\'t exist';
            }

        } else {
            $service = new Service();
        }

        $service->service_category_id = $request->input('service_category_id');
        $service->name = $request->input('name');
        if (trim($request->input('description')) != '') {
            $service->description = $request->input('description');
        }
        $service->price_min = $request->input('price_min');
        $service->price_max = $request->input('price_max');
        $service->duration = $request->input('duration');
        $service->save();

        return redirect()->to('/services');
    }

    protected function prepareSelectData($request) {
        $serviceCategoriesOptions = array();
        $scDb = ServiceCategory::where('organization_id', $request->user()->organization_id)
            ->orderby('name', 'asc')
            ->get();
        foreach ($scDb AS $serviceCategory) {
            $serviceCategoriesOptions[] = [
                'value'     => $serviceCategory->service_category_id,
                'label'     => $serviceCategory->name
            ];
        }
        return $serviceCategoriesOptions;
    }

}