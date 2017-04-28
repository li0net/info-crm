@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.summary') }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-sm-12">
            <div class="jumbotron">
                <p class="lead">{{ trans('adminlte_lang::message.summary') }}</p>
                <hr>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="jumbotron">
                <h2>{{ trans('adminlte_lang::message.organization_id') }}</h2>
                <p class="lead">#&nbsp;{{ $organization_id }}</p>
                <hr>
            </div>
        </div>
    </div>
@endsection