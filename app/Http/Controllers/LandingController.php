<?php
namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingController extends Controller {
    public function index(Request $request) {
        // getting locale
        $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        $locale = ($locale == 'ru') ? $locale : 'en';

        //getting the page for show
        $page = 'index';
        if ( ! empty($request->p)){
            //TODO validate param
            if (view()->exists("adminlte::layouts.landing.{$locale}.".$request->p)){
                $page = $request->p;
            }
        }

        // getting names of sub-views
        $sidepanel = "adminlte::layouts.landing.{$locale}.sidepanel";
        $content = "adminlte::layouts.landing.{$locale}.".$page;

        return view(
            'adminlte::layouts.landing',
            [
                'locale'    => $locale,
                'content'   => $content,
                'sidepanel' => $sidepanel,
                'page'      => $page,
            ]
        );
    }
}
