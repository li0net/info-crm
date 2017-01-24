@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $account->title }}
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
		<div class="col-md-4 col-md-offset-4">
			<div class="well">
				{{ Form::label('title', "Название: ") }}
				<p class="lead">{{ $account->title }}</p>

				{{ Form::label('type', "Тип счета: ") }}
				<p class="lead">
					@if ($account->type == "cash")
						Наличный расчет
					@else
						Безналичный расчет
					@endif
				</p>
			
				<dl class="dl-horizontal">
					<label>Баланс:</label>
					<p class="lead">{{ $account->balance }}</p>
				</dl>

				{{ Form::label('comment', "Комментарий: ") }}
				<p class="lead">{{ $account->comment }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('account', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('account.edit', 'Редактировать', [$account->account_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('account', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['account.destroy', $account->account_id], "method" => 'DELETE']) !!}

							{{ Form::submit('Удалить', ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-md-12">
							{{ Html::linkRoute('account.index', 'Все счета »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection