<table class="table table-hover table-striped">
	<thead>
		<th>{{ trans('adminlte_lang::message.article') }}</th>
		<th>{{ trans('adminlte_lang::message.product_title') }}</th>
		<th>{{ trans('adminlte_lang::message.amount') }}</th>
		<th>{{ trans('adminlte_lang::message.cost_price') }}</th>
		<th>{{ trans('adminlte_lang::message.margin') }}</th>
		<th>{{ trans('adminlte_lang::message.margin_pctg') }}</th>
		<th>{{ trans('adminlte_lang::message.integrated_cost') }}</th>
	</thead>
	<tbody>
		@foreach($transactions as $transaction)
			<tr>
				<th class="text-center">{{ $transaction->product->article }}</th>
				<td>
					{{ $transaction->product->title }}
				</td>
				<td>
					{{ $transaction->amount }}
					@if($transaction->product->unit_for_sale == 'pcs') 
						{{ trans('adminlte_lang::message.pieces') }}&nbsp;
					@else
						{{ trans('adminlte_lang::message.milliliters') }}
					@endif
				</td>
				<td>
					0
				</td>
				<td>
					0
				</td>
				<td>
					0
				</td>
				<td>
					{{ $transaction->price * $transaction->amount}}
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
<div class="text-center">
	{!! $transactions->render(); !!} 
</div>