@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.service_category:list_page_header')
@endsection

@section('main-content')
<section class="content-header">
    <h1> @lang('main.service_category:list_page_header')</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
        <li class="active"> @lang('main.service_category:list_page_header')</li>
    </ol>
</section>
<div class="container-fluid">
    <div class="row">
        @if ($user->hasAccessTo('service', 'edit', 0) >= 1)
            <div class="col-md-12 text-right">
                <p class="text-right"><a href="{{$newScUrl}}" class="btn btn-primary">@lang('main.service_category:create_new_btn_label')</a></p>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            <table id="service_categories_grid"></table>
            <div id="service_categories_grid_pager"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    @if ($crmuser->hasAccessTo('service', 'edit', 0) >= 1)
        window.Settings = {permissions_service_edit: 1};
    @else
        window.Settings = {permissions_service_edit: 0};
    @endif

    @if ($crmuser->hasAccessTo('service', 'delete', 0) >= 1)
        window.Settings.permissions_service_delete = 1;
    @else
        window.Settings.permissions_service_delete = 0;
    @endif
</script>
@endsection
