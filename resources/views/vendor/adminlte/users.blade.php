@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.user:list_page_header')
@endsection


@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.users') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.users') }}</li>
    </ol>
</section>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 text-right">
            <a href="{{$newUserUrl}}" class="btn btn-primary">@lang('main.user:create_new_btn_label')</a>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="users_grid"></table>
            <div id="users_grid_pager"></div>
        </div>
    </div>
</div>
@endsection
