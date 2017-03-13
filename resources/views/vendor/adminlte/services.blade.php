@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.service:list_page_header')
@endsection


@section('main-content')
    <section class="content-header">
        <h1>@lang('main.service:list_page_header')</h1>
        <!--<ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Advanced Elements</li>
        </ol>-->
    </section>
    <div class="row">
        @if ($user->hasAccessTo('service', 'edit', 0) >= 1)
            <div class="col-md-12 text-right">
                <a href="{{$newServiceUrl}}" class="btn btn-primary">@lang('main.service:create_new_btn_label')</a>
            </div>
        @endif
        <div class="col-md-12 m-t">
            <table id="services_grid"></table>
            <div id="services_grid_pager"></div>
        </div>
    </div>
    <script type="text/javascript">
        @if ($crmuser->hasAccessTo('service', 'edit', 0) >= 1)
            window.Settings = {permissions_service_edit: 1};
        @else
            window.Settings = {permissions_service_edit: 0};
        @endif

        @if ($crmuser->hasAccessTo('service', 'delete', 0) >= 1)
            window.Settings.permissions_service_delete = 1;
        @else
            window.Settings.permissions_service_delete = 0;
        @endif
    </script>
@endsection
