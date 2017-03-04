@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $resource->name }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
			<div class="alert alert-success" role="alert">
				<strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
			</div>
		@endif
	</div>
{{-- 	<div class="row">
		<h4>{{ trans('adminlte_lang::message.information_about_resource') }}</h4>	
		<hr>
	</div> --}}	
		{{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
	<div class="row">
		{!! Form::model($resource, ['route' => ['resource.update', $resource->resource_id], 'method' => 'PUT']) !!}
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
						<div class="col-sm-8 col-sm-offset-2">
							<div class="row">
								<div class="col-sm-6">
									{!! Html::linkRoute('resource.show', trans('adminlte_lang::message.cancel'), [$resource->resource_id], 
																												 ['class'=>'btn btn-danger btn-block']) !!}
								</div>
								<div class="col-sm-6">
									{{ Form::submit(trans('adminlte_lang::message.save'), ['class'=>'btn btn-success btn-block']) }}
								</div>
							</div>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>	
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}