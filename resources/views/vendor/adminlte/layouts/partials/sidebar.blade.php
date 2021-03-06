<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
            <i class="fa fa-times" aria-hidden="true"></i>
        </a>

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ $user->getAvatarUri() }}" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>
                    {{ Auth::user()->name }}
                </p>
            </div>
            <div class="clearfix"></div>
            <div class="links">
                <div class="pull-left">
                    <a href="{{ url('user/cabinet') }}" class="btn btn-link  btn-xs">
                        <i class="fa fa-cog" aria-hidden="true"></i>{{ trans('adminlte_lang::message.profile') }}
                    </a>
                </div>
                <div class="pull-right">
                    <a href="{{ url('/logout') }}" class="btn btn-link  btn-xs" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>{{ trans('adminlte_lang::message.signout') }}
                    </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        <input type="submit" value="logout" style="display: none;">
                    </form>

                </div>
            </div>
        </div>
        @endif
        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            {{-- <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
            <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span> --}}
            {{-- <div id="dp" @changeDate = 'onSelectDate'></div> --}}
            {{-- <input type="text" id="dp" class="form-control" value="02-12-2018" @change = 'onSelectDate'> --}}
            <div id="dp" class="hasDatepicker" data-date="12/03/2012"></div>
            <input type="hidden" id="my_hidden_input">
            {{-- <picker :value.sync="startDate"></picker> --}}
            {{-- <picker></picker> --}}
            {{-- <div class="datepicker" @changeDate = 'onSelectDate'> </div> --}}
        </form>
        <!-- /.search form -->

        <?php $page = Request::segment(1); ?>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="@if ($page == 'employee') active @endif">
                <a href="{{ url('/employee') }}"><i class='fa fa-black-tie'></i> <span>{{ trans('adminlte_lang::message.employees') }}</span></a>
            </li>
            <li class="treeview @if(in_array($page, array('clients', 'clientCategories'))) activated @endif">
                <a href="#" ><i class='fa fa-users'></i> <span>{{ trans('adminlte_lang::message.clients') }}</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    @if ($crmuser->hasAccessTo('clients_view', 'view', null))
                    <li class="@if ($page == 'clients') active @endif">
                        <a href="/clients">{{ trans('adminlte_lang::message.client_list') }}</a>
                    </li>
                    @endif
                    <li class="@if ($page == 'clientCategories') active @endif">
                        <a href="/clientCategories">{{ trans('adminlte_lang::message.loyality') }}</a>
                    </li>
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.electronic_cards') }}</a></li>--}}
                </ul>
            </li>
            <li class="treeview @if(in_array($page, array('home','summary'))) activated @endif">
                <a href="#"><i class='fa fa-newspaper-o'></i> <span>{{ trans('adminlte_lang::message.dashboard') }}</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li  class="@if ($page == 'home') active @endif">
                        <a href="/home">{{ trans('adminlte_lang::message.appointments') }}</a>
                    </li>
                    <li><a href="/summary">{{ trans('adminlte_lang::message.summary') }}</a></li>
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.comments') }}</a></li>--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.sms') }}</a></li>--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.calls') }}</a></li>--}}
                </ul>
            </li>

            {{--<li class="treeview @if(in_array($page, array('employee','services','clients','salesanalysis','storagebalance'),'salesanalysis'))) activated @endif">--}}
            <li class="treeview @if(in_array($page, array('employee', 'services', 'clients', 'salesanalysis', 'storagebalance'))) @endif">
                <a href="#"><i class='fa fa-line-chart'></i> <span>{{ trans('adminlte_lang::message.stats') }}</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.indicators') }}</a></li>--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.recurrence') }}</a></li>--}}
                    <li  class="@if ($page == 'employee') @endif">
                        <a href="{{ url('employee')}}">{{ trans('adminlte_lang::message.employees') }}</a>
                    </li>
                    <li  class="@if ($page == 'services') @endif">
                        <a href="{{ url('/services')}}">{{ trans('adminlte_lang::message.services') }}</a>
                    </li>
                    <li  class="@if ($page == 'clients') @endif">
                        <a href="{{ url('clients')}}">{{ trans('adminlte_lang::message.clients') }}</a>
                    </li>
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.finance_report') }}</a></li>--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.pl_report') }}</a></li>--}}
                    <li  class="@if ($page == 'storagebalance') @endif">
                        <a href="{{ url('/storagebalance') }}">{{ trans('adminlte_lang::message.stock_balance') }}</a>
                    </li>
                    <li  class="@if ($page == 'salesanalysis') @endif">
                        <a href="{{ url('/salesanalysis') }}">{{ trans('adminlte_lang::message.sales_analysis') }}</a>
                    </li>
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.settings') }}</a></li>--}}
                </ul>
            </li>

            @if ($crmuser->hasAccessTo('finances', 'view', null))
            <li class="treeview  @if(in_array($page, array('account','partner','item','wage_scheme','payment'))) activated @endif">
                <a href="#"><i class='fa fa-dollar'></i> <span>{{ trans('adminlte_lang::message.finance') }}</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li  class="@if ($page == 'account') active @endif">
                        <a href="{{ url('/account')}}">{{ trans('adminlte_lang::message.accounts') }}</a>
                    </li>
                    <li  class="@if ($page == 'partner') active @endif">
                        <a href="{{ url('/partner')}}">{{ trans('adminlte_lang::message.partners') }}</a>
                    </li>
                    <li  class="@if ($page == 'item') active @endif">
                        <a href="{{ url('/item')}}">{{ trans('adminlte_lang::message.costs') }}</a>
                    </li>
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.services') }}</a></li>--}}
                    @if ($crmuser->hasAccessTo('wage_schemes', 'view', null))
                        <li  class="@if ($page == 'wage_scheme') active @endif">
                            <a href="{{ url('/wage_scheme')}}">{{ trans('adminlte_lang::message.schemes') }}</a>
                        </li>
                    @endif
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.wage') }}</a></li>--}}
                    <li  class="@if ($page == 'payment') active @endif">
                        <a href="{{ url('/payment')}}">{{ trans('adminlte_lang::message.payments') }}</a>
                    </li>
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.documents') }}</a></li>--}}
                    {{--<li class="treeview"><a href="#">{{ trans('adminlte_lang::message.reports') }}<i class="fa fa-angle-left pull-right"></i></a>--}}
                        {{--<ul class="treeview-menu">--}}
                            {{--<li><a href="/stub">{{ trans('adminlte_lang::message.finance_report') }}</a></li>--}}
                            {{--<li><a href="/stub">{{ trans('adminlte_lang::message.pl_report') }}</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.settings') }}</a></li>--}}
                </ul>
            </li>
            @endif

            <li class="treeview @if(in_array($page, array('storage','product','productCategories','card','unit','storagetransaction','storagebalance','salesanalysis'))) activated @endif">
                <a href="#"><i class='fa fa-archive'></i> <span>{{ trans('adminlte_lang::message.stock') }}</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li  class="@if ($page == 'storage') active @endif">
                        <a href="{{ url('/storage')}}">{{ trans('adminlte_lang::message.storages') }}</a>
                    </li>
                    <li  class="@if ($page == 'product') active @endif">
                        <a href="{{ url('/product')}}">{{ trans('adminlte_lang::message.products') }}</a>
                    </li>
                    <li  class="@if ($page == 'productCategories') active @endif">
                        <a href="{{ url('/productCategories')}}">{{ trans('adminlte_lang::message.product_categories') }}</a>
                    </li>
                    <li  class="@if ($page == 'card') active @endif">
                        <a href="{{ url('/card')}}">{{ trans('adminlte_lang::message.routings') }}</a>
                    </li>
                    <li  class="@if ($page == 'unit') active @endif">
                        <a href="{{ url('/unit')}}">{{ trans('adminlte_lang::message.units') }}</a>
                    </li>
                    <li  class="@if ($page == 'storagetransaction') active @endif">
                        <a href="{{ url('/storagetransaction')}}">{{ trans('adminlte_lang::message.operations') }}</a>
                    </li>
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.inventory') }}</a></li>--}}
                    <li class="treeview @if(in_array($page, array('storagebalance','salesanalysis'))) active @endif">
                        <a href="#">{{ trans('adminlte_lang::message.reports') }}<i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li  class="@if ($page == 'storagebalance') active @endif">
                                <a href="{{ url('/storagebalance') }}">{{ trans('adminlte_lang::message.stock_balance') }}</a>
                            </li>
                            <li  class="@if ($page == 'salesanalysis') active @endif">
                                <a href="{{ url('/salesanalysis') }}">{{ trans('adminlte_lang::message.sales_analysis') }}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            {{--<li class="treeview">--}}
                {{--<a href="#"><i class='fa fa-calendar-check-o'></i> <span>{{ trans('adminlte_lang::message.registration') }}</span><i class="fa fa-angle-left pull-right"></i></a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.site') }}</a></li>--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.mobiles') }}</a></li>--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.socials') }}</a></li>--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.records') }}</a></li>--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.settings') }}</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            <li class="treeview @if(in_array($page, array('organization','serviceCategories','services','resource','employee','position','users','branches'))) activated @endif">
                <a href="#"><i class='fa fa-cogs'></i> <span>{{ trans('adminlte_lang::message.settings') }}</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li  class="@if ($page == 'organization') active @endif">
                        <a href="{{ url('/organization/edit')}}">{{ trans('adminlte_lang::message.basic_settings') }}</a>
                    </li>
                    <li  class="@if ($page == 'organization') active @endif">
                        <a href="{{ url('/organization/info/edit')}}">{{ trans('adminlte_lang::message.information') }}</a>
                    </li>
                    <li  class="@if ($page == 'serviceCategories') active @endif">
                        <a href="{{ url('/serviceCategories')}}">{{ trans('adminlte_lang::message.service_categories') }}</a>
                    </li>
                    <li  class="@if ($page == 'services') active @endif">
                        <a href="{{ url('/services')}}">{{ trans('adminlte_lang::message.services') }}</a>
                    </li>
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.schedule') }}</a></li>--}}
                    <li  class="@if ($page == 'resource') active @endif">
                        <a href="{{ url('/resource')}}">{{ trans('adminlte_lang::message.resources') }}</a>
                    </li>
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.linking') }}</a></li>--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.patterns') }}</a></li>--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.networks') }}</a></li>--}}
                    <li  class="@if ($page == 'employee') active @endif">
                        <a href="{{ url('/employee')}}">{{ trans('adminlte_lang::message.employees') }}</a>
                    </li>
                    <li  class="@if ($page == 'position') active @endif">
                        <a href="{{ url('/position')}}">{{ trans('adminlte_lang::message.positions') }}</a>
                    </li>
                    <li  class="@if ($page == 'users') active @endif">
                        <a href="{{ url('/users')}}">{{ trans('adminlte_lang::message.users') }}</a>
                    </li>
                    <li  class="@if ($page == 'branches') active @endif">
                        <a href="{{ url('/branches')}}">{{ trans('adminlte_lang::message.branches') }}</a>
                    </li>
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.notifications') }}</a></li>--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.actions') }}</a></li>--}}
                    {{--<li><a href="/stub">{{ trans('adminlte_lang::message.appointment_cats') }}</a></li>--}}
                </ul>
            </li>
            {{--<li><a href="/stub"><i class='fa fa-credit-card'></i> <span>{{ trans('adminlte_lang::message.balance') }}</span></a></li>--}}
            {{--<li><a href="/stub"><i class='fa fa-book'></i> <span>{{ trans('adminlte_lang::message.backoffice') }}</span></a></li>--}}
            <li class="@if ($page == 'user') active @endif"><a href="/user/cabinet"><i class='fa fa-user'></i> <span>{{ trans('adminlte_lang::message.profile') }}</span></a></li>
            {{--<li><a href="/stub"><i class='fa fa-question'></i> <span>{{ trans('adminlte_lang::message.support') }}</span></a></li>--}}
            <li><a href="/logout"><i class='fa fa-sign-out'></i> <span>{{ trans('adminlte_lang::message.exit') }}</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>