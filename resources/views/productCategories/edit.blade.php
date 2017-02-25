@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h4>{{ trans('adminlte_lang::message.product_ctgs_create_new') }}</h4>	
			<hr>	
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<div class="well">
				{{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
				{!! Form::model($productCategory, ['route' => ['productCategories.update', $productCategory->product_category_id], 'method' => 'PUT']) !!}
					<div class="form-group">
						{{ Form::label('title', trans('adminlte_lang::message.category_title'), ['class' => 'form-spacing-top']) }}
						{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
					</div>

					<div class="form-group">
						{{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'form-spacing-top']) }}
						{{ Form::text('description', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
					</div>
					
					<div class="form-group">
						{{ Form::label('parent_category_id', trans('adminlte_lang::message.parent_category'), ['class' => 'form-spacing-top', 'disabled' => '']) }}
						{{ Form::text('parent_category_id', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110', 'disabled'=> '']) }}
					</div>
					
					<hr>

					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<div class="row">
								<div class="col-md-6">
									{!! Html::linkRoute('productCategories.show', trans('adminlte_lang::message.cancel'), [$productCategory->product_category_id], ['class'=>'btn btn-danger btn-block']) !!}
								</div>
								<div class="col-md-6">
									{{ Form::submit(trans('adminlte_lang::message.save'), ['class'=>'btn btn-success btn-block']) }}
								</div>
							</div>
						</div>
					</div>
				{!! Form::close() !!}	
			</div>
		</div>
	</div>
@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}