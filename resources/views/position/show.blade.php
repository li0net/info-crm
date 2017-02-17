@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $position->title }}
@endsection

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
		
		<div class="alert alert-success" role="alert">
			<strong>Успешно:</strong> {{ Session::get('success') }}
		</div>

		@endif
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="well">
				{{ Form::label('position_id', "Должность: ") }}
				<p class="lead">#{{ $position->position_id }}</p>

				{{ Form::label('title', "Название: ") }}
				<p class="lead">{{ $position->title }}</p>
			
				<dl class="dl-horizontal">
					<label>Описание:</label>
					<p class="lead">{{ $position->description }}</p>
				</dl>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('employee', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('position.edit', 'Редактировать', [$position->position_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('position', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['position.destroy', $position->position_id], "method" => 'DELETE']) !!}

							{{ Form::submit('Удалить', ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
							{{ Html::linkRoute('position.index', 'Все должности »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>

			</div>
		</div>
	</div>
@endsection