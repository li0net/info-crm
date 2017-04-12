@extends('adminlte::layouts.errors')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.servererror') }}
@endsection

@section('main-content')

<div class="error-page">
    <h2 class="headline text-red">500</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-red"></i> Oops! {{ trans('adminlte_lang::message.somethingwrong') }}</h3>
        <p>
            {{ trans('adminlte_lang::message.wewillwork') }}
        </p>
        <br>
        <a class="btn btn-danger" href='{{ url('/home') }}'>{{ trans('adminlte_lang::message.returndashboard') }}</a>
    </div>
</div><!-- /.error-page -->
@endsection