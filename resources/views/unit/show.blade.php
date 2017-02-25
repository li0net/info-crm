@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $unit->title }}
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
				{{ Form::label('title', trans('adminlte_lang::message.unit_title')) }}
				<p class="lead">{{ $unit->title }}</p>

				{{ Form::label('short_title', trans('adminlte_lang::message.unit_short_title')) }}
				<p class="lead">{{ $unit->short_title }}</p>

				{{ Form::label('description', trans('adminlte_lang::message.description')) }}
				<p class="lead">{{ $unit->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('unit', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('unit.edit', trans('adminlte_lang::message.edit'), [$unit->unit_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('unit', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['unit.destroy', $unit->unit_id], "method" => 'DELETE']) !!}
								{{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger btn-block']) }}
							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
							{{ Html::linkRoute('unit.index', trans('adminlte_lang::message.units').' »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 
																														 'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection