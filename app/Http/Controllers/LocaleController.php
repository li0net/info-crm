<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use URL;
use Config;
use Session;

class LocaleController extends Controller {

    public function setLocale($locale){
        //getting list of languages
        $languages = array_keys(Config::get('app.languages'));

        if ( ! in_array($locale, $languages) ) {
            $locale = Config::get('app.locale');
        }
        Session::put('locale', $locale);
        return redirect(url(URL::previous()));
    }
}