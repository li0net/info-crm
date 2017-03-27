@if(count($payments) == 0)
	<div class="row">
		<hr>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center">
			<h4><b>{{ trans('adminlte_lang::message.no_such_transations') }}</b></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center m-b">
			{{ trans('adminlte_lang::message.you_can_add_payment') }}
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center">
            <a href="{{ route('payment.create') }}" class="btn btn-primary">{{ trans('adminlte_lang::message.new_payment') }}</a>
		</div>
	</div>
@else
	<table class="table table-hover table-condensed">
		<thead>
			<th class="text-center">#</th>
			<th>{{ trans('adminlte_lang::message.date') }}</th>
			<th>{{ trans('adminlte_lang::message.beneficiary_name') }}</th>
			<th>{{ trans('adminlte_lang::message.purpose') }}</th>
			<th>{{ trans('adminlte_lang::message.account') }}</th>
			{{-- <th>{{ trans('adminlte_lang::message.comment') }}</th>
			<th>{{ trans('adminlte_lang::message.author') }}</th> --}}
			<th>{{ trans('adminlte_lang::message.sum') }}</th>
			<th>{{ trans('adminlte_lang::message.balance_in_cash') }}</th>
			{{-- <th>{{ trans('adminlte_lang::message.service_good') }}</th>
			<th>{{ trans('adminlte_lang::message.visit') }}</th> --}}
            <th class="text-center">{{ trans('adminlte_lang::message.actions') }}</th>
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
					{{-- <td>{{ $payment->description }}</td>
					<td>{{ $payment->user->name }}</td> --}}
					<td>{{ $payment->sum }}</td>
					<td> 0-00 </td>
					{{-- <td></td>
					<td></td> --}}

					<td class="text-right" style="min-width: 100px;">
						@if ($user->hasAccessTo('payment', 'edit', 0))
							<a href="{{ route('payment.edit', $payment->payment_id) }}" id="payment_edit" class="table-action-link"><i class='fa fa-pencil'></i></a>
						@endif
						@if ($user->hasAccessTo('payment', 'delete', 0))
							{!! Form::open(['route' => ['payment.destroy', $payment->payment_id], 'id' => 'form'.$payment->payment_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
								<a href="javascript: submitform('#form{{$payment->payment_id}}')" class="table-action-link"><i class='fa fa-trash-o'></i></a>
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