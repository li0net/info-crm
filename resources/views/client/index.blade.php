@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.client:list_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
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
            <div class="col-md-10">
                    <h3>@lang('main.client:list_header')</h3>
            </div>
            <div class="col-md-2">
                <p class="text-right"><a href="{{$newClientUrl}}" class="btn btn-default">@lang('main.client:create_new_btn_label')</a></p>
            </div>
        </div>


        <div class="col-md-8" style="min-height:600px">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">lang('main.service:list_page_header')</div> -->
                <div style="margin-left:20px">
                    <div class="input-group" style="margin-top:20px; margin-bottom:20px; margin-right:20px;">
                        <input class="form-control" id="client_main_search_field" type="text" placeholder="@lang('main.client:search_field_placeholder')">
                        <div class="input-group-btn">
                            <button id="client_main_search_btn" type="button" class="btn btn-primary">@lang('main.client:search_button_label')</button>
                        </div>
                    </div>

                    <table id="clients_grid"></table>
                    <div id="clients_grid_pager"></div>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="ibox-title">
                <h5>@lang('main.client:list_actions')</h5>
            </div>

            <div class="row">
                <p>SMS</p>
            </div>
            <div class="panel panel-default">
                <div class="row">
                    <a id="a_send_sms_to_selected" href="#" class="disabled" onclick="alert('Not implemented yet');">
                        <i class="fa fa-paper-plane"></i>
                        @lang('main.client:list_send_sms_to_selected')
                    </a>
                </div>
                <div class="row">
                    <a id="a_send_sms_to_all_found" href="#" onclick="alert('Not implemented yet');">
                        <i class="fa fa-paper-plane"></i>
                        @lang('main.client:list_send_sms_to_all_found')
                    </a>
                </div>
            </div>

            <div class="row">
                <p>@lang('main.client:list_actions')</p>
            </div>
            <div class="panel panel-default">
                <div class="row">
                    <a id="a_clients_delete_selected" class="disabled" href="#">
                        <i class="fa fa-trash-o"></i>
                        @lang('main.client:list_delete_selected')
                    </a>
                </div>
                <div class="row">
                    <a id="a_clients_delete_all_found" href="#">
                        <i class="fa fa-trash-o"></i>
                        @lang('main.client:list_delete_all_found')
                    </a>
                </div>
                <div class="row">
                    <a id="a_clients_add_selected_to_category" class="disabled" href="#" onclick="alert('Not implemented yet');">
                        <i class="fa fa-users"></i>
                        @lang('main.client:list_add_selected_to_category')
                    </a>
                </div>
                <div class="row">
                    <a id="a_clients_add_all_found_to_category" href="#" onclick="alert('Not implemented yet');">
                        <i class="fa fa-users"></i>
                        @lang('main.client:list_add_all_found_to_category')
                    </a>
                </div>
            </div>

            <div class="row">
                <p>Excel</p>
            </div>
            <div class="panel panel-default">
                <div class="row">
                    <a id="a_export_filtered_clients_to_excel" href="#">
                        <i class="fa fa-file-excel-o"></i>
                        @lang('main.client:list_export_filtered_to_excel')
                    </a>
                </div>
                <div class="row">
                    <a id="a_export_all_clients_to_excel" href="#">
                        <i class="fa fa-file-excel-o"></i>
                        @lang('main.client:list_export_all_to_excel')
                    </a>
                </div>
            </div>

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


    </div>

@endsection
