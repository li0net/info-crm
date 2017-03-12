@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.client_category:list_page_header')
@endsection

@section('main-content')
    <section class="content-header">
        <h1>@lang('main.client_category:list_page_header')</h1>
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
            <a href="{{$newCCUrl}}" class="btn btn-primary">@lang('main.client_category:create_new_btn_label')</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="client_categories_grid" class="table table-hover table-condensed"></table>
            <!-- <div id="client_categories_grid_pager"></div> -->
        </div>
    </div>
@endsection
