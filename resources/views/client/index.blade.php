@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.client:list_page_header')
@endsection

@section('main-content')
<section class="content-header">
    <h1>@lang('main.client:list_header')</h1>
    <!--<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Advanced Elements</li>
    </ol>-->
</section>

<div class="row">
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            <strong>@lang('main.general_success'):</strong> {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-error" role="alert">
            <strong>@lang('main.general_error'):</strong> {{ Session::get('error') }}
        </div>
    @endif
</div>
<div class="row">
    <div class="col-md-12 text-right m-b">
        <a href="{{$newClientUrl}}" class="btn btn-primary">@lang('main.client:create_new_btn_label')</a>
    </div>
</div>
<div class="row">
    <div class="col-md-8 clients-grid-block">
        <div class="input-group input-group-addon-right m-b">
            <input class="form-control" id="client_main_search_field" type="text" placeholder="@lang('main.client:search_field_placeholder')">
            <div class="input-group-btn">
                <button id="client_main_search_btn" type="button" class="btn btn-primary">@lang('main.client:search_button_label')</button>
            </div>
        </div>
        <table id="clients_grid" class="table table-hover table-condensed"></table>
        <div id="clients_grid_pager"></div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('main.client:list_actions')</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <h4>SMS</h4>
                <ul class="list-unstyled m-b">
                    <li>
                        <a id="a_send_sms_to_selected" href="#" class="disabled btn btn-link link-blue btn-xs" onclick="alert('Not implemented yet');">
                            <i class="fa fa-paper-plane"></i>
                            @lang('main.client:list_send_sms_to_selected')
                        </a>
                    </li>
                    <li>
                        <a id="a_send_sms_to_all_found" class='btn btn-link link-blue btn-xs' href="#" onclick="alert('Not implemented yet');">
                            <i class="fa fa-paper-plane"></i>
                            @lang('main.client:list_send_sms_to_all_found')
                        </a>
                    </li>
                </ul>

                <h4>@lang('main.client:list_actions')</h4>
                <ul class="list-unstyled m-b">
                    <li>
                        <a id="a_clients_delete_selected" class='btn btn-link link-blue btn-xs disabled' href="#">
                            <i class="fa fa-trash-o"></i>
                            @lang('main.client:list_delete_selected')
                        </a>
                    </li>
                    <li>
                        <a id="a_clients_delete_all_found" class='btn btn-link link-blue btn-xs' href="#">
                            <i class="fa fa-trash-o"></i>
                            @lang('main.client:list_delete_all_found')
                        </a>
                    </li>
                    <li>
                        <a id="a_clients_add_selected_to_category" class='btn btn-link link-blue btn-xs disabled' href="#" onclick="alert('Not implemented yet');">
                            <i class="fa fa-users"></i>
                            @lang('main.client:list_add_selected_to_category')
                        </a>
                    </li>
                    <li>
                        <a id="a_clients_add_all_found_to_category"class='btn btn-link link-blue btn-xs' href="#" onclick="alert('Not implemented yet');">
                            <i class="fa fa-users"></i>
                            @lang('main.client:list_add_all_found_to_category')
                        </a>
                    </li>

                </ul>

                @if ($crmuser->hasAccessTo('clients_export_xls', 'view', null))
                <h4>Excel</h4>
                <ul class="list-unstyled m-b">
                    <li>
                        <a id="a_export_filtered_clients_to_excel" class='btn btn-link link-blue btn-xs' href="#">
                            <i class="fa fa-file-excel-o"></i>
                            @lang('main.client:list_export_filtered_to_excel')
                        </a>
                    </li>
                    <li>
                        <a id="a_export_all_clients_to_excel" class='btn btn-link link-blue btn-xs' href="#">
                            <i class="fa fa-file-excel-o"></i>
                            @lang('main.client:list_export_all_to_excel')
                        </a>
                    </li>
                </ul>
                @endif

                <form method="POST" action="/clients/gridData" accept-charset="UTF-8" id="clientsGridExportForm">
                    {{csrf_field()}}
                    <input id="clientsGridName" name="name" type="hidden" value="clients_filtered">
                    <input id="clientsGridModel" name="model" type="hidden">
                    <input id="clientsGridSidx" name="sidx" type="hidden">
                    <input id="clientsGridSord" name="sord" type="hidden">
                    <input id="clientsGridExportFormat" name="exportFormat" type="hidden" value="xls">
                    <input id="clientsGridFilters" name="filters" type="hidden">

                    <input id="docGridPivotFlag" name="pivot" type="hidden" value="">
                    <input id="docGridRows" name="pivotRows" type="hidden">
                    <input name="fileProperties" type="hidden" value='[]'>
                    <input name="sheetProperties" type="hidden" value='[]'>
                    <input name="groupingView" type="hidden" value='[]'>
                    <input name="groupHeaders" type="hidden" value=''>
                </form>
            </div><!-- /.box-body -->
        </div>




    </div>
</div>

<!--
<div class="col-md-4">
    <div class="ibox-title">
        <h5>@//lang('main.client:list_filters')</h5>
    </div>
    <div class="panel panel-default">
        <p>Filters here</p>
    </div>
</div>
-->
@endsection
