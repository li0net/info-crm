@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employees') }}
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
		<div class="col-sm-8">
			<h4>Все финансовые операции</h4>
		</div>	

		<div class="col-sm-4">
			<a href="{{ route('payment.create') }}" class="btn btn-primary pull-right">Новый платеж</a>
			<a href="#" class="btn btn-default m-r pull-right">Загрузить из Excel</a>
			<a href="#" class="btn btn-default m-r pull-right">Выгрузить в Excel</a>
		</div>

		<div class="col-sm-12">
			<hr>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table">
				<thead>
					<th class="text-center">#</th>
					<th>Дата</th>
					<th>Наименование контрагента</th>
					<th>Назначение</th>
					<th>Касса</th>
					<th>Комментарий</th>
					<th>Автор</th>
					<th>Сумма</th>
					<th>Остаток в кассе</th>
					<th>Услуга/Товар</th>
					<th>Визит</th>
				</thead>
				<tbody>
					@foreach($payments as $payment)
						<tr>
							<th class="text-center">{{ $payment->payment_id }}</th>
							<td>{{ $payment->date }}</td>
							<td>{{ $payment->beneficiary_title }}</td>
							<td>{{ $payment->item_title }}</td>
							<td>{{ $payment->account_title }}</td>
							<td>{{ $payment->description }}</td>
							<td>{{ $payment->author_name }}</td>
							<td>{{ $payment->sum }}</td>
							<td> <Это расчетное поле> </td>
							<td></td>
							<td></td>

							<td class="text-right">
								@if ($user->hasAccessTo('payment', 'edit', 0))
									<a href="{{ route('payment.edit', $payment->payment_id) }}" id="payment_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('payment', 'delete', 0))
									{!! Form::open(['route' => ['payment.destroy', $payment->payment_id], 'id' => 'form'.$payment->payment_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$payment->payment_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{!! $payments->render(); !!} 
			</div>
		</div>
	</div>		
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>