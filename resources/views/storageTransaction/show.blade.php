@extends('adminlte::layouts.app')

@section('htmlheader_title')
	<p>Информация о складской операции # {{ $transaction->id }}</p>
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
				{{ Form::label('title', "Дата и время проведения операции: ") }}
				<p class="lead">{{ $transaction->date }}</p>

				{{ Form::label('type', "Тип операции: ") }}
				<p class="lead">
					@if ($transaction->type == "income")
						Приход
					@elseif ($transaction->type == "expenses")
						Расход
					@elseif ($transaction->type == "discharge")
						Списание
					@else
						Перемещение
					@endif
				</p>

				{{ Form::label('partner_id', "Описание: ") }}
				<p class="lead">{{ $transaction->partner_id }}</p>

				{{ Form::label('description', "Описание: ") }}
				<p class="lead">{{ $transaction->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('storageTransaction', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('storagetransaction.edit', 'Редактировать', [$transaction->id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('storageTransaction', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['storagetransaction.destroy', $transaction->id], "method" => 'DELETE']) !!}

							{{ Form::submit('Удалить', ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
							{{ Html::linkRoute('storagetransaction.index', 'Все складские операции »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection