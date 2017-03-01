@if(count($products) == 0)
	<div class="row">
		<hr>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center">
			<h4><b>{{ trans('adminlte_lang::message.no_such_products') }}</b></h4>
		</div>
	</div>
@else
	<table class="table table-hover table-striped">
		<thead>
			<th>{{ trans('adminlte_lang::message.article') }}</th>
			<th>{{ trans('adminlte_lang::message.product_title') }}</th>
			<th>{{ trans('adminlte_lang::message.amount') }}</th>
			<th>{{ trans('adminlte_lang::message.writeoff_balance') }}</th>
			<th>{{ trans('adminlte_lang::message.cost_price') }}</th>
			<th>{{ trans('adminlte_lang::message.margin') }}</th>
			<th>{{ trans('adminlte_lang::message.margin_pctg') }}</th>
			<th>{{ trans('adminlte_lang::message.price') }}</th>
			<th>{{ trans('adminlte_lang::message.integrated_cost') }}</th>
		</thead>
		<tbody>
			@foreach($products as $product)
				<tr>
					<th class="text-center">{{ $product->article }}</th>
					<td>
						{{ $product->title }}
					</td>
					<td>
						{{ $product->amount }}
						@if($product->unit_for_sale == 'pcs') 
							{{ trans('adminlte_lang::message.pieces') }}&nbsp;
						@else
							{{ trans('adminlte_lang::message.milliliters') }}
						@endif
					</td>
					<td> 
						{{ $product->amount * $product->is_equal }}
						@if($product->unit_for_disposal == 'pcs')
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
						{{ $product->price }}
					</td>
					<td>
						{{ $product->price * $product->amount}}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<div class="text-center">
		{!! $products->render(); !!} 
	</div>
@endif