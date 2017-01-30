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
								<span class="badge label-danger" v-model="detailed_services_count">@{{ detailed_services_count }}</span>
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
								<span id="jopa" class="badge label-danger" v-model="detailed_products_count">@{{ detailed_products_count }}</span>
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
			$('#detailed-services').on('click', '#add-detailed-section', function(e) {
				if($(e.target).val() !== 'Удалить') {
					$('#detailed-services').prepend(
						'<div class="wrap-it"><div class="col-sm-2"></div>' +						
						'<div class="col-sm-8" style="padding: 0px;"><div class="col-sm-4"><select required="required" maxlength="110" name="services_cats_detailed[]" class="form-control"><option value="0" selected="selected">Стрижки</option><option value="1">Укладки</option></select></div> <div class="col-sm-4"><select required="required" maxlength="110" name="services_detailed[]" class="form-control"><option value="0" selected="selected">Полубокс</option><option value="1">Модельная</option></select></div> <div class="col-sm-2"><input required="required" maxlength="110" name="services_percent_detailed[]" type="text" class="form-control"></div> <div class="col-sm-2"><select required="required" maxlength="110" name="services_unit_detailed[]" class="form-control"><option value="rub" selected="selected">₽</option><option value="pct">%</option></select></div></div>' +
						'<div class="col-sm-2" style="margin-bottom: 15px"><input type="button" id="add-detailed-section" value="Добавить" class="btn btn-info"></div></div>');
					app.detailed_services_count++;
					$('a[href="#detailed-services"] .badge.label-danger').removeClass('hidden');
					$(e.target).val('Удалить');
					$(e.target).toggleClass('btn-info btn-danger')
					$(e.target).off();
					$(e.target).on('click', function(e) {
						$(e.target).parent().parent().remove();
						app.detailed_services_count--;
						if(app.detailed_services_count == 0) {
							$('a[href="#detailed-services"] .badge.label-danger').addClass('hidden');
						}
					});
				} else {
					$(e.target).parent().parent().remove();
					app.detailed_services_count--;
					if(app.detailed_services_count == 0) {
						$('a[href="#detailed-services"] .badge.label-danger').addClass('hidden');
					}
				}
			});

			$('#detailed-services').on('shown.bs.collapse', function(){
				$('a[href="#detailed-services"] .fa.fa-caret-down').toggleClass('fa-caret-down fa-caret-up');
			});

			$('#detailed-services').on('hidden.bs.collapse', function(){
				$('a[href="#detailed-services"] .fa.fa-caret-up').toggleClass('fa-caret-up fa-caret-down');
			});

			$('#detailed-products').on('click', '#add-detailed-section', function(e) {
				if($(e.target).val() !== 'Удалить') {
					$('#detailed-products').prepend(
						'<div class="wrap-it"><div class="col-sm-2"></div>' +						
						'<div class="col-sm-8" style="padding: 0px;"><div class="col-sm-4"><select required="required" maxlength="110" name="products_cats_detailed[]" class="form-control"><option value="0" selected="selected">Лаки</option><option value="1">Краски</option></select></div> <div class="col-sm-4"><select required="required" maxlength="110" name="products_detailed[]" class="form-control"><option value="0" selected="selected">LONDA</option><option value="1">WELLA</option></select></div> <div class="col-sm-2"><input required="required" maxlength="110" name="products_percent_detailed[]" type="text" class="form-control"></div> <div class="col-sm-2"><select required="required" maxlength="110" name="products_unit_detailed[]" class="form-control"><option value="rub" selected="selected">₽</option><option value="pct">%</option></select></div></div>' +
						'<div class="col-sm-2" style="margin-bottom: 15px"><input type="button" id="add-detailed-section" value="Добавить" class="btn btn-info"></div></div>');
					
					$('select.form-control[name="products_cats_detailed[]"]').first().find('option').remove();
					$('select.form-control[name="products_cats_detailed[]"]').first().append(app.services_ctgs_options);
					
					app.detailed_products_count++;
					
					$('a[href="#detailed-products"] .badge.label-danger').removeClass('hidden');
					$(e.target).val('Удалить');
					$(e.target).toggleClass('btn-info btn-danger')
					$(e.target).off();
					$(e.target).on('click', function(e) {
						$(e.target).parent().parent().remove();
						app.detailed_products_count--;
						if(app.detailed_products_count == 0) {
							$('a[href="#detailed-products"] .badge.label-danger').addClass('hidden');
						}
					});
				} else {
					$(e.target).parent().parent().remove();
					app.detailed_products_count--;
					if(app.detailed_products_count == 0) {
						$('a[href="#detailed-products"] .badge.label-danger').addClass('hidden');
					}
				}
			});

			$('#detailed-products').on('shown.bs.collapse', function(){
				$('a[href="#detailed-products"] .fa.fa-caret-down').toggleClass('fa-caret-down fa-caret-up');
			});

			$('#detailed-products').on('hidden.bs.collapse', function(){
				$('a[href="#detailed-products"] .fa.fa-caret-up').toggleClass('fa-caret-up fa-caret-down');
			});

			$.ajax({
				type: "GET",
				dataType: 'json',
				url: '/serviceCategories/gridData',
				data: {},
				success: function(data) {
					for (var i = 0; i < data.rows.length; i++) {
						app.services_ctgs_options = app.services_ctgs_options + '<option value=' + data.rows[i].service_category_id + '>' + data.rows[i].name + '</option>';
					}

					$('select.form-control[name="products_cats_detailed[]"]').find('option').remove();
					$('select.form-control[name="products_cats_detailed[]"]').append(app.services_ctgs_options);

					console.log(app.services_ctgs_options);
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