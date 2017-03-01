@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

@section('main-content')
	<div class="row">
        <div class="col-md-12">
            <div class="jumbotron">
              <h2>{{ trans('adminlte_lang::message.hello') }}</h2>
              <p class="lead">{{ trans('adminlte_lang::message.section_under_construction') }}</p>
              <hr>
            </div>
        </div>
    </div> <!-- end of header row -->
@endsection