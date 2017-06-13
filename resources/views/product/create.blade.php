@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.product_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.product_create_new') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li><a href="{{ url('/product')}}">{{ trans('adminlte_lang::message.products') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.product_create_new') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
        {!! Form::open(['route' => 'product.store', 'class' => 'form-horizontal']) !!}
        <div class="row">
            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('title', trans('adminlte_lang::message.product_title'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-8">
                    {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
                <label class="col-sm-1 text-left">
                    <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                </label>
            </div>

            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('article', trans('adminlte_lang::message.article'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-8">
                    {{ Form::text('article', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
                <label class="col-sm-1 text-left">
                </label>
            </div>

            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('barcode', trans('adminlte_lang::message.bar_code'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-8">
                    {{ Form::text('barcode', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
                <label class="col-sm-1 text-left">
                </label>
            </div>

            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('category_id', trans('adminlte_lang::message.category'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-8">
                    {{ Form::select('category_id', $categories, null, ['class' => ' js-select-basic-single']) }}
                </div>
                <label class="col-sm-1 text-left">
                </label>
            </div>

            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('storage_id', trans('adminlte_lang::message.storage'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-8">
                    {{ Form::select('storage_id', $storages, null, ['class' => ' js-select-basic-single', 'required' => '']) }}
                </div>
                <label class="col-sm-1 text-left">
                </label>
            </div>

            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('price', trans('adminlte_lang::message.sell_price'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-8">
                    {{ Form::text('price', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
                <label class="col-sm-1 text-left">
                </label>
            </div>

            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('', trans('adminlte_lang::message.unit'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-3">
                    <p>{{ trans('adminlte_lang::message.for_sale') }}</p>
                    {{ Form::select('unit_for_sale', [
                        'pcs' => trans('adminlte_lang::message.pieces'),
                        'ml' => trans('adminlte_lang::message.milliliters')
                    ],
                    'pcs',
                    ['class' => ' js-select-basic-single', 'required' => '', 'maxlength' => '110']) }}
                </div>
                <div class="col-sm-2">
                    <p>{{ trans('adminlte_lang::message.is_equal') }}</p>
                    <div class="input-group">
                        <span class="input-group-addon">=</span>
                        <input type="text" class="form-control" name="is_equal" value="2">
                    </div>
                </div>
                <div class="col-sm-3">
                    <p>{{ trans('adminlte_lang::message.for_disposal') }}</p>
                    {{ Form::select('unit_for_disposal', [
                        'pcs' => trans('adminlte_lang::message.pieces'),
                        'ml' => trans('adminlte_lang::message.milliliters')],
                    'pcs',
                    ['class' => ' js-select-basic-single', 'required' => '', 'maxlength' => '110']) }}
                </div>
                <label class="col-sm-1 text-left">
                </label>
            </div>

            <div class="form-group">
                {{ Form::label('critical_balance', trans('adminlte_lang::message.critical_balance'), ['class' => 'form-spacing-top col-sm-3 control-label']) }}
                <div class="col-sm-8">
                    <div class="input-group input-group-addon-right">
                        {{ Form::text('critical_balance', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                        <span class="input-group-addon">{{ trans('adminlte_lang::message.pcs') }}</span>
                    </div>
                </div>
                <label class="col-sm-1 text-left">
                </label>
            </div>

            <div class="form-group">
                {{ Form::label('critical_balance', trans('adminlte_lang::message.weights'), ['class' => 'form-spacing-top col-sm-3 control-label']) }}
                <div class="col-sm-3">
                    <p>{{ trans('adminlte_lang::message.net_weight') }}</p>
                    <div class="input-group input-group-addon-right">
                        {{ Form::text('net_weight', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                        <span class="input-group-addon">{{ trans('adminlte_lang::message.g') }}</span>
                    </div>
                </div>
                <div class="col-sm-2"></div>
                <div class="col-sm-3">
                    <p>{{ trans('adminlte_lang::message.gross_weight') }}</p>
                    <div class="input-group input-group-addon-right">
                        {{ Form::text('gross_weight', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                        <span class="input-group-addon">{{ trans('adminlte_lang::message.g') }}</span>
                    </div>
                </div>
                <label class="col-sm-1 text-left">
                </label>
            </div>

            <div class="form-group">
                {{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'form-spacing-top col-sm-3 control-label']) }}
                <div class="col-sm-8">
                    {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                </div>
                <label class="col-sm-1 text-left">
                </label>
            </div>
        </div>
        <div class="m-t text-right">
            {{ Form::submit(trans('adminlte_lang::message.product_create_new'), ['class' => 'btn btn-primary']) }}
        </div>

        {!! Form::close() !!}
	</div>
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}