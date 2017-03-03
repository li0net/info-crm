@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $resource->name }}
@endsection

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
		
		<div class="alert alert-success" role="alert">
			<strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
		</div>

		@endif
	</div>
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="well">
				{{ Form::label('name', trans('adminlte_lang::message.resource_name')) }}
				<p class="lead">{{ $resource->name }}</p>

				{{ Form::label('description', trans('adminlte_lang::message.description')) }}
				<p class="lead">{{ $resource->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('resource', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('resource.edit', trans('adminlte_lang::message.edit'), [$resource->resource_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('resource', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['resource.destroy', $resource->resource_id], "method" => 'DELETE']) !!}
								{{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger btn-block']) }}
							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
							{{ Html::linkRoute('resource.index', trans('adminlte_lang::message.resources').' »', [], ['class' => 'btn btn-default btn-block', 
																													  'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection