<!--<div class="col-xs-1 text-left"><a href="#" class="navbar-link login-link"><i class="fa fa-sign-in" aria-hidden="true"></i></a></div>-->
<div  class="col-xs-1 text-left widget-icon-lang">
    <div class="dropdown">
        <button class="btn btn-default dropdown-toggle dropbtn btn-flag {{ App::getLocale() }}" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
           <span class="caret"></span>
        </button>
        <div class="dropdown-content">
            @foreach (Config::get('app.languages') as $lang => $language)
                @if ($lang != App::getLocale())
                    <a class="lang-flag {{$lang}}" href="/api/v1/widget/locale/{{$lang}}">{{$language}}</a>
                @endif
            @endforeach
        </div>
    </div>
</div>
<div class="col-xs-10 text-center ellipsis widget-head-info"><a href="#" class="navbar-link orgname-link">{{ $superOrganization->name or '' }}</a></div>
<div class=" col-xs-1 text-right widget-icon-info"><a href="#" class="navbar-link info-link"><i class="fa fa-info-circle" aria-hidden="true"></i></a></div>

