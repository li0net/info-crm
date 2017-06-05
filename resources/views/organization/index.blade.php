@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.branch:list_page_header')
@endsection

@section('main-content')
    <section class="content-header">
        <h1>@lang('main.branch:list_header')</h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
            <li class="active">{{ trans('adminlte_lang::message.branch_list') }}</li>
        </ol>
    </section>
    <div class="container-fluid">

        @include('partials.alerts')

        <div class="row">
            <div class="col-md-12 text-right m-b">
                <a href="{{$newBranchUrl}}" class="btn btn-primary">@lang('main.branch:create_new_btn_label')</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 clients-grid-block">
                <table id="branches_grid" class="table table-hover table-condensed"></table>
                <div id="branches_grid_pager"></div>
            </div>

        </div>
    </div>
@endsection
@section('page-specific-scripts')
    <script>
        $(document).ready(function(e){
            return false;
        });
    </script>
@endsection

