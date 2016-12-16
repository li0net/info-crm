@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.service:list_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('main.service:list_page_header')</div>

                    <div class="panel-body">

                        <div>
                            <table id="services_grid"></table>
                            <div id="services_grid_pager"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
