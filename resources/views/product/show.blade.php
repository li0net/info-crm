@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $product->title }}
@endsection

@section('main-content')

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<div class="well">
				{{ Form::label('title', trans('adminlte_lang::message.product_title')) }}
				<p class="lead">{{ $product->title }}</p>

				{{ Form::label('article', trans('adminlte_lang::message.article')) }}
				<p class="lead">{{ $product->article }}</p>

				{{ Form::label('barcode', trans('adminlte_lang::message.bar_code')) }}
				<p class="lead">{{ $product->barcode }}</p>

				{{ Form::label('category', trans('adminlte_lang::message.category')) }}
				<p class="lead">{{ $category->title }}</p>

				{{ Form::label('storage_id', trans('adminlte_lang::message.storage')) }}
				<p class="lead">{{ $storage->title }}</p>

				{{ Form::label('price', trans('adminlte_lang::message.sell_price')) }}
				<p class="lead">{{ $product->price }}</p>

				{{ Form::label('', trans('adminlte_lang::message.unit')) }}
				<p class="lead">
					@if($product->unit_for_sale = 'pcs') 
						{{ trans('adminlte_lang::message.pieces') }}&nbsp;
					@else
						{{ trans('adminlte_lang::message.milliliters') }}
					@endif
					=&nbsp;{{ $product->is_equal }}&nbsp;
					@if($product->unit_for_disposal = 'pcs')
						{{ trans('adminlte_lang::message.pieces') }}&nbsp;
					@else
						{{ trans('adminlte_lang::message.milliliters') }}
					@endif
				</p>

				{{ Form::label('critical_balance', trans('adminlte_lang::message.critical_balance')) }}
				<p class="lead">{{ $product->critical_balance }}</p>

				{{ Form::label('net_weight', trans('adminlte_lang::message.net_weight')) }}
				<p class="lead">{{ $product->net_weight }}</p>
				{{ Form::label('gross_weight', trans('adminlte_lang::message.gross_weight')) }}
				<p class="lead">{{ $product->gross_weight }}</p>
				
				{{ Form::label('description', trans('adminlte_lang::message.description')) }}
				<p class="lead">{{ $product->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('product', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('product.edit', trans('adminlte_lang::message.edit'), [$product->product_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('product', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['product.destroy', $product->product_id], "method" => 'DELETE']) !!}
								{{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger btn-block']) }}
							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
							{{ Html::linkRoute('product.index', trans('adminlte_lang::message.products').' »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 
																															   'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection