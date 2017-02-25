@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.product_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<h4>{{ trans('adminlte_lang::message.information_about_product') }}</h4>	
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
				{!! Form::open(['route' => 'product.store', 'class' => 'form-horizontal']) !!}
					<div class="row">
						<div class="form-group">
							<div class="col-sm-3 control-label">
								{{ Form::label('title', trans('adminlte_lang::message.product_title'), ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-8">
								{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-3 control-label">
								{{ Form::label('article', trans('adminlte_lang::message.article'), ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-8">
								{{ Form::text('article', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-3 control-label">
								{{ Form::label('barcode', trans('adminlte_lang::message.bar_code'), ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-8">
								{{ Form::text('barcode', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-3 control-label">
								{{ Form::label('category_id', trans('adminlte_lang::message.category'), ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-8">
								{{ Form::select('category_id', $categories, null, ['class' => 'form-control', 'required' => '']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-3 control-label">
								{{ Form::label('storage_id', trans('adminlte_lang::message.storage'), ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-8">
								{{ Form::select('storage_id', $storages, null, ['class' => 'form-control', 'required' => '']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="storage_id" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-3 control-label">
								{{ Form::label('price', trans('adminlte_lang::message.sell_price'), ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-8">
								{{ Form::text('price', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-3 control-label">
								{{ Form::label('', trans('adminlte_lang::message.unit'), ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-3">
								<p>{{ trans('adminlte_lang::message.for_sale') }}</p>
								{{ Form::select('unit_for_sale', ['pcs' => trans('adminlte_lang::message.pieces'), 
																  'ml' => trans('adminlte_lang::message.milliliters')], 
																  'pcs', 
																  ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<div class="col-sm-2">
								<p>{{ trans('adminlte_lang::message.is_equal') }}</p>
								<div class="input-group">
									<span class="input-group-addon">=</span>
									<input type="text" class="form-control" name="is_equal" value="2"> 
								</div>
							</div>
							<div class="col-sm-3">
								<p>{{ trans('adminlte_lang::message.for_disposal') }}</p>
								{{ Form::select('unit_for_disposal', ['pcs' => trans('adminlte_lang::message.pieces'), 
																  	  'ml' => trans('adminlte_lang::message.milliliters')], 
																  	  'pcs', 
																  	  ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							{{ Form::label('critical_balance', trans('adminlte_lang::message.critical_balance'), ['class' => 'form-spacing-top col-sm-3 control-label']) }}
							<div class="col-sm-8">
								<div class="input-group">
									{{ Form::text('critical_balance', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
									<span class="input-group-addon">{{ trans('adminlte_lang::message.pcs') }}</span>
								</div>
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							{{ Form::label('critical_balance', trans('adminlte_lang::message.weights'), ['class' => 'form-spacing-top col-sm-3 control-label']) }}
							<div class="col-sm-3">
								<p>{{ trans('adminlte_lang::message.net_weight') }}</p>
								<div class="input-group">
									{{ Form::text('net_weight', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
									<span class="input-group-addon">{{ trans('adminlte_lang::message.g') }}</span>
								</div>
							</div>
							<div class="col-sm-2"></div>
							<div class="col-sm-3">
								<p>{{ trans('adminlte_lang::message.gross_weight') }}</p>
								<div class="input-group">
									{{ Form::text('gross_weight', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
									<span class="input-group-addon">{{ trans('adminlte_lang::message.g') }}</span>
								</div>
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							{{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'form-spacing-top col-sm-3 control-label']) }}
							<div class="col-sm-8">
								{{ Form::textarea('description', null, ['class' => 'form-control']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>
					</div>
					
					<hr>
					
					<div class="row">
						<div class="col-sm-4 col-sm-offset-4">
							{{	Form::submit(trans('adminlte_lang::message.product_create_new'), ['class' => 'btn btn-success btn-block']) }}
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