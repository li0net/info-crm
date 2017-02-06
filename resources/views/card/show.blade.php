@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $card->title }}
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
		<div class="col-md-6 col-md-offset-3">
			<div class="well">
				{{ Form::label('title', "Наименование: ") }}
				<p class="lead">{{ $card->title }}</p>

				{{ Form::label('description', "Описание: ") }}
				<p class="lead">{{ $card->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('card', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('card.edit', 'Редактировать', [$card->card_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('card', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['card.destroy', $card->card_id], "method" => 'DELETE']) !!}

							{{ Form::submit('Удалить', ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-md-12">
							{{ Html::linkRoute('card.index', 'Все технологические карты »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection