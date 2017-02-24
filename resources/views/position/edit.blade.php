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
		{!! Form::model($position, ['route' => ['position.update', $position->position_id], "method" => 'PUT']) !!}
			<div class="col-sm-6 col-sm-offset-3">
				<div class="well">
					<div class="form-group">
						{{ Form::label('title', trans('adminlte_lang::message.position_name')) }}
						{{ Form::text('title', null, ['class' => 'text-left form-control', 
													  'placeholder' => trans('adminlte_lang::message.specialization_example')]) }}
					</div>
				
					<div class="form-group">
						<label>{{ trans('adminlte_lang::message.description') }}</label>
						{{ Form::textarea('description', null, ['class' => 'text-left form-control', 
																'placeholder' => trans('adminlte_lang::message.service_example')]) }}
					</div>
					
					<hr>

					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<div class="row">
								<div class="col-sm-6">
									{!! Html::linkRoute('position.show', trans('adminlte_lang::message.cancel'), [$position->position_id], 
																												 ['class'=>'btn btn-danger btn-block']) !!}
								</div>
								<div class="col-sm-6">
									{{ Form::submit(trans('adminlte_lang::message.save'), ['class'=>'btn btn-success btn-block']) }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@endsection