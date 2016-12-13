@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('main.service_categories')['list_page_header'] }}
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Home</div>

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
