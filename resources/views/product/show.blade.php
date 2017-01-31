@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $product->title }}
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
		<div class="col-md-6 col-md-offset-3">
			<div class="well">
				{{ Form::label('title', "Наименование: ") }}
				<p class="lead">{{ $product->title }}</p>

				{{ Form::label('article', "Артикул: ") }}
				<p class="lead">{{ $product->article }}</p>

				{{ Form::label('barcode', "Штрих-код: ") }}
				<p class="lead">{{ $product->barcode }}</p>

				{{ Form::label('category', "Категория: ") }}
				<p class="lead">{{ $product->category }}</p>

				{{ Form::label('price', "Цена продажи: ") }}
				<p class="lead">{{ $product->price }}</p>

				{{ Form::label('', "Единица измерения: ") }}
				<p class="lead">
					@if($product->unit_for_sale = 'pcs') 
						Штуки&nbsp;
					@else
						Миллилитры
					@endif
					=&nbsp;{{ $product->is_equal }}&nbsp;
					@if($product->unit_for_disposal = 'pcs')
						Штуки&nbsp;
					@else
						Миллилитры
					@endif
				</p>

				{{ Form::label('critical_balance', "Критичный остаток: ") }}
				<p class="lead">{{ $product->critical_balance }}</p>

				{{ Form::label('net_weight', "Масса нетто: ") }}
				<p class="lead">{{ $product->net_weight }}</p>
				{{ Form::label('gross_weight', "Масса брутто: ") }}
				<p class="lead">{{ $product->gross_weight }}</p>
				
				{{ Form::label('description', "Описание: ") }}
				<p class="lead">{{ $product->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('product', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('product.edit', 'Редактировать', [$product->product_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('product', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['product.destroy', $product->product_id], "method" => 'DELETE']) !!}

							{{ Form::submit('Удалить', ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-md-12">
							{{ Html::linkRoute('product.index', 'Все товары »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection