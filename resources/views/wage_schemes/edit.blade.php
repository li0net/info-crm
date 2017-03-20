@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.information_about_payroll_scheme') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.information_about_payroll_scheme') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li><a href="{{ url('/wage_scheme')}}">{{ trans('adminlte_lang::message.schemes') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.information_about_payroll_scheme') }}</li>
    </ol>
</section>
<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<h4>{{ trans('adminlte_lang::message.information_about_payroll_scheme') }}</h4>	
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
				{!! Form::model($scheme, ['route' => ['wage_scheme.update', $scheme->scheme_id], 'method' => 'PUT']) !!}
					{{ Form::hidden('service_ctgs_options', null, ['id' => 'service_ctgs_options']) }}
					{{ Form::hidden('product_ctgs_options', null, ['id' => 'product_ctgs_options']) }}
					{{-- <div class="row"> --}}
						<div class="form-group">
							<div class="col-sm-10">
								{{ Form::label('scheme_name', trans('adminlte_lang::message.scheme_name')) }}
								{{ Form::text('scheme_name', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<div class="col-sm-2"></div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								{{ Form::label('services_percent', trans('adminlte_lang::message.services')) }}
							</div>
							<div class="col-sm-8">
								{{ Form::text('services_percent', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<div class="col-sm-2">
								{{ Form::select('service_unit', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'form-control', 
																									  'required' => '', 
																									  'maxlength' => '110']) }}
							</div>
							<label class="col-sm-2 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>
						
						<div class="form-group">
							{{-- <label class="col-sm-2 control-label"></label> --}}
							<div class="col-sm-6">
								<a href="#detailed-services" data-toggle="collapse" class="btn btn-link btn-xs">
								<span class="badge label-danger hidden">@{{ detailed_services_count }}</span>
								{{-- <input v-model="detailed_services_count"> --}}
								&nbsp;&nbsp;{{ trans('adminlte_lang::message.specify_val_4_services') }}&nbsp;&nbsp;
								<i class="fa fa-caret-down"></i></a>
							</div>
						</div>

						<div id="detailed-services" class="form-group collapse">
							<div class="wrap-it">
								{{-- <div class="col-sm-2"></div> --}}
								<div class="col-sm-10" style="padding:0">
									<div class="col-sm-4">
										{{ Form::select('services_cats_detailed[]', [], null, ['class' => 'form-control', 
																							   'maxlength' => '110', 
																							   'data-initial-value' => 0]) }}
									</div>
									<div class="col-sm-4">
										{{ Form::select('services_detailed[]', [], null, ['class' => 'form-control', 
																						  'maxlength' => '110', 
																						  'placeholder' => trans('adminlte_lang::message.select_service')]) }}
									</div>
									<div class="col-sm-2">
										{{ Form::text('services_percent_detailed[]', 0, ['class' => 'form-control', 'maxlength' => '110']) }}
									</div>
									<div class="col-sm-2">
										{{ Form::select('services_unit_detailed[]', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'form-control', 
																														  'maxlength' => '110']) }}
									</div>
								</div>
								<div class="col-sm-2" style="margin-bottom: 15px;">
									<input type="button" id="add-detailed-section" class="btn btn-info btn-sm" value={{ trans('adminlte_lang::message.add') }}>
								</div>
							</div>

							@foreach( $services_custom_settings as $service_setting )
								<div class="wrap-it">
									<div class="col-sm-10" style="padding:0">
										<div class="col-sm-4">
											{{ Form::select('services_cats_detailed[]',  [], $service_setting[0], ['class' => 'form-control', 
																												   'required' => '', 
																												   'maxlength' => '110', 
																												   'data-initial-value' => $service_setting[0]]) }}
										</div>
										<div class="col-sm-4">
											{{ Form::select('services_detailed[]', $service_ctgs[$service_setting[0]]->pluck('name', 'service_id')->all(), 
																				   $service_setting[1], ['class' => 'form-control', 
																				   						 'required' => '', 
																				   						 'maxlength' => '110']) }}
										</div>
										<div class="col-sm-2">
											{{ Form::text('services_percent_detailed[]', $service_setting[2], ['class' => 'form-control', 
																											   'maxlength' => '110']) }}
										</div>
										<div class="col-sm-2">
											{{ Form::select('services_unit_detailed[]', ['rub' => '₽', 'pct' => '%'], $service_setting[3], ['class' => 'form-control', 
																																			'required' => '', 
																																			'maxlength' => '110']) }}
										</div>
									</div>
									<div class="col-sm-2" style="margin-bottom: 15px;">
										<input type="button" id="add-detailed-section" class="btn btn-danger btn-sm" value="Удалить">
									</div>
								</div>
							@endforeach
						</div>

						<div class="form-group">
							<div class="col-sm-8">
								{{ Form::label('products_percent', trans('adminlte_lang::message.products')) }}
							</div>
							<div class="col-sm-8">
								{{ Form::text('products_percent', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<div class="col-sm-2">
								{{ Form::select('products_unit', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'form-control', 
																									   'required' => '', 
																									   'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="products_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							{{-- <label class="col-sm-2 control-label"></label> --}}
							<div class="col-sm-6">
								<a href="#detailed-products" data-toggle="collapse" class="btn btn-link btn-xs">
								<span class="badge label-danger hidden">@{{ detailed_products_count }}</span>
								&nbsp;&nbsp;{{ trans('adminlte_lang::message.specify_val_4_products') }}&nbsp;&nbsp;
								<i class="fa fa-caret-down"></i></a>
							</div>
						</div>

						<div id="detailed-products" class="form-group collapse">
							<div class="wrap-it">
								{{-- <div class="col-sm-2"></div>							 --}}
								<div class="col-sm-10" style="padding:0">
									<div class="col-sm-4">
										{{ Form::select('products_cats_detailed[]', [], null, ['class' => 'form-control', 
																							   'maxlength' => '110', 
																							   'data-initial-value' => 0]) }}
									</div>
									<div class="col-sm-4">
										{{ Form::select('products_detailed[]', [], null, ['class' => 'form-control', 
																						  'maxlength' => '110', 
																						  'placeholder' => trans('adminlte_lang::message.select_product')]) }}
									</div>
									<div class="col-sm-2">
										{{ Form::text('products_percent_detailed[]', null, ['class' => 'form-control', 'maxlength' => '110']) }}
									</div>
									<div class="col-sm-2">
										{{ Form::select('products_unit_detailed[]', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'form-control', 
																														  'maxlength' => '110']) }}
									</div>
								</div>
								<div class="col-sm-2" style="margin-bottom: 15px;">
									<input type="button" id="add-detailed-section" class="btn btn-info btn-sm" value={{ trans('adminlte_lang::message.add') }}>
								</div>
							</div>

							@foreach( $products_custom_settings as $product_setting )
								<div class="wrap-it">
									{{-- <div class="col-sm-2"></div>							 --}}
									<div class="col-sm-10" style="padding:0">
										<div class="col-sm-4">
											{{ Form::select('products_cats_detailed[]', [], $product_setting[0], ['class' => 'form-control', 
																												  'required' => '', 
																												  'maxlength' => '110', 
																												  'data-initial-value' => $product_setting[0]]) }}
										</div>
										<div class="col-sm-4">
											{{ Form::select('products_detailed[]', $product_ctgs[$product_setting[0]]->pluck('title', 'product_id')->all(), 
																				   $product_setting[1], ['class' => 'form-control', 
																				   						 'required' => '', 
																				   						 'maxlength' => '110']) }}
										</div>
										<div class="col-sm-2">
											{{ Form::text('products_percent_detailed[]', $product_setting[2], ['class' => 'form-control', 
																											   'maxlength' => '110']) }}
										</div>
										<div class="col-sm-2">
											{{ Form::select('products_unit_detailed[]', ['rub' => '₽', 'pct' => '%'], 
																						$product_setting[3], ['class' => 'form-control', 
																											  'required' => '', 
																											  'maxlength' => '110']) }}
										</div>
									</div>
									<div class="col-sm-2" style="margin-bottom: 15px;">
										<input type="button" id="add-detailed-section" class="btn btn-danger btn-sm" value="Удалить">
									</div>
								</div>
							@endforeach
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								{{ Form::label('wage_rate', trans('adminlte_lang::message.wage')) }}
							</div>
							<div class="col-sm-8">
								{{ Form::text('wage_rate', null, ['class' => 'form-control', 
																  'required' => '', 
																  'maxlength' => '110']) }}
							</div>
							<div class="col-sm-2">
								{{ Form::select('wage_rate_period', ['hour' => trans('adminlte_lang::message.hour'), 
																	 'day' => trans('adminlte_lang::message.day'), 
																	 'month' => trans('adminlte_lang::message.month')], 
																	 'day', 
																	 ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-2 text-left">
								<a class="fa fa-info-circle" id="wage_rate" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							{{-- {{ Form::label(null, null, ['class' => 'col-sm-2 text-right ctrl-label']) }} --}}
							<label class="col-sm-10 text-left">
								{{ Form::checkbox('is_client_discount_counted', true, $scheme->is_client_discount_counted, ['style' => 'margin-right: 10px']) }}
									{{ trans('adminlte_lang::message.consider_discount') }}
							</label>
							<label class="col-sm-2 text-left">
								<a class="fa fa-info-circle" id="is_client_discount_counted" original-title="">&nbsp;</a>
							</label>
						</div>
						
						<div class="form-group">
							{{-- {{ Form::label(null, null, ['class' => 'col-sm-2 text-right ctrl-label']) }} --}}
							<label class="col-sm-10 text-left">
								{{ Form::checkbox('is_material_cost_counted', true, $scheme->is_client_discount_counted, ['style' => 'margin-right: 10px']) }}
									{{ trans('adminlte_lang::message.consider_cost_of_materials') }} 
							</label>
							<label class="col-sm-2 text-left">
								<a class="fa fa-info-circle" id="is_material_cost_counted" original-title="">&nbsp;</a>
							</label>
						</div>
					{{-- </div>						 --}}
					
					{{-- <div class="row"><hr></div> --}}

					<div class="row">
						<div class="col-sm-12"><hr></div>
						<div class="col-sm-8 col-sm-offset-2">
							<div class="row">
								<div class="col-sm-6">
									{!! Html::linkRoute('wage_scheme.show', trans('adminlte_lang::message.cancel'), [$scheme->scheme_id], ['class'=>'btn btn-danger btn-block']) !!}
								</div>
								<div class="col-sm-6">
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

@section('page-specific-scripts')
	<script type="text/javascript">
		$(document).ready(function($) {
			var options = '';

			$.ajax({
				type: "GET",
				dataType: 'json',
				url: '/serviceCategories/gridData',
				data: {},
				success: function(data) {
					for (var i = 0; i < data.rows.length; i++) {
						options += '<option value=' + data.rows[i].service_category_id + '>' + data.rows[i].name + '</option>';
					}

					$('#service_ctgs_options').val(options);

					$('select.form-control[name="services_cats_detailed[]"]').find('option').remove();
					$('select.form-control[name="services_cats_detailed[]"]').append(options);

					$('select.form-control[name="services_cats_detailed[]"]').each(function() {
						var initialValue = $(this).attr('data-initial-value');
						
						if ( 0 != initialValue ) {
							$(this).val(initialValue);
						} else {
							$(this).val($(this).find('option').first().val());
						}
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Error while processing services data range!');
				}
			});

			$.ajax({
				type: "GET",
				dataType: 'json',
				url: '/productCategoriesData',
				data: {},
				success: function(data) {
					options = '';
					for (var i = 0; i < data.length; i++) {
						options += '<option value=' + data[i].product_category_id + '>' + data[i].title + '</option>';
					}

					$('#product_ctgs_options').val(options);

					$('select.form-control[name="products_cats_detailed[]"]').find('option').remove();
					$('select.form-control[name="products_cats_detailed[]"]').append(options);

					$('select.form-control[name="products_cats_detailed[]"]').each(function() {
						var initialValue = $(this).attr('data-initial-value');
						
						if ( 0 != initialValue ) {
							$(this).val(initialValue);
						} else {
							$(this).val($(this).find('option').first().val());
						}
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Error while processing products data range!');
				}
			});

			$('#detailed-services').on('change', 'select[name="services_cats_detailed[]"]', function(e){
				$.ajax({
					type: 'POST',
					dataType: 'json',
					data: {'service_ctgs' : $(this).val()},
					url: "<?php echo route('wage_scheme.detailedServiceOptions') ?>",
					success: function(data) {
						$(e.target).parent().next().children('select[name="services_detailed[]"]').first().html('');
						$(e.target).parent().next().children('select[name="services_detailed[]"]').first().html(data.options);
					}
				});
			});

			$('#detailed-products').on('change', 'select[name="products_cats_detailed[]"]', function(e){
				$.ajax({
					type: 'POST',
					dataType: 'json',
					data: {'product_ctgs' : $(this).val()},
					url: "<?php echo route('wage_scheme.detailedProductOptions') ?>",
					success: function(data) {
						$(e.target).parent().next().children('select[name="products_detailed[]"]').first().html('');
						$(e.target).parent().next().children('select[name="products_detailed[]"]').first().html(data.options);
					}
				});
			});
		});
	</script>
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}