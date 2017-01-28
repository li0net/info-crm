@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.client_category:list_page_header')
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @lang('main.client_category:list_page_header')
                    </div>
                </div>
            </div>


            <div class="col-md-2">
                <p class="text-right"><a href="{{$newCCUrl}}" class="btn btn-default">@lang('main.client_category:create_new_btn_label')</a></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div style="margin-left:20px">
                            <table id="client_categories_grid"></table>
                            <!-- <div id="client_categories_grid_pager"></div> -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
