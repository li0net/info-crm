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
			<h4>Информация о схеме расчета ЗП</h4>	
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
				{!! Form::model($product, ['route' => ['product.update', $product->product_id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
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
								{{ Form::label('article', 'Артикул:', ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-9">
								{{ Form::text('article', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('barcode', 'Штрих-код:', ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-9">
								{{ Form::text('barcode', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('category', 'Категория:', ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-9">
								{{ Form::text('category', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('price', 'Цена продажи:', ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-9">
								{{ Form::text('price', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('', 'Единица измерения:', ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-4">
								<p>Для продажи</p>
								{{ Form::select('unit_for_sale', ['pcs' => 'штуки', 'ml' => 'миллилитры'], 'pcs', ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<div class="col-sm-1">
								<p>Равно</p>
								<div class="input-group">
									<span class="input-group-addon">=</span>
									<input type="text" class="form-control" name="is_equal" value="2"> 
								</div>
							</div>
							<div class="col-sm-4">
								<p>Для списания</p>
								{{ Form::select('unit_for_disposal', ['pcs' => 'штуки', 'ml' => 'миллилитры'], 'pcs', ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							{{ Form::label('critical_balance', 'Критичный остаток:', ['class' => 'form-spacing-top col-sm-2 control-label']) }}
							<div class="col-sm-9">
								<div class="input-group">
									{{ Form::text('critical_balance', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
									<span class="input-group-addon">шт.</span>
								</div>
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							{{ Form::label('critical_balance', 'Массы:', ['class' => 'form-spacing-top col-sm-2 control-label']) }}
							<div class="col-sm-4">
								<p>Масса нетто:</p>
								<div class="input-group">
									{{ Form::text('net_weight', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
									<span class="input-group-addon">гр.</span>
								</div>
							</div>
							<div class="col-sm-1"></div>
							<div class="col-sm-4">
								<p>Масса брутто:</p>
								<div class="input-group">
									{{ Form::text('gross_weight', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
									<span class="input-group-addon">гр.</span>
								</div>
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							{{ Form::label('description', 'Описание:', ['class' => 'form-spacing-top col-sm-2 control-label']) }}
							<div class="col-sm-9">
								{{ Form::textarea('description', null, ['class' => 'form-control']) }}
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
									{!! Html::linkRoute('product.show', 'Отмена', [$product->product_id], ['class'=>'btn btn-danger btn-block']) !!}
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