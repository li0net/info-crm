@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.account_create_new') }}</h1>
    <!--<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Advanced Elements</li>
    </ol>-->
</section>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
    {!! Form::open(['route' => 'account.store', 'class'=>'form-horizontal']) !!}
    <div class="text-right col-sm-12">
        <div class="form-group">
            {{ Form::label('title', trans('adminlte_lang::message.account_create_new'), ['class' => 'col-sm-3 control-label text-right']) }}
            <div class="col-sm-9">
                {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '70']) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('balance', trans('adminlte_lang::message.account_initial_balance'), ['class' => 'col-sm-3 control-label text-right']) }}
            <div class="col-sm-9">
                {{ Form::text('balance', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('type', trans('adminlte_lang::message.account_type'), ['class' => 'col-sm-3 control-label text-right']) }}
            <div class="col-sm-9">
                {{ Form::select('type', ['cash' => trans('adminlte_lang::message.cash'), 'noncache' => trans('adminlte_lang::message.non-cash')], 'cash', ['class' => 'selectpicker', 'required' => '']) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('comment', trans('adminlte_lang::message.description'), ['class' => 'col-sm-3 control-label text-right']) }}
            <div class="col-sm-9">
                {{ Form::textarea('comment', null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>


    <div class="text-right col-sm-12 m-t">
        {{	Form::submit(trans('adminlte_lang::message.account_create_new'), ['class' => 'btn btn-primary']) }}
    </div>
    {!! Form::close() !!}

@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}