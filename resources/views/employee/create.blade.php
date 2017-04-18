@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
    <section class="content-header">
        <h1>{{ trans('adminlte_lang::message.employee_create_new') }}</h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
            <li><a href="{{ url('/employee') }}">{{ trans('adminlte_lang::message.employees') }}</a></li>
            <li class="active">{{ trans('adminlte_lang::message.employee_create_new') }}</li>
        </ol>
    </section>
    <div class="container">

        @include('partials.alerts')

        <div class="row">
            <div class="col-sm-12">
                {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
                {!! Form::open(['route' => ['employee.store'], 'method' => 'PUT', 'files' => 'true', 'class'=>'form-horizontal']) !!}
                    <div class="col-sm-8">
                        <div class="form-group">
                            {{ Form::label('name', trans('adminlte_lang::message.employee_name'), ['class' => 'col-sm-4 control-label text-right']) }}
                            <div class="col-sm-8">
                                {{ Form::text('name', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '70', 'placeholder' => trans('adminlte_lang::message.employee_name')]) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('email', trans('adminlte_lang::message.employee_email'), ['class' => 'col-sm-4 control-label text-right']) }}
                            <div class="col-sm-8">
                                {{ Form::text('email', null, ['class' => 'form-control', 'email' => '', 'placeholder' => trans('adminlte_lang::message.example').'info@mail.com']) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ 	Form::label('phone', trans('adminlte_lang::message.employee_phone'), ['class' => 'col-sm-4 control-label text-right']) }}
                            <div class="col-sm-8">
                                {{ 	Form::text('phone', null, ['class' => 'form-control', 'required' => '', 'placeholder' => trans('adminlte_lang::message.phone_format')]) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ 	Form::label('position_id', trans('adminlte_lang::message.employee_position'), ['class' => 'col-sm-4 control-label text-right']) }}
                            <div class="col-sm-8">
                                {{	Form::select('position_id', $items, 1, ['class' => 'js-select-basic-single', 'required' => '', 'placeholder'=>trans('adminlte_lang::message.employee_position')]) }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 text-center">
                        <label class="ctrl-label">{{ trans('adminlte_lang::message.photo') }}</label>
                        <div class="logo-block">
                            <div v-if="!image">
                                <img src="/images/no-master.png" alt="">
                            </div>
                            <div v-else>
                                <img :src="image" />
                            </div>
                        </div>
                        <span class="btn btn-info btn-file">
                            {{ trans('adminlte_lang::message.load_photo') }}<input type="file" name="avatar" @change="onFileChange">
                        </span>
                    </div>
                    <hr>
                    <div class="col-sm-12 text-right">
                        {{	Form::submit(trans('adminlte_lang::message.save'), ['class' => 'btn btn-primary']) }}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}