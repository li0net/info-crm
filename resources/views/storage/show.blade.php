@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $storage->title }}
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
		<div class="col-sm-6 col-sm-offset-3">
			<div class="well">
				{{ Form::label('title', "Наименование: ") }}
				<p class="lead">{{ $storage->title }}</p>

				{{ Form::label('type', "Тип: ") }}
				<p class="lead">
					@if( $storage->type == 0 )
						Для списания расходных материалов
					@else
						Для продажи товаров
					@endif
				</p>

				{{ Form::label('description', "Описание: ") }}
				<p class="lead">{{ $storage->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('storage', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('storage.edit', 'Редактировать', [$storage->storage_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('storage', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['storage.destroy', $storage->storage_id], "method" => 'DELETE']) !!}

							{{ Form::submit('Удалить', ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
							{{ Html::linkRoute('storage.index', 'Все склады »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection