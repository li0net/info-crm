@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.partner_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.partner_create_new') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li><a href="{{ url('/partner')}}">{{ trans('adminlte_lang::message.partners') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.partner_create_new') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        <div class="col-sm-12">
            {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
            {!! Form::open(['route' => 'partner.store', 'class'=>'form-horizontal']) !!}
            <div class="form-group">
                {{ Form::label('title', trans('adminlte_lang::message.partner_name'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('type', trans('adminlte_lang::message.partner_type'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::select('type', ['company' => trans('adminlte_lang::message.company'),
                    'person' => trans('adminlte_lang::message.person'),
                    'selfemployed' => trans('adminlte_lang::message.self_employed')], 'company', ['class' => 'js-select-basic-single', 'required' => '']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('inn', trans('adminlte_lang::message.INN'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::text('inn', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '15']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('kpp', trans('adminlte_lang::message.KPP'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::text('kpp', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '10']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('contacts', trans('adminlte_lang::message.partner_contacts'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::text('contacts', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('phone', trans('adminlte_lang::message.phone'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::text('phone', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '25']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('email', trans('adminlte_lang::message.email'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::email('email', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '70']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('address', trans('adminlte_lang::message.address'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::text('address', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '210']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="text-right m-t">
                {{	Form::submit(trans('adminlte_lang::message.partner_create_new'), ['class' => 'btn btn-primary']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}