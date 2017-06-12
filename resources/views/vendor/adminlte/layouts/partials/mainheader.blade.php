<!-- Main Header -->
<header class="main-header">
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Navbar Right Menu -->
         <div class="navbar-custom-menu">
             <div class="login">
                 <a href="/user/cabinet">
                     <img src="{{ $user->getAvatarUri() }}" class="img-circle" alt="User Image"/>
                     {{ Auth::user()->name }}
                 </a>
                 <div class="dropdown locale-dropdown">
                     <button class="btn btn-default dropdown-toggle dropbtn btn-flag {{ App::getLocale() }}" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                         <span class="caret"></span>
                     </button>
                     <div class="dropdown-content">
                         @foreach (Config::get('app.languages') as $lang => $language)
                         @if ($lang != App::getLocale())
                            <a class="lang-flag {{$lang}}" href="/locale/{{$lang}}">{{$language}}</a>
                         @endif
                         @endforeach
                     </div>
                 </div>
             </div>
             <a href="/home" class="logo"><img src="/img/landing/logo.svg"></a>

             <!-- Org name/logo of branches dropdown -->
             <?php $branches = $user->organization->superOrganization->organizations;?>
             @if (count($branches) == 1)
                 <a href="/organization/edit" class="org-logo white">
                     @if ($user->organization->logo_image != '')
                         <img src="{{$user->organization->getLogoUri()}}">
                     @else
                         {{ $user->organization->name }}
                     @endif
                 </a>
             @else
                 <div class="dropdown branch-dropdown">
                     <button class="btn btn-default dropdown-toggle dropbtn" type="button" data-toggle="dropdown">
                         {{$user->organization->name}}<span class="caret"></span>
                     </button>
                     <ul class="dropdown-menu">
                         @foreach ($branches as $org)
                             @if ($org->organization_id != $user->organization->organization_id)
                                 <li><a href="/changeBranch/{{$org->organization_id}}">{{$org->name}}</a></li>
                             @endif
                         @endforeach
                     </ul>
                 </div>
             @endif

             <ul class="nav navbar-nav" style="display: none">
                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <li class="dropdown langs-menu">
                        <!-- Logo -->
                        <a href="{{ url('/home') }}" class="logo">
                            <img src="{{ $user->getAvatarUri() }}" class="img-circle" alt="User Image" />
                            <p>
                                {{ Auth::user()->name }}
                                {{-- <small>{{ trans('adminlte_lang::message.login') }} Nov. 2012</small> --}}
                            </p>
                        </a>
                    </li>
                    <li class="dropdown langs-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-language"></i><span class="label label-flag {{ App::getLocale() }}"></span>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach (Config::get('app.languages') as $lang => $language)
                                @if ($lang != App::getLocale())
                                    <li>
                                        <a class="lang-flag {{$lang}}" href="/locale/{{$lang}}">{{$language}}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ $user->getAvatarUri() }}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{ $user->getAvatarUri() }}" class="img-circle" alt="User Image" />
                                <p>
                                    {{ Auth::user()->name }}
                                    {{-- <small>{{ trans('adminlte_lang::message.login') }} Nov. 2012</small> --}}
                                </p>
                            </li>
                            <!-- Menu Body -->
                            {{-- <li class="user-body">
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ trans('adminlte_lang::message.followers') }}</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ trans('adminlte_lang::message.sales') }}</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">{{ trans('adminlte_lang::message.friends') }}</a>
                                </div>
                            </li> --}}
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ url('user/cabinet') }}" class="btn btn-default btn-block">{{ trans('adminlte_lang::message.profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-block"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ trans('adminlte_lang::message.signout') }}
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="submit" value="logout" style="display: none;">
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
