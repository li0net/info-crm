@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.resource_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.new_resource') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
        <li><a href="{{ url('/resource')}}">{{ trans('adminlte_lang::message.resources') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.new_resource') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
        {!! Form::open(['route' => 'resource.store']) !!}
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('name', trans('adminlte_lang::message.resource_name'),
                    ['class'=> "col-sm-4 control-label text-right"]) }}
                <div class="col-sm-8">
                    {{ Form::text('name', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('description', trans('adminlte_lang::message.description'),
                    ['class'=> "col-sm-4 control-label text-right"]) }}
                <div class="col-sm-8">
                    {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('amount', trans('adminlte_lang::message.resource_amount'),
                    ['class'=> "col-sm-4 control-label text-right"]) }}
                <div class="col-sm-8">
                    {{ Form::text('amount', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
            </div>
            <div class="text-right col-sm-12">
                {{	Form::submit(trans('adminlte_lang::message.resource_create_new'), ['class' => 'btn btn-primary m-t']) }}
            </div>
        </div>
    {!! Form::close() !!}
    </div>
</div>
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}