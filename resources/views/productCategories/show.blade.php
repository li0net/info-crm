@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $productCategory->title }}
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
		<div class="col-md-6 col-md-offset-3">
			<div class="well">
				{{ Form::label('title', trans('adminlte_lang::message.category_title')) }}
				<p class="lead">{{ $productCategory->title }}</p>

				{{ Form::label('description', trans('adminlte_lang::message.description')) }}
				<p class="lead">{{ $productCategory->description }}</p>

				{{ Form::label('parent_category_id', trans('adminlte_lang::message.parent_category')) }}
				<p class="lead">{{ $productCategory->article }}</p>

				<hr>

				<div class="row">
					@if ($user->hasAccessTo('productCategories', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('productCategories.edit', trans('adminlte_lang::message.edit'), [$productCategory->product_category_id], 
																												['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('productCategories', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['productCategories.destroy', $productCategory->product_category_id], "method" => 'DELETE']) !!}

							{{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-md-12">
							{{ Html::linkRoute('productCategories.index', trans('adminlte_lang::message.product_categories').' »', [], ['class' => 'btn btn-default btn-block', 
																																		'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection