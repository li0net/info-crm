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
			<h4>Создание новой категории товара</h4>	
			{{-- <ex1></ex1> --}}
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
				{!! Form::model($productCategory, ['route' => ['productCategories.update', $productCategory->product_category_id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
					<div class="row">
						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('title', 'Наименование:', ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-9">
								{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('description', 'Описание:', ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-9">
								{{ Form::text('description', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('parent_category_id', 'Родительская категория:', ['class' => 'form-spacing-top', 'disabled' => '']) }}
							</div>
							<div class="col-sm-9">
								{{ Form::text('parent_category_id', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110', 'disabled'=> '']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>
					</div>
					
					<hr>

					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<div class="row">
								<div class="col-md-6">
									{!! Html::linkRoute('productCategories.show', 'Отмена', [$productCategory->product_category_id], ['class'=>'btn btn-danger btn-block']) !!}
								</div>
								<div class="col-md-6">
									{{ Form::submit('Сохранить', ['class'=>'btn btn-success btn-block']) }}
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