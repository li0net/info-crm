<?php

namespace App\Http\Controllers\Widget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Organization;
use App\ServiceCategory;
use Illuminate\Support\Facades\DB;

class WidgetController extends Controller
{
    public function index(Request $request) {
        $this->render($request);
    }

    public function render(Request $request) {
        // get the organization
        $orgId = $request['o']; //TODO validate
        $org = Organization::find($orgId);

        // get the service categories
        // TODO подумать елси категорий будет много - как их разместить на виджете
        $orderBy = $request->input('sidx', 'name');
        $sortOrder = $request->input('sord', 'asc');

        $serviceCategories = DB::table('service_categories')
            ->select('service_category_id', 'name', 'online_reservation_name', 'gender')
            ->where('organization_id', $org->organization_id)
            ->orderBy($orderBy, $sortOrder)
            ->get();

        foreach ($serviceCategories AS $row) {

            if (is_null($row->gender)) {
                $row->gender = 'все';
            } elseif ($row->gender == 1) {
                $row->gender = 'м';
            } else {
                $row->gender = 'ж';
            }
        }

//        $serviceCategories = array();
//        foreach ($dbRes AS $row) {
//            if (is_null($row->gender)) {
//                $gender = 'все';
//            } elseif ($row->gender == 1) {
//                $gender = 'м';
//            } else {
//                $gender = 'ж';
//            }
//
//            $serviceCategories[]['service_category_id'] = $row->service_category_id;
//            $serviceCategories[]['name'] = $row->name;
//            $serviceCategories[]['online_reservation_name'] = $row->online_reservation_name;
//            $serviceCategories[]['gender'] = $gender;
//        }
//        $serviceCategories = array();
//        foreach ($dbRes AS $row) {
//
//            if (is_null($row->gender)) {
//                $gender = 'все';
//            } elseif ($row->gender == 1) {
//                $gender = 'м';
//            } else {
//                $gender = 'ж';
//            }
//            $serviceCategories = [
//                'service_category_id' => $row->service_category_id,
//                'name' => $row->name,
//                'online_reservation_name' => $row->online_reservation_name,
//                'gender' => $gender,
//            ];
//        }
//        dd($serviceCategories);
//        die;


        return view('widget.main', [
            'organization' => $org,
            'serviceCategories' => $serviceCategories
        ]);


//        // getting locale
//        $locale = App::getLocale();
//        if ( $locale == 'es' OR $locale == 'ca' ){
//            $locale = 'en';
//        }
//
//        //getting the page for show
//        $page = 'index';
//        if ( ! empty($request->p)){
//            //TODO validate param
//            if (view()->exists("adminlte::layouts.landing.{$locale}.".$request->p)){
//                $page = $request->p;
//            }
//        }
//
//        // getting names of sub-views
//        $sidepanel = "adminlte::layouts.landing.{$locale}.sidepanel";
//        $content = "adminlte::layouts.landing.{$locale}.".$page;
//
//        return view(
//            'adminlte::layouts.landing',
//            [
//                'locale'    => $locale,
//                'content'   => $content,
//                'sidepanel' => $sidepanel,
//                'page'      => $page,
//            ]
//        );
    }
}
