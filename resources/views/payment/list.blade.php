@if(count($payments) == 0)
	<div class="row">
		<hr>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center">
			<h4><b>Операций с такими параметрами не обнаружено</b></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center m-b">
			Вы можете добавить новый платеж
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center">
			<a href="/payment/create" class="btn btn-primary">Новый платеж</a>
		</div>
	</div>
@else
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
					@if($payment->beneficiary_type == 'partner' && null !== $payment->partner)
						<td>{{ $payment->partner->title }}</td>
					@elseif($payment->beneficiary_type == 'client' && null !== $payment->client) 
						<td>{{ $payment->client->name }}</td>
					@elseif(null !== $payment->employee)
						<td>{{ $payment->employee->name }}</td>
					@else
						<td></td>
					@endif
					<td>{{ $payment->item->title }}</td>
					<td>{{ $payment->account->title }}</td>
					<td>{{ $payment->description }}</td>
					<td>{{ $payment->user->name }}</td>
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
	<div class="text-center filtered">
		{!! $payments->render(); !!} 
	</div>
@endif