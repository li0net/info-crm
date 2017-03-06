@extends('adminlte::layouts.app')

@section('htmlheader_title')
	@lang('main.service_category:list_page_header')
@endsection

@section('main-content')

<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
		<h4>
			@if (isset($service))
				@lang('main.service:edit_form_header')
			@else
				@lang('main.service:create_form_header')
			@endif
		</h4>
		
		<hr>
	
		<div class="well">
			<ul class="nav nav-tabs">
				<li class="active">
					<a data-toggle="tab" href="#menu1">{{ trans('adminlte_lang::message.basic_settings') }}</a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#menu2">{{ trans('adminlte_lang::message.employees') }}</a>
				</li>
				<li class="">
					<a data-toggle="tab" href="#menu3">{{ trans('adminlte_lang::message.resources') }}</a>
				</li>
			</ul>

			<div class="tab-content">
				<div id="menu1" class="tab-pane fade in active">
					{!! Form::open(['url' => '/services/save', 'id' => 'service_form__basic_settings']) !!}
						{{ Form::hidden('employee-options', null, ['id' => 'employee-options']) }}
						{{ Form::hidden('routing-options', null, ['id' => 'routing-options']) }}
						@if (isset($service))
							<input type="hidden" name="service_id" id="sc_service_id" value="{{$service->service_id}}">
						@endif
						<div class="form-group">
							<label for="s_service_category_id">@lang('main.service:service_category_label')</label>
							<select name="service_category_id" id="s_service_category_id" class="form-control">
								@foreach($serviceCategoriesOptions as $serviceCategory)
									<option
										@if (old('service_category_id') AND old('service_category_id') == $serviceCategory['value'])
											selected="selected"
										@elseif (!old('service_category_id') AND isset($service) AND $service->service_category_id == $serviceCategory['value'])
											selected="selected"
										@elseif (isset($serviceCategory['selected']) AND $serviceCategory['selected'] == true)
											selected="selected"
										@endif
									value="{{$serviceCategory['value']}}">{{$serviceCategory['label']}}</option>
								@endforeach
							</select>
							@foreach ($errors->get('service_category_id') as $message)
								<br/>{{$message}}
							@endforeach
						</div>
						<div class="form-group">
							<label for="s_name">@lang('main.service:name_label')</label>
							<?php
								$old = old('name');
								if (!is_null($old)) {
									$value = $old;
								} elseif (isset($service)) {
									$value = $service->name;
								} else {
									$value = '';
							}?>
							<input type="text" name="name" id="s_name" class="form-control" value="{{$value}}">
							@foreach ($errors->get('name') as $message)
								<?='<br/>'?>{{$message}}
							@endforeach
						</div>
						<div class="form-group">
							<label for="s_price_min">@lang('main.service:price_min_label')</label>
							<?php
								$old = old('price_min');
								if (!is_null($old)) {
									$value = $old;
								} elseif (isset($service)) {
									$value = $service->price_min;
								} else {
									$value = '';
							}?>
							<input type="text" name="price_min" id="s_price_min" class="form-control" value="{{$value}}">
							@foreach ($errors->get('price_min') as $message)
								<?='<br/>'?>{{$message}}
							@endforeach
						</div>
						<div class="form-group">
							<label for="s_price_max">@lang('main.service:price_max_label')</label>
							<?php
								$old = old('price_max');
								if (!is_null($old)) {
									$value = $old;
								} elseif (isset($service)) {
									$value = $service->price_max;
								} else {
									$value = '';
							}?>
							<input type="text" name="price_max" id="s_price_max" class="form-control" value="{{$value}}">
							@foreach ($errors->get('price_max') as $message)
								<?='<br/>'?>{{$message}}
							@endforeach
						</div>
						<div class="form-group">
							<label for="s_duration">@lang('main.service:duration_label')</label>
							<select name="duration" id="s_duration" class="form-control">
								@foreach($durationOptions as $duration)
									<option
										@if (old('duration') AND old('duration') == $duration['value'])
											selected="selected"
										@elseif (!old('duration') AND isset($service) AND $service->duration == $duration['value'])
											selected="selected"
										@elseif (isset($duration['selected']) AND $duration['selected'] == true)
											selected="selected"
										@endif
									value="{{$duration['value']}}">{{$duration['label']}}</option>
								@endforeach
							</select>
							@foreach ($errors->get('duration') as $message)
								<?='<br/>'?>{{$message}}
							@endforeach
						</div>

						<div class="form-group">
							<label for="s_description">@lang('main.service:description_label')</label>
							<?php
								$old = old('description');
								if (!is_null($old)) {
									$value = $old;
								} elseif (isset($service)) {
									$value = $service->description;
								} else {
									$value = '';
							}?>
							<textarea name="description" id="s_description" class="form-control" rows=5>{{$value}}</textarea>
							@foreach ($errors->get('description') as $message)
								<?='<br/>'?>{{$message}}
							@endforeach
						</div>
							
						{{-- <hr>
						
						<div class="row">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
							</div>
						</div> --}}
					{!! Form::close() !!}
				</div>
				<div id="menu2" class="tab-pane fade">
					{{-- <h4>{{ trans('adminlte_lang::message.section_under_construction') }}</h4> --}}
					{!! Form::open(['url' => '#', 'id' => 'service_form__employees']) !!}
						<div class="row m-t">
							{{ Form::label('employee', trans('adminlte_lang::message.employee'), ['class' => 'col-sm-3 text-left small']) }}
							{{ Form::label('duration', trans('adminlte_lang::message.duration'), ['class' => 'col-sm-4 text-left small']) }}
							{{ Form::label('routing', trans('adminlte_lang::message.routing'), ['class' => 'col-sm-3 text-center small']) }}	
						</div>
						<div class="row">
							<div class="col-sm-12"><hr></div>
						</div>
						<div class="employee-content m-b">
							<div class="row">
								<div class="col-sm-3">
									{{ Form::select(
										'service-employee', 
										[], //$service_employees, 
										null, //$service_employee, 
										['class' => 'form-control', 'required' => '']) 
									}}
								</div>
								<div class="col-sm-2">
									{{ Form::select(
										'service-duration-hour', 
										$service_duration_hours, 
										null, //$service_duration_hour, 
										['class' => 'form-control', 'required' => '']) 
									}}
								</div>
								<div class="col-sm-2">
									{{ Form::select(
										'service-duration-minute', 
										$service_duration_minutes, 
										null, //$service_duration_minute, 
										['class' => 'form-control', 'required' => '']) 
									}}
								</div>
								<div class="col-sm-3">
									{{ Form::select(
										'service-routing', 
										[], //$service_routings, 
										null, //$service_routing, 
										['class' => 'form-control', 'required' => '']) 
									}}
								</div>
								<div class="col-sm-2">
									<button type="button" id="delete-employee" class="btn btn-sm btn-white center-block">
										<i class="fa fa-trash-o"></i>
									</button>
								</div>
							</div>
						</div>
						<input type="button" id="add-employee" class="btn btn-sm btn-success" value="Добавить сотрудника">
					{!! Form::close() !!}
				</div>
				<div id="menu3" class="tab-pane fade">
					<h4>{{ trans('adminlte_lang::message.section_under_construction') }}</h4>
					<hr>
					{!! Form::open(['url' => '#', 'id' => 'service_form__resources']) !!}
				</div>

				<hr>
						
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="row">
							<div class="col-sm-6">
								{!! Html::linkRoute('employee.update', trans('adminlte_lang::message.cancel'), null, ['class'=>'btn btn-danger btn-block']) !!}
							</div>
							<div class="col-sm-6">
								{{ Form::button(trans('adminlte_lang::message.save'), ['class'=>'btn btn-success btn-block', 'id' => 'form_submit']) }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('page-specific-scripts')
	<script>
		$(document).ready(function(){
			$('#add-employee').on('click', function(e){
				$('.employee-content').prepend('<div class="row"><div class="col-sm-3"><select required="required" name="service-employee" class="form-control"></select></div> <div class="col-sm-2"><select required="required" name="service-duration-hour" class="form-control"><option value="0">0 ч</option><option value="1">1 ч</option><option value="2">2 ч</option><option value="3">3 ч</option><option value="4">4 ч</option><option value="5">5 ч</option><option value="6">6 ч</option><option value="7">7 ч</option><option value="8">8 ч</option><option value="9">9 ч</option></select></div> <div class="col-sm-2"><select required="required" name="service-duration-minute" class="form-control"><option value="00">00 мин</option><option value="15">15 мин</option><option value="30">30 мин</option><option value="45">45 мин</option></select></div> <div class="col-sm-3"><select required="required" name="service-routing" class="form-control"></select></div> <div class="col-sm-2"><button type="button" id="delete-employee" class="btn btn-sm btn-white center-block"><i class="fa fa-trash-o"></i></button></div></div>');

					sel = $('.employee-content').children('.row').first().children('.col-sm-3').children('select[name="service-employee"]').first();
					sel.html($('#employee-options').val());

					sel = $('.employee-content').children('.row').first().children('.col-sm-3').children('select[name="service-routing"]').first();
					sel.html($('#routing-options').val());
			});

			$('.employee-content').on('click', '#delete-employee', function(e){
				$(this).parent().parent().remove();
			});

			$('#form_submit').on('click', function() {
				var activeTab = $('ul.nav.nav-tabs li.active a').attr('href');

				if(activeTab == '#menu1') {
					$('#service_form__basic_settings').submit();
				}

				if(activeTab == '#menu2') {
					$('#service_form__employees').submit();
				}
				
				if(activeTab == '#menu3') {
					$('#service_form__resources').submit();
				}
			});

			$.ajax({
				type: "GET",
				dataType: 'json',
				url: '/service/employeeOptions',
				data: {},
				success: function(data) {
					//$('select[name="service-employee"]').html('');
					//$('select[name="service-employee"]').html(data.options);
					$('select[name="service-employee"]').html('');
					$('select[name="service-employee"]').html(data.options);

					$('#employee-options').val(data.options);
					// $('select.form-control[name="products_cats_detailed[]"]').find('option').remove();
					// $('select.form-control[name="products_cats_detailed[]"]').append(options);

					// $('select.form-control[name="products_cats_detailed[]"]').each(function() {
					// 	var initialValue = $(this).attr('data-initial-value');
						
					// 	if ( 0 != initialValue ) {
					// 		$(this).val(initialValue);
					// 	} else {
					// 		$(this).val($(this).find('option').first().val());
					// 	}
					// });
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Error while processing products data range!');
				}
			});

			$.ajax({
				type: "GET",
				dataType: 'json',
				url: '/service/routingOptions',
				data: {},
				success: function(data) {
					$('select[name="service-routing"]').html('');
					$('select[name="service-routing"]').html(data.options);

					$('#routing-options').val(data.options);
					// $('select.form-control[name="products_cats_detailed[]"]').find('option').remove();
					// $('select.form-control[name="products_cats_detailed[]"]').append(options);

					// $('select.form-control[name="products_cats_detailed[]"]').each(function() {
					// 	var initialValue = $(this).attr('data-initial-value');
						
					// 	if ( 0 != initialValue ) {
					// 		$(this).val(initialValue);
					// 	} else {
					// 		$(this).val($(this).find('option').first().val());
					// 	}
					// });
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Error while processing products data range!');
				}
			});
		});
	</script>
@endsection
