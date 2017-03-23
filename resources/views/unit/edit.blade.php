@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.information_about_unit') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.information_about_unit') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li><a href="{{ url('/unit')}}">{{ trans('adminlte_lang::message.units') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.information_about_unit') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-12">
            {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
            {!! Form::model($unit, ['route' => ['unit.update', $unit->unit_id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
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
            <div class="m-t pull-right">
                {!! Html::linkRoute('unit.show', trans('adminlte_lang::message.cancel'), [$unit->unit_id], ['class'=>'btn btn-danger m-r']) !!}
                {{ Form::submit(trans('adminlte_lang::message.save'), ['class'=>'btn btn-primary']) }}
            </div>
            {!! Form::close() !!}
        </div>
	</div>
</div>
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}