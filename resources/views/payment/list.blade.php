@foreach($payments as $payment)
	<tr>
		<th class="text-center">{{ $payment->payment_id }}</th>
		<td>{{ $payment->date }}</td>
		<td>{{ $payment->beneficiary_title }}</td>
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