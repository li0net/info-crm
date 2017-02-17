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
		{!! Form::model($position, ['route' => ['position.update', $position->position_id], "method" => 'PUT']) !!}
			<div class="col-sm-4 col-sm-offset-4">
				<div class="well">
					{{ Form::label('position_id', "Должность: ") }}
					<p class="lead">#{{ $position->position_id }}</p>

					{{ Form::label('title', "Название: ") }}
					{{ Form::text('title', null, ['class' => 'text-left form-control', 'placeholder' => 'Пример: Парикмахер']) }}
					{{-- <p class="lead">{{ $position->title }}</p> --}}
				
					<dl class="dl-horizontal">
						<label>Описание:</label>
						{{ Form::textarea('description', null, ['class' => 'text-left form-control', 'placeholder' => 'Пример: Весь спектр мужских причесок']) }}
						{{-- <p class="lead">{{ $position->description }}</p> --}}
					</dl>
					
					<hr>

					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<div class="row">
								<div class="col-sm-6">
									{!! Html::linkRoute('position.show', 'Отмена', [$position->position_id], ['class'=>'btn btn-danger btn-block']) !!}
								</div>
								<div class="col-sm-6">
									{{ Form::submit('Сохранить', ['class'=>'btn btn-success btn-block']) }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@endsection