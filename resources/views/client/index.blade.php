@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.client:list_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">

        <div class="col-md-12">
            <div class="row">
                <h3>@lang('main.client:list_header')</h3>
            </div>
        </div>


        <div class="col-md-8" style="min-height:600px">
            <div class="ibox-title">
                <h5>@lang('main.client:list_header')</h5>
            </div>

            <div class="panel panel-default">
                <!-- <div class="panel-heading">lang('main.service:list_page_header')</div> -->
                <div style="margin-left:20px">

                    <table id="clients_grid"></table>
                    <div id="clients_grid_pager"></div>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="ibox-title">
                <h5>@lang('main.client:list_actions')</h5>
            </div>
            <div class="panel panel-default">
                <p>Actions here</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="ibox-title">
                <h5>@lang('main.client:list_filters')</h5>
            </div>
            <div class="panel panel-default">
                <p>Filters here</p>
            </div>
        </div>


    </div>

@endsection
