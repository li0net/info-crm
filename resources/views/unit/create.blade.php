@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.unit_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.unit_create_new') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li><a href="{{ url('/unit')}}">{{ trans('adminlte_lang::message.units') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.unit_create_new') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        <div class="col-sm-12">
            {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
            {!! Form::open(['route' => 'unit.store', 'class' => 'form-horizontal']) !!}
            <div class="form-group">
                {{ Form::label('title', trans('adminlte_lang::message.unit_title'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('short_title', trans('adminlte_lang::message.unit_short_title'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::text('short_title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="m-t text-right">
                {{	Form::submit(trans('adminlte_lang::message.unit_create_new'), ['class' => 'btn btn-primary']) }}
            </div>
            {!! Form::close() !!}
        </div>
	</div>
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}