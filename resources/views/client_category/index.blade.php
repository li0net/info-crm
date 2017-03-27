@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.client_category:list_page_header')
@endsection

@section('main-content')
<section class="content-header">
    <h1>@lang('main.client_category:list_page_header')</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li><a href="{{ url('/clients') }}">{{ trans('adminlte_lang::message.client_list') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.loyality') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        <div class="col-md-12 text-right m-b">
            <a href="{{$newCCUrl}}" class="btn btn-primary">@lang('main.client_category:create_new_btn_label')</a>
        </div>
        <div class="col-sm-12">
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="client_categories_grid" class="table table-hover table-condensed"></table>
            <!-- <div id="client_categories_grid_pager"></div> -->
        </div>
    </div>
</div>
@endsection
