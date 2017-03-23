@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.item_information') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.item_information') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li><a href="{{ url('/item')}}">{{ trans('adminlte_lang::message.costs') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.item_information') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
        {!! Form::open(['route' => 'item.store', 'class' => 'form-horizontal']) !!}
        
        <div class="form-group">
            {{ Form::label('title', trans('adminlte_lang::message.item_name'), ['class' => 'col-sm-4 control-label text-right']) }}
            <div class="col-sm-8">
                {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'col-sm-4 control-label text-right']) }}
            <div class="col-sm-8">
                {{ Form::textarea('description', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('type', trans('adminlte_lang::message.item_type'), ['class' => 'col-sm-4 control-label text-right']) }}
            <div class="col-sm-8">
                {{ Form::select('type', [1 => trans('adminlte_lang::message.income'),
                2 => trans('adminlte_lang::message.expenses_on_cost'),
                3 => trans('adminlte_lang::message.commercial_exps'),
                4 => trans('adminlte_lang::message.staff_exps'),
                5 => trans('adminlte_lang::message.admin_exps'),
                6 => trans('adminlte_lang::message.taxes'),
                7 => trans('adminlte_lang::message.other_exps')], 'income', ['class' => 'js-select-basic-single', 'required' => '']) }}
            </div>
        </div>
        <div class="m-t text-right">
            {{ Form::submit(trans('adminlte_lang::message.item_create_new'), ['class' => 'btn btn-primary']) }}
        </div>
        {{-- {{	Form::submit(trans('adminlte_lang::message.item_create_new'), ['class' => 'btn btn-success text-center', 'style' => 'margin-top:20px;']) }} --}}
        {!! Form::close() !!}
    </div>
</div>

@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}