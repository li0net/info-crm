@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.service_category:list_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @lang('main.service_category:list_page_header')
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <p class="text-right"><a href="{{$newScUrl}}" class="btn btn-default">@lang('main.service_category:create_new_btn_label')</a></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div style="margin-left:20px">
                            <table id="service_categories_grid"></table>
                            <div id="service_categories_grid_pager"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
