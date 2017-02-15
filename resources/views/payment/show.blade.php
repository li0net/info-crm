@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $payment->title }}
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
				{{ Form::label('date', "Дата и время: ") }}
				<p class="lead">{{ $payment->date }}</p>

				{{ Form::label('item_id', "Статья платежа: ") }}
				<p class="lead">{{ $item->title }}</p>

				{{ Form::label('account_id', "Счет: ") }}
				<p class="lead">{{ $account->title }}</p>

				{{ Form::label('beneficiary_type', "Получатель: ") }}
				<p class="lead">
					@if ($payment->beneficiary_type == "partner")
						Контрагент
					@elseif (($payment->beneficiary_type == "client"))
						Клиент
					@else
						Сотрудник
					@endif
				</p>

				{{ Form::label('beneficiary_title', "Наименование контрагента: ") }}
				<p class="lead">{{ $payment->beneficiary_title }}</p>

				{{ Form::label('sum', "Сумма: ") }}
				<p class="lead">{{ $payment->sum }}</p>

				{{ Form::label('description', "Описание: ") }}
				<p class="lead">{{ $payment->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('payment', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('payment.edit', 'Редактировать', [$payment->payment_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('payment', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['payment.destroy', $payment->payment_id], "method" => 'DELETE']) !!}

							{{ Form::submit('Удалить', ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
						{{ Html::linkRoute('payment.index', 'Все платежи »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection