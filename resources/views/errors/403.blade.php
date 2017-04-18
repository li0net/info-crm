@extends('adminlte::layouts.errors')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.pagenotfound') }}
@endsection

@section('main-content')
    <div class="error-page">
        <h2 class="headline text-yellow">  403</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> {{ trans('adminlte_lang::message.permission_denied') }}</h3>
            <p>
                {{ trans('adminlte_lang::message.permission_denied_explanation') }}
            </p>
            <br>
            <a class="btn btn-info" href="javascript:window.history.back();">{{ trans('adminlte_lang::message.permission_denied_goback') }}</a>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->
@endsection