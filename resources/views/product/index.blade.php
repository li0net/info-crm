
@extends('adminlte::layouts.app')
@section('htmlheader_title')
	{{ trans('adminlte_lang::message.products') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.products') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.products') }}</li>
    </ol>
</section>
<div class="container-fluid">

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-12 text-right">
			<a href="#" class="btn btn-info m-r">{{ trans('adminlte_lang::message.load_from_excel') }}</a>
            <a href="#" class="btn btn-info m-r">{{ trans('adminlte_lang::message.upload_into_excel') }}</a>
            <a href="{{ route('product.create') }}" class="btn btn-primary">{{ trans('adminlte_lang::message.new_product') }}</a>
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
                    <th class="text-center">{{ trans('adminlte_lang::message.actions') }}</th>
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
							<td class="text-center">
								@if ($user->hasAccessTo('product', 'edit', 0))
									<a href="{{ route('product.edit', $product->product_id) }}" id="product_edit" class=table-action-link"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('product', 'delete', 0))
									{!! Form::open(['route' => ['product.destroy', $product->product_id], 'id' => 'form'.$product->product_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$product->product_id}}')" class="table-action-link danger-action"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{!! $products->render() !!}
			</div>
		</div>
	</div>		
</div>
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>