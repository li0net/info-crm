@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.user:list_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('main.user:list_page_header')</div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div style="margin-left:20px">

                            <table id="users_grid"></table>
                            <div id="users_grid_pager"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
