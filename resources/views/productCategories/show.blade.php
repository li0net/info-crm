@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $productCategory->title }}
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
				<p class="lead">{{ $productCategory->title }}</p>

				{{ Form::label('description', "Описание: ") }}
				<p class="lead">{{ $productCategory->description }}</p>

				{{ Form::label('parent_category_id', "Артикул: ") }}
				<p class="lead">{{ $productCategory->article }}</p>

				<hr>

				<div class="row">
					@if ($user->hasAccessTo('productCategories', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('productCategories.edit', 'Редактировать', [$productCategory->product_category_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('productCategories', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['productCategories.destroy', $productCategory->product_category_id], "method" => 'DELETE']) !!}

							{{ Form::submit('Удалить', ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-md-12">
							{{ Html::linkRoute('productCategories.index', 'Все категории товаров »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection