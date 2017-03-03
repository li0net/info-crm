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
			<form method="POST" action="/services/save">
				{{csrf_field()}}
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
					
				<hr>
				
				<div class="row">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
