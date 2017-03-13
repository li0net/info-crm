@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.products') }}
@endsection

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
		
		<div class="alert alert-success" role="alert">
			<strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
		</div>

		@endif
	</div>

	<div class="row">
		<div class="col-sm-4">
			<h4>{{ trans('adminlte_lang::message.products') }}</h4>
		</div>	

		<div class="col-sm-8">
			<a href="{{ route('product.create') }}" class="btn btn-primary pull-right">{{ trans('adminlte_lang::message.new_product') }}</a>
			<a href="#" class="btn btn-default m-r pull-right">{{ trans('adminlte_lang::message.load_from_excel') }}</a>
			<a href="#" class="btn btn-default m-r pull-right">{{ trans('adminlte_lang::message.upload_into_excel') }}</a>
		</div>

		<div class="col-sm-12">
			<hr>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-hover table-condensed">
				<thead>
					<th class="text-center">#</th>
					<th>{{ trans('adminlte_lang::message.product_title') }}</th>
					<th>{{ trans('adminlte_lang::message.sell_price') }}</th>
					<th>{{ trans('adminlte_lang::message.unit') }}</th>
					<th>{{ trans('adminlte_lang::message.comment') }}</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($products as $product)
						<tr>
							<th class="text-center">{{ $product->product_id }}</th>
							<td>
								{{ $product->title }}
								<br>
								<small>{{ $product->description }}</small>
							</td>
							<td>
								{{ $product->price }} &#8381;
								<br>
								<small>{{ trans('adminlte_lang::message.cost_of_goods_for_sale') }}</small>
							</td>
							<td> 
								@if($product->unit_for_sale == 'pcs') 
									{{ trans('adminlte_lang::message.pieces') }}&nbsp;
								@else
									{{ trans('adminlte_lang::message.milliliters') }}
								@endif
								=&nbsp;{{ $product->is_equal }}&nbsp;
								@if($product->unit_for_disposal == 'pcs')
									{{ trans('adminlte_lang::message.pieces') }}&nbsp; 
								@else
									{{ trans('adminlte_lang::message.milliliters') }}
								@endif
								<br>
								<small>{{ trans('adminlte_lang::message.formula_for_disposal') }}</small>
							</td>
							<td>
								{{ $product->description }}
							</td>
							<td class="text-right">
								@if ($user->hasAccessTo('product', 'edit', 0))
									<a href="{{ route('product.edit', $product->product_id) }}" id="product_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('product', 'delete', 0))
									{!! Form::open(['route' => ['product.destroy', $product->product_id], 'id' => 'form'.$product->product_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$product->product_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{!! $products->render(); !!} 
			</div>
		</div>
	</div>		
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>