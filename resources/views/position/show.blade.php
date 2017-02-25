@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $position->title }}
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
				{{ Form::label('title', trans('adminlte_lang::message.position_name')) }}
				<p class="lead">{{ $position->title }}</p>
			
				<dl class="dl-horizontal">
					<label>{{ trans('adminlte_lang::message.description') }}</label>
					<p class="lead">{{ $position->description }}</p>
				</dl>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('employee', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('position.edit', trans('adminlte_lang::message.edit'), [$position->position_id], 
																									   ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('position', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['position.destroy', $position->position_id], "method" => 'DELETE']) !!}
								{{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger btn-block']) }}
							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
							{{ Html::linkRoute('position.index', trans('adminlte_lang::message.positions').' »', [], ['class' => 'btn btn-default btn-block', 
																													  'style' => 'margin-top:15px']) }}
					</div>
				</div>

			</div>
		</div>
	</div>
@endsection