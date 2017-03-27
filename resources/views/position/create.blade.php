@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.position_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.position_create_new') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
        <li><a href="{{ url('/position')}}">{{ trans('adminlte_lang::message.positions') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.position_create_new') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-12">
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
        <div class="col-sm-12">
            {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
            {!! Form::open(['route' => 'position.store', 'class' => 'form-horizontal']) !!}
            <div class="form-group">
                {{ Form::label('title', trans('adminlte_lang::message.position_name'),['class'=> "col-sm-4 control-label text-right"]) }}
                <div class="col-sm-8">
                    {{ Form::text('title', null, ['class' => 'form-control',
                    'required' => '',
                    'maxlength' => '70',
                    'placeholder' => trans('adminlte_lang::message.specialization_example')]) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('description', trans('adminlte_lang::message.description'),['class'=> "col-sm-4 control-label text-right"]) }}
                <div class="col-sm-8">
                    {{ Form::textarea('description', null, ['class' => 'form-control',
                    'placeholder' => trans('adminlte_lang::message.service_example')]) }}
                </div>
            </div>
            <div class="text-right m-t">
                {{	Form::submit(trans('adminlte_lang::message.position_create_new'), ['class' => 'btn btn-primary']) }}
                {!! Form::close() !!}
            </div>
        </div>
	</div>
</div>
@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}