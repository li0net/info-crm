@extends('adminlte::layouts.errors')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.pagenotfound') }}
@endsection

@section('main-content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! {{ trans('adminlte_lang::message.pagenotfound') }}.</h3>
            <p>
                {{ trans('adminlte_lang::message.notfindpage') }}
            </p>
            <br>
            <a class="btn btn-info" href='{{ url('/home') }}'>{{ trans('adminlte_lang::message.returndashboard') }}</a>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->
@endsection