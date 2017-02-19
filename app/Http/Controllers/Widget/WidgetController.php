<?php

namespace App\Http\Controllers\Widget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WidgetController extends Controller
{
    public function index(Request $request) {
        $this->render($request);
    }

    public function render(Request $request) {
//        dd($request);
        $data['oid'] = $request['oid'];
        $data['geo'] = $request['geo'];
        $data['lang'] = $request['lang'];
        return view('widget/main', $data);
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
