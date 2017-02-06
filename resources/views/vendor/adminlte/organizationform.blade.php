@extends('adminlte::layouts.app')

@section('htmlheader_title')
	@lang('main.organization:form_page_header')
@endsection


@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						@lang('main.organization:edit_form_header')
					</div>
					<div class="panel-body">
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif
						<form method="post" action="/organization/save" enctype="multipart/form-data" class="form-horizontal">
							{{csrf_field()}}
							<div class="form-group">
								<label class="col-sm-2 control-label" for="o_name">@lang('main.organization:name_label')</label>
								<div class="col-sm-10">
									<?php
									$old = old('name');
									if (!is_null($old)) {
										$value = $old;
									} elseif (isset($organization)) {
										$value = $organization->name;
									} else {
										$value = '';
									}?>
									<input type="text" name="name" id="o_name" value="{{$value}}" class="form-control">
									@foreach ($errors->get('name') as $message)
									<?='<br/>'?>{{$message}}
									@endforeach
								</div>
							</div>
							<!-- business area here -->
							<div class="form-group">
								<label for="o_category"class="col-sm-2 control-label">@lang('main.organization:category_label')</label>
								<div class="col-sm-10">
									<?php
									$old = old('name');
									if (!is_null($old)) {
										$value = $old;
									} elseif (isset($organization)) {
										$value = $organization->category;
									} else {
										$value = '';
									}?>
									<input type="text" name="category" id="o_category" value="{{$value}}" class="form-control">
									@foreach ($errors->get('category') as $message)
									<?='<br/>'?>{{$message}}
									@endforeach
								</div>
							</div>
							<div class="form-group">
								<label for="o_timezone" class="col-sm-2 control-label">@lang('main.organization:timezone_label')</label>
								<div class="col-sm-10">
									<select name="timezone" id="o_timezone" class="form-control">
										@foreach($timezonesOptions AS $timezone)
										<option
												@if (old('timezone') AND old('timezone') == $timezone['value'])
										selected="selected"
										@elseif (!old('timezone') AND isset($organization) AND $organization->timezone == $timezone['value'])
										selected="selected"
										@elseif (!old('timezone') AND !isset($organization) AND isset($timezone['selected']) AND $timezone['selected'] == true)
										selected="selected"
										@endif
										value="{{$timezone['value']}}">{{$timezone['label']}}</option>
										@endforeach
									</select>
									@foreach ($errors->get('timezone') as $message)
									<br/>{{$message}}
									@endforeach
								</div>
							</div>
							<div class="form-group">
								<label for="o_country" class="col-sm-2 control-label">@lang('main.organization:country_label')</label>
								<div class="col-sm-10">
									<?php
									$old = old('country');
									if (!is_null($old)) {
										$value = $old;
									} elseif (isset($organization)) {
										$value = $organization->country;
									} else {
										$value = '';
									}?>
									<input type="text" name="country" id="o_country" value="{{$value}}" class="form-control">
									@foreach ($errors->get('country') as $message)
									<?='<br/>'?>{{$message}}
									@endforeach
								</div>
							</div>
							<div class="form-group">
								<label for="o_city" class="col-sm-2 control-label">@lang('main.organization:city_label')</label>
								<div class="col-sm-10">
									<?php
									$old = old('city');
									if (!is_null($old)) {
										$value = $old;
									} elseif (isset($organization)) {
										$value = $organization->city;
									} else {
										$value = '';
									}?>
									<input type="text" name="city" id="o_city" value="{{$value}}" class="form-control">
									@foreach ($errors->get('city') as $message)
									<?='<br/>'?>{{$message}}
									@endforeach
								</div>
							</div>
							<div class="form-group">
								<label for="o_logo_image" class="col-sm-2 control-label">@lang('main.organization:logo_label')</label>
                                <div class="col-sm-2 text-left">
                                    <img src="{{$organization->getLogoUri()}}" class="img-thumbnail">
                                </div>
                                <div class="col-sm-8">
									<input type="file" name="logo_image" id="o_logo_image" accept=".jpg,.jpeg,.png,.bmp,.gif" class="">
									@foreach ($errors->get('logo_image') as $message)
										<?='<br/>'?>{{$message}}
									@endforeach
								</div>

							</div>
							<div class="form-group">
								<label for="o_info" class="col-sm-2 control-label">@lang('main.organization:info_label')</label>
								<div class="col-sm-10">
									<?php
									$old = old('info');
									if (!is_null($old)) {
										$value = $old;
									} elseif (isset($organization)) {
										$value = $organization->info;
									} else {
										$value = '';
									}?>
									<textarea name="info" id="o_info" class="form-control">{{$value}}</textarea>
									@foreach ($errors->get('info') as $message)
									<?='<br/>'?>{{$message}}
									@endforeach
								</div>
							</div>
							<hr/>
							<div class="form-group">
								<button type="submit" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
@endsection
