@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.resource_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h4>{{ trans('adminlte_lang::message.new_resource') }}</h4>	
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
		</div>
	</div>
		{{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
		{!! Form::open(['route' => 'resource.store']) !!}
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="well">
						<div class="form-group">
							{{ Form::label('name', trans('adminlte_lang::message.resource_name')) }}
							{{ Form::text('name', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
						</div>

						<div class="form-group">
							{{ Form::label('description', trans('adminlte_lang::message.description')) }}
							{{ Form::textarea('description', null, ['class' => 'form-control']) }}
						</div>
					
						<hr>

						<div class="row">
							<div class="col-sm-6 col-sm-offset-3">
								{{	Form::submit(trans('adminlte_lang::message.resource_create_new'), ['class' => 'btn btn-success btn-block']) }}
							</div>
						</div>
					</div>
				</div>
			</div>
		{!! Form::close() !!}	
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}