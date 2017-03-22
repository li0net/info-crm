@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.storage_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.new_storage') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li ><a href="{{ url('/storage')}}">{{ trans('adminlte_lang::message.storages') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.new_storage') }}</li>
    </ol>
</section>
<div class="container">
    <div class="row">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <div class="row">
        {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
        {!! Form::open(['route' => 'storage.store', "class"=>'form-horizontal']) !!}
            <div class="form-group">
                {{ Form::label('title', trans('adminlte_lang::message.storage_title'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('type', trans('adminlte_lang::message.storage_type'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    <label style="width: 100%">
                        {{ Form::radio('type', 1, true, ['style' => 'margin-right: 10px']) }}
                        {{ trans('adminlte_lang::message.writeoff_supplies') }}
                    </label>
                    <label>
                        {{ Form::radio('type', 2, false, ['style' => 'margin-right: 10px']) }}
                        {{ trans('adminlte_lang::message.sale_goods') }}
                    </label>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'col-sm-3 control-label text-right']) }}
                <div class="col-sm-9">
                    {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                </div>
            </div>

            <div class="m-t text-right">
                {{	Form::submit(trans('adminlte_lang::message.storage_create_new'), ['class' => 'btn btn-primary']) }}
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}