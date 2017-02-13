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
				{!! Form::model($scheme, ['route' => ['wage_scheme.update', $scheme->scheme_id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
					{{ Form::hidden('service_ctgs_options', null, ['id' => 'service_ctgs_options']) }}
					{{ Form::hidden('product_ctgs_options', null, ['id' => 'product_ctgs_options']) }}
					<div class="row">
						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('scheme_name', 'Наименование:', ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-8">
								{{ Form::text('scheme_name', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label">
								{{ Form::label('services_percent', 'Услуги:', ['class' => 'form-spacing-top']) }}
							</label>
							<div class="col-sm-6">
								{{ Form::text('services_percent', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<div class="col-sm-2">
								{{ Form::select('service_unit', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<a href="#detailed-services" data-toggle="collapse" class="btn btn-link btn-xs">
								<span class="badge label-danger hidden">@{{ detailed_services_count }}</span>
								{{-- <input v-model="detailed_services_count"> --}}
								&nbsp;&nbsp;Уточнить значение для категорий или отдельных услуг&nbsp;&nbsp;
								<i class="fa fa-caret-down"></i></a>
							</div>
						</div>

						<div id="detailed-services" class="form-group collapse">
							<div class="wrap-it">
								<div class="col-sm-2"></div>							
								<div class="col-sm-8" style="padding:0">
									<div class="col-sm-4">
										{{ Form::select('services_cats_detailed[]', $service_cats, '0', ['class' => 'form-control', 'maxlength' => '110']) }}
									</div>
									<div class="col-sm-4">
										{{ Form::select('services_detailed[]', ['0' => 'Модельная', '1' => 'Полубокс'], '0', ['class' => 'form-control', 'maxlength' => '110']) }}
									</div>
									<div class="col-sm-2">
										{{ Form::text('services_percent_detailed[]', 0, ['class' => 'form-control', 'maxlength' => '110']) }}
									</div>
									<div class="col-sm-2">
										{{ Form::select('services_unit_detailed[]', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'form-control', 'maxlength' => '110']) }}
									</div>
								</div>
								<div class="col-sm-2" style="margin-bottom: 15px;">
									<input type="button" id="add-detailed-section" class="btn btn-info" value="Добавить">
								</div>
							</div>
							@foreach( $services_custom_settings as $service_setting )
								<div class="wrap-it">
									<div class="col-sm-2"></div>							
									<div class="col-sm-8" style="padding:0">
										<div class="col-sm-4">
											{{ Form::select('services_cats_detailed[]', $service_cats, $service_setting[0], ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
										</div>
										<div class="col-sm-4">
											{{ Form::select('services_detailed[]', ['0' => 'Модельная', '1' => 'Полубокс'], $service_setting[1], ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
										</div>
										<div class="col-sm-2">
											{{ Form::text('services_percent_detailed[]', $service_setting[2], ['class' => 'form-control', 'maxlength' => '110']) }}
										</div>
										<div class="col-sm-2">
											{{ Form::select('services_unit_detailed[]', ['rub' => '₽', 'pct' => '%'], $service_setting[3], ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
										</div>
									</div>
									<div class="col-sm-2" style="margin-bottom: 15px;">
										<input type="button" id="add-detailed-section" class="btn btn-danger" value="Удалить">
									</div>
								</div>
							@endforeach
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								{{ Form::label('products_percent', 'Товары:', ['class' => 'form-spacing-top']) }}
							</label>
							<div class="col-sm-6">
								{{ Form::text('products_percent', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<div class="col-sm-2">
								{{ Form::select('products_unit', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="products_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<a href="#detailed-products" data-toggle="collapse" class="btn btn-link btn-xs">
								<span class="badge label-danger hidden">@{{ detailed_products_count }}</span>
								&nbsp;&nbsp;Уточнить значение для категорий или отдельных товаров&nbsp;&nbsp;
								<i class="fa fa-caret-down"></i></a>
							</div>
						</div>

						<div id="detailed-products" class="form-group collapse">
							<div class="wrap-it">
								<div class="col-sm-2"></div>							
								<div class="col-sm-8" style="padding:0">
									<div class="col-sm-4">
										{{ Form::select('products_cats_detailed[]', ['0' => 'Лаки', '1' => 'Краски'], '0', ['class' => 'form-control', 'maxlength' => '110']) }}
									</div>
									<div class="col-sm-4">
										{{ Form::select('products_detailed[]', ['0' => 'LONDA', '1' => 'WELLA'], '0', ['class' => 'form-control', 'maxlength' => '110']) }}
									</div>
									<div class="col-sm-2">
										{{ Form::text('products_percent_detailed[]', null, ['class' => 'form-control', 'maxlength' => '110']) }}
									</div>
									<div class="col-sm-2">
										{{ Form::select('products_unit_detailed[]', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'form-control', 'maxlength' => '110']) }}
									</div>
								</div>
								<div class="col-sm-2" style="margin-bottom: 15px;">
									<input type="button" id="add-detailed-section" class="btn btn-info" value="Добавить">
								</div>
							</div>
							@foreach( $products_custom_settings as $product_setting )
								<div class="wrap-it">
									<div class="col-sm-2"></div>							
									<div class="col-sm-8" style="padding:0">
										<div class="col-sm-4">
											{{ Form::select('products_cats_detailed[]', ['0' => 'Лаки', '1' => 'Краски'], $product_setting[0], ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
										</div>
										<div class="col-sm-4">
											{{ Form::select('products_detailed[]', ['0' => 'LONDA', '1' => 'WELLA'], $product_setting[1], ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
										</div>
										<div class="col-sm-2">
											{{ Form::text('products_percent_detailed[]', $product_setting[2], ['class' => 'form-control', 'maxlength' => '110']) }}
										</div>
										<div class="col-sm-2">
											{{ Form::select('products_unit_detailed[]', ['rub' => '₽', 'pct' => '%'], $product_setting[3], ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
										</div>
									</div>
									<div class="col-sm-2" style="margin-bottom: 15px;">
										<input type="button" id="add-detailed-section" class="btn btn-danger" value="Удалить">
									</div>
								</div>
							@endforeach
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								{{ Form::label('wage_rate', 'Оклад:', ['class' => 'form-spacing-top']) }}
							</label>
							<div class="col-sm-6">
								{{ Form::text('wage_rate', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<div class="col-sm-2">
								{{ Form::select('wage_rate_period', ['hour' => 'час', 'day' => 'день', 'month' => 'месяц'], 'day', ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="wage_rate" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							{{ Form::label(null, null, ['class' => 'col-sm-2 text-right ctrl-label']) }}
							<label class="col-sm-8 text-left">
								{{ Form::checkbox('is_client_discount_counted', true, $scheme->is_client_discount_counted, ['style' => 'margin-right: 10px']) }}
								 Учитывать скидку клиенту при расчете ЗП 
							</label>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="is_client_discount_counted" original-title="">&nbsp;</a>
							</label>
						</div>
						
						<div class="form-group">
							{{ Form::label(null, null, ['class' => 'col-sm-2 text-right ctrl-label']) }}
							<label class="col-sm-8 text-left">
								{{ Form::checkbox('is_material_cost_counted', true, $scheme->is_client_discount_counted, ['style' => 'margin-right: 10px']) }}
								 Учитывать себестоимость материалов при расчете ЗП 
							</label>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="is_material_cost_counted" original-title="">&nbsp;</a>
							</label>
						</div>
					</div>						
					
					<hr>

					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<div class="row">
								<div class="col-md-6">
									{!! Html::linkRoute('wage_scheme.show', 'Отмена', [$scheme->scheme_id], ['class'=>'btn btn-danger btn-block']) !!}
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
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Error while processing services data range!');
				}
			});
		});
	</script>
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}