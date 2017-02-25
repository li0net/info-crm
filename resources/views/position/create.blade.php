@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.position_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h4>{{ trans('adminlte_lang::message.position_create_new') }}</h4>	
			<hr>	
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<div class="well">
				{{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
				{!! Form::open(['route' => 'position.store']) !!}
					<div class="form-group">
						{{ Form::label('title', trans('adminlte_lang::message.position_name')) }}
						{{ Form::text('title', null, ['class' => 'form-control', 
													  'required' => '', 
													  'maxlength' => '70',
													  'placeholder' => trans('adminlte_lang::message.specialization_example')]) }}
					</div>

					<div class="form-group">
						{{ Form::label('description', trans('adminlte_lang::message.description')) }}
						{{ Form::textarea('description', null, ['class' => 'form-control',
																'placeholder' => trans('adminlte_lang::message.service_example')]) }}
					</div>

					{{	Form::submit(trans('adminlte_lang::message.position_create_new'), ['class' => 'btn btn-success btn-block']) }}
				{!! Form::close() !!}	
			</div>
		</div>
	</div>

@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}