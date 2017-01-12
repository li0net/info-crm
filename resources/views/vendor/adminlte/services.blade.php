@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.service:list_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('main.service:list_page_header')</div>
                </div>
            </div>

            @if ($user->hasAccessTo('service', 'edit', 0) >= 1)
            <div class="col-md-2">
                <p class="text-right"><a href="{{$newServiceUrl}}" class="btn btn-default">@lang('main.service:create_new_btn_label')</a></p>
            </div>
            @endif
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div style="margin-left:20px">

                            <table id="services_grid"></table>
                            <div id="services_grid_pager"></div>
                        </div>

                    </div>
                </div>
            </div>
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
