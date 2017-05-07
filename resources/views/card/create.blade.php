@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.routine_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.routine_create_new') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li><a href="{{ url('/card')}}">{{ trans('adminlte_lang::message.routings') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.routine_create_new') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

	<div class="row">
        <div class="col-sm-12">
            {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
            {!! Form::open(['route' => 'card.store', 'class' => 'form-horizontal']) !!}
            {{ Form::hidden('storage_options', null, ['id' => 'storage_options']) }}
            <div class="form-group">
                <div class="col-sm-2 control-label">
                    {{ Form::label('title', trans('adminlte_lang::message.title'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-9">
                    {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
                <label class="col-sm-1 text-left">
                    <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                </label>
            </div>
            <div class="form-group">
                <div class="col-sm-11">
                    <div class="box box-details box-solid collapsed-box">
                        <div class="box-header with-border">
                            <h3>
                                <a href="#card-items" data-toggle="collapse" class="btn btn-link btn-xs" data-widget="collapse">
                                    <i class="fa fa-caret-down"></i>
                                    {{ trans('adminlte_lang::message.routine_structure') }}
                                </a>
                            </h3>
                            <div class="box-tools pull-right">
                                <span class="badge label-danger" v-model="detailed_products_count">@{{ card_items_count }}</span>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" >
                            <div id="card-items" class="form-group col-sm-12">
                                <div class="wrap-it">
                                    <div class="col-sm-5">{{ trans('adminlte_lang::message.stock') }}</div>
                                    <div class="col-sm-4">{{ trans('adminlte_lang::message.title') }}</div>
                                    <div class="col-sm-2">{{ trans('adminlte_lang::message.amount') }}</div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-12">
                                        <hr>
                                    </div>
                                </div>

                                <@include('card.templates')

                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <label class="col-sm-1 text-left">
                    <br>
                    <a class="fa fa-info-circle" id="products_unit" original-title="">&nbsp;</a>
                </label>
            </div>
            <div class="form-group">
                {{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'form-spacing-top col-sm-2 control-label']) }}
                <div class="col-sm-9">
                    {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                </div>
                <label class="col-sm-1 text-left">
                    <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                </label>
            </div>

            <div class="m-t text-right col-sm-11">
                {{	Form::submit(trans('adminlte_lang::message.routine_create_new'), ['class' => 'btn btn-primary']) }}
            </div>
            {!! Form::close() !!}
        </div>
	</div>

    <!--templates-->
    <div class="hidden templates">
        <div id="card-items-tpl">
            @include('card.templates')
        </div>
    </div>
    <!--templates-->
@endsection

@section('page-specific-scripts')
    @include('card.scripts')
@endsection