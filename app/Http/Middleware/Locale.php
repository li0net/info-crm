<?php
/**
 * http://www.glutendesign.com/posts/detect-and-change-language-on-the-fly-with-laravel
 * https://laravel.io/forum/02-20-2014-how-to-make-switching-language-button
 * https://laracasts.com/discuss/channels/general-discussion/where-to-setlocale-in-laravel-5-on-multilingual-multidomain-app
 * https://mydnic.be/post/laravel-5-and-his-fcking-non-persistent-app-setlocale
 * https://laracasts.com/discuss/channels/tips/example-on-how-to-use-multiple-locales-in-your-laravel-5-website
 * https://laracasts.com/discuss/channels/general-discussion/set-locale-with-middleware-in-laravel-5
 * https://laravel.io/index.php/forum/02-23-2015-laravel-5-switch-language?page=1
 * https://laracasts.com/discuss/channels/laravel/modifying-the-locale-via-controller-and-then-middleware
 * https://laracasts.com/discuss/channels/laravel/localizing-date-in-view-laravel-5
 */
namespace App\Http\Middleware;

use Closure;
use Cookie;
use Session;
use App;
use Config;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next) {

        if (Session::has('locale')) {
            $locale = Session::get('locale', Config::get('app.locale'));
        } else {
            //getting list of languages
            $languages = array_keys(Config::get('app.languages'));
            $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            if ( ! in_array($locale, $languages) ) {
                $locale = Config::get('app.locale');
            }
        }
        App::setLocale($locale);
        return $next($request);
    }
}

