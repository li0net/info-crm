<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organization;
use Session;
use Illuminate\Support\MessageBag;

class OrganizationsController extends Controller
{

    protected $businessAreasOptions;
    protected $timezonesOptions;

    public function __construct()
    {
        //auth()->loginUsingId(1);

        $this->middleware('auth');

        $this->businessAreasOptions = [
            [
                'value' => 'beauty',
                'label' => 'Салоны красоты/Парикмахерские',
                'selected' => true
            ],
            [
                'value' => 'auto',
                'label' => 'Авто-мастерские/Шиномонтажные'
            ],
            [
                'value' => 'massage_spa',
                'label' => 'Массажный кабинеты/Спа-салоны'
            ]
        ];

        $timezoneIds = \DateTimeZone::listIdentifiers();
        $currTimezone = date_default_timezone_get();
        foreach ($timezoneIds AS $timezoneId) {
            $dt = new \DateTime('now', new \DateTimeZone($timezoneId));
            $this->timezonesOptions[] = ['value' => $timezoneId, 'label' => $dt->format('H:i Y.m.d')];
            if ($timezoneId == $currTimezone) {
                // для дев машины - $currTimezone == UTC
                $this->timezonesOptions[count($this->timezonesOptions)-1]['selected'] = true;
            }
        }
    }

    // форма редактирования организации
    public function edit(Request $request)
    {
        $org = Organization::find($request->user()->organization_id);

        // TODO: убрать и продолжить работать над редактированием организации
        //dd($this->timezonesOptions);

        return view(
            'adminlte::organizationform',
            [
                'businessAreasOptions' => $this->businessAreasOptions,
                'timezonesOptions' => $this->timezonesOptions,
                'organization' => $org
            ]
        );
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:150',
            'category' => 'max:150',
            'timezone' => 'max:30',
            'country' => 'max:60',
            'city' => 'max:60',
            'logo_image' => 'image'
        ]);

        // Проверяем, что строка с timezone входит в список разрешенных значений
        $timezone = $request->input('timezone');
        if (!is_null($timezone)) {
            $tzInList = FALSE;
            foreach ($this->timezonesOptions AS $tOption) {
                if ($tOption['value'] == $timezone) {
                    $tzInList = true;
                    break;
                }
            }
            if (!$tzInList) {
                return back()
                    ->withErrors(new MessageBag(array('timezone' => array('Invalid timezone'))))
                    ->withInput();
            }
        }

        $organization = Organization::find($request->user()->organization_id);

        // Проверяем, действительно ли загруженный файл - изображение
        if(isset($_FILES["logo_image"]["tmp_name"]) AND trim($_FILES["logo_image"]["tmp_name"]) != '') {
            $targetDir = public_path()."/uploaded_images/logo/main/";
            $imageUploadErrors = array();
            $imageFileType = pathinfo($targetDir.basename($_FILES["logo_image"]["name"]), PATHINFO_EXTENSION);
            $fileName = $organization->organization_id.'.'.$imageFileType;
            $targetFile = $targetDir.$fileName;

            $check = getimagesize($_FILES["logo_image"]["tmp_name"]);
            if($check === false) {
                $imageUploadErrors[] = "File is not an image";
            }

            // не более 5Мбайт
            if ($_FILES["logo_image"]["size"] > 5242880) {
                $imageUploadErrors[] = "Sorry, your file is too large.";
            }

            if (count($imageUploadErrors) > 0) {
                return back()
                    ->withErrors( new MessageBag(array('logo_image' => $imageUploadErrors)) )
                    ->withInput();
            // if everything is ok, try to upload file
            } else {
                if (!move_uploaded_file($_FILES["logo_image"]["tmp_name"], $targetFile)) {
                    Log::error('Failed to move uploaded file', ['targetFile' => $targetFile]);
                } else {
                    // if uploaded  - save file as logo
                    $organization->logo_image = $fileName;
                }
            }
        }

        $organization->name = $request->input('name');
        $organization->category = $request->input('category');
        if (!is_null($timezone)) {
            $organization->timezone = $request->input('timezone');
        }
        $organization->country = $request->input('country');
        $organization->city = $request->input('city');
        $organization->currency = $request->input('currency');
        $organization->info = $request->input('info');

        $organization->save();

        return redirect()->to('/organization/edit')->with('status', 'Profile updated!');;
    }

    public function editInfo(Request $request)
    {
        $org = Organization::find($request->user()->organization_id);

        return view('organization.edit', ['organization' => $org]);
    }

    public function saveInfo(Request $request)
    {
        $org = Organization::find($request->user()->organization_id);

        if ($request->input('id') == 'organization_form__info') {
            $org->address = $request->input('address');
            $org->post_index = $request->input('post_index');
            $org->phone_1 = $request->input('phone_1');
            $org->phone_2 = $request->input('phone_2');
            $org->phone_3 = $request->input('phone_3');
            $org->website = $request->input('website');
            $org->work_hours = $request->input('work_hours');
            $org->coordinates = $request->input('coordinates');
        }

        if ($request->input('id') == 'organization_form__description') {
            $org->info = $request->input('info');
        }

        if ($request->input('id') == 'organization_form__gallery') {
            // Проверяем, действительно ли загруженный файл - изображение
            if(isset($_FILES["logo_image"]["tmp_name"]) AND trim($_FILES["logo_image"]["tmp_name"]) != '') {
                $targetDir = public_path()."/uploaded_images/logo/main/";
                $imageUploadErrors = array();
                $imageFileType = pathinfo($targetDir.basename($_FILES["logo_image"]["name"]), PATHINFO_EXTENSION);
                $fileName = $org->organization_id.'.'.$imageFileType;
                $targetFile = $targetDir.$fileName;

                $check = getimagesize($_FILES["logo_image"]["tmp_name"]);
                if($check === false) {
                    $imageUploadErrors[] = "File is not an image";
                }

                // не более 5Мбайт
                if ($_FILES["logo_image"]["size"] > 5242880) {
                    $imageUploadErrors[] = "Sorry, your file is too large.";
                }

                if (count($imageUploadErrors) > 0) {
                    return back()
                        ->withErrors( new MessageBag(array('logo_image' => $imageUploadErrors)) )
                        ->withInput();
                    // if everything is ok, try to upload file
                } else {
                    if (!move_uploaded_file($_FILES["logo_image"]["tmp_name"], $targetFile)) {
                        Log::error('Failed to move uploaded file', ['targetFile' => $targetFile]);
                        dd('Failed to move uploaded file targetFile = '. $targetFile);
                    } else {
                        // if uploaded  - save file as logo
                        $org->logo_image = $fileName;
                    }
                }
            }
        }
        $org->save();

        Session::flash('success', trans('adminlte_lang::message.org_info_saved'));

        return view('organization.show', ['organization' => $org]);
    }
}
