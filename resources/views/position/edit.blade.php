@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $position->title }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.position') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
        <li><a href="{{ url('/position')}}">{{ trans('adminlte_lang::message.positions') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.position') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

	<div class="row">
		{!! Form::model($position, ['route' => ['position.update', $position->position_id],
                                    "method" => 'PUT', "class" => 'form-horizontal']) !!}
            <div class="form-group">
                {{ Form::label('title', trans('adminlte_lang::message.position_name'),["class"=>"col-sm-3 control-label text-right"]) }}
                <div class="col-sm-9">
                    {{ Form::text(
                        'title', null, ['class' => 'text-left form-control',
                        'placeholder' => trans('adminlte_lang::message.specialization_example')]
                    ) }}
                </div>

            </div>
            <div class="form-group">
                {{ Form::label('title', trans('adminlte_lang::message.description'),["class"=>"col-sm-3 control-label text-right"]) }}
                <div class="col-sm-9">
                    {{ Form::textarea(
                        'description', null, ['class' => 'text-left form-control',
                        'placeholder' => trans('adminlte_lang::message.service_example')]
                    ) }}
                </div>
            </div>
            <div class="m-t text-right">
                {{ Form::submit(trans('adminlte_lang::message.save'), ['class'=>'btn btn-primary pull-right']) }}
                {!! Html::linkRoute('position.show', trans('adminlte_lang::message.cancel'),
                        [$position->position_id], ['class'=>'btn btn-info m-r pull-right']) !!}
            </div>
		{!! Form::close() !!}
	</div>
</div>
@endsection