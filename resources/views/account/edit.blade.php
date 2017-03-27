@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.account_information') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.account_information') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li><a href="/account">{{ trans('adminlte_lang::message.accounts') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.account_information') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
        {!! Form::model($account, ['route' => ['account.update', $account->account_id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
        <div class="col-sm-12">
            <div class="form-group">
                {{ Form::label('title', trans('adminlte_lang::message.account_name'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '70']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('type', trans('adminlte_lang::message.account_type'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::select('type', ['cash' => trans('adminlte_lang::message.cash'), 'noncache' => trans('adminlte_lang::message.non-cash')], 'cash', ['class' => 'js-select-basic-single', 'required' => '']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('balance', trans('adminlte_lang::message.account_initial_balance'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::text('balance', null, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('comment', trans('adminlte_lang::message.description'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::textarea('comment', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="m-t text-right">
                {{ Form::submit(trans('adminlte_lang::message.save'), ['class'=>'btn btn-primary pull-right']) }}
                {!! Html::linkRoute('account.show', trans('adminlte_lang::message.cancel'), [$account->account_id], ['class'=>'btn btn-info pull-right m-r']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>


@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}