<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App;
use Config;

class LandingController extends Controller {
    public function index(Request $request) {
        // getting locale
        $locale = App::getLocale();

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
