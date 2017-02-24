@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_edit') }}
@endsection

@section('main-content')
	<div class="row">
		{{-- {!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', "class" => "hidden", "id" => "form228"]) !!} --}}
			<div class="col-sm-8 col-sm-offset-2">
				<div class="well">
					<ul class="nav nav-tabs">
						<li class="active">
							<a data-toggle="tab" href="#menu1">{{ trans('adminlte_lang::message.information') }}</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#menu2">{{ trans('adminlte_lang::message.services') }}</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#menu3">{{ trans('adminlte_lang::message.schedule') }}</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#menu4">{{ trans('adminlte_lang::message.employee_settings') }}</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#menu5">{{ trans('adminlte_lang::message.payroll_calc') }}</a>
						</li>
					</ul>
				
					<div class="tab-content">
						<div id="menu1" class="tab-pane fade in active">
							<h4>{{ trans('adminlte_lang::message.employee_information') }}</h4>
							<hr>
							<div class="row">
								{!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', 'class' => 'hidden', 'id' => 'employee_form__info', 'files' => 'true']) !!}
									{!! Form::hidden('id', 'employee_form__info') !!}
									<div class="col-sm-8 b-r">
										<div class="form-group">
											{{ Form::label('name',trans('adminlte_lang::message.employee_name'), ['class' => 'ctrl-label']) }}
											{{ Form::text('name', null, ['class' => 'text-left form-control', 'placeholder' => trans('adminlte_lang::message.name_example')]) }}
										</div>

										<div class="form-group">
											{{ Form::label('position_id', trans('adminlte_lang::message.employee_position'), ['class' => 'ctrl-label']) }}
											{{ Form::select('position_id', $items, $employee->position_id, ['class' => 'form-control', 'required' => '']) }}
										</div>

										<div class="form-group">
											{{ Form::label('spec', trans('adminlte_lang::message.employee_specialization'), ['class' => 'ctrl-label']) }}
											{{ Form::text('spec', null, ['class' => 'form-control', 'placeholder' => trans('adminlte_lang::message.specialization_example')]) }}
										</div>

										<div class="form-group">
											{{ Form::label('descr', trans('adminlte_lang::message.description'), ['class' => 'ctrl-label']) }}
											{{ Form::textarea('descr', null, ['class' => 'form-control']) }}
										</div>
									</div>

									<div class="col-sm-4 text-center">
										<label class="ctrl-label">{{ trans('adminlte_lang::message.photo') }}</label>
										<div class="logo-block">
											<div v-if="!image">
												@if( $employee->avatar_image_name != null)
													<img src="/images/{{ $employee->avatar_image_name }}" />
												@else
													<img src="/images/no-master.png" alt="">
												@endif													
											</div>
											<div v-else>
												<img :src="image" />
											</div>
										</div>
										<span class="btn btn-success btn-file">
											{{ trans('adminlte_lang::message.load_photo') }}<input type="file" name="avatar" @change="onFileChange">
										</span>
									</div>
								{!! Form::close() !!}
							</div>
						</div>

						<div id="menu2" class="tab-pane fade">
							<h4>{{ trans('adminlte_lang::message.services_information') }}</h4>
							<hr>
							{!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', "id" => "employee_form__services"]) !!}
							{!! Form::close() !!}
						</div>
						
						<div id="menu3" class="tab-pane fade">
							<h4>{{ trans('adminlte_lang::message.schedule') }}</h4>
							<hr>
							{!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', "id" => "employee_form__schedule"]) !!}
							{!! Form::close() !!}
						</div>

						<div id="menu4" class="tab-pane fade form-horizontal">
							{!! Form::model($settings[0], ['route' => ['employee.update', $employee->employee_id], "method" => 'PUT', "id" => "employee_form__settings"]) !!}
								{!! Form::hidden('id', 'employee_form__settings') !!}
								<h4>{{ trans('adminlte_lang::message.notifications') }}</h4>
								<br>
								<div class="form-group">
									{{ Form::label('online_reg_notify', trans('adminlte_lang::message.online_records'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<label class="col-sm-7 text-left">
										{{ Form::checkbox('online_reg_notify', 1, $settings[0]->online_reg_notify, ['style' => 'margin-right: 10px']) }}
										 {{ trans('adminlte_lang::message.send_notes_online_records') }} 
									</label>
									<label class="col-sm-1 text-left">
										<a class="fa fa-info-circle" id="'online_reg_notify" original-title="">&nbsp;</a>
									</label>
								</div>

								<div class="form-group">
									{{ Form::label('phone_reg_notify', trans('adminlte_lang::message.records_by_phone'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<label class="col-sm-7 text-left">
										{{ Form::checkbox('phone_reg_notify', 1, $settings[0]->phone_reg_notify, ['style' => 'margin-right: 10px']) }}
										{{ trans('adminlte_lang::message.send_notes_phone_records') }} 
									</label>
									<label class="col-sm-1 text-left">
										<a class="fa fa-info-circle" id="phone_reg_notify" original-title="">&nbsp;</a>
									</label>
								</div>
								
								<div class="form-group">
									{{ Form::label('online_reg_notify_del', trans('adminlte_lang::message.online_record_removal'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<label class="col-sm-7 text-left">
										{{ Form::checkbox('online_reg_notify_del', 1, $settings[0]->online_reg_notify_del, ['style' => 'margin-right: 10px']) }}
										{{ trans('adminlte_lang::message.send_online_record_removal') }}
									</label>
									<label class="col-sm-1 text-left">
										<a class="fa fa-info-circle" id="online_reg_notify_del" original-title="">&nbsp;</a>
									</label>
								</div>

								<div class="form-group">
									{{ Form::label('phone_for_notify', trans('adminlte_lang::message.phone_num_to_notify'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<div class="col-sm-7">
										{{ Form::text('phone_for_notify', null, ['class' => 'text-left form-control', 
																				 'placeholder' => trans('adminlte_lang::message.example').'+7 495 123 45 67']) }}
									</div>
									<label class="col-sm-1 text-left">
										<a class="fa fa-info-circle" id="phone_for_notify" original-title="">&nbsp;</a>
									</label>
								</div>

								<div class="form-group">
									{{ Form::label('email_for_notify', trans('adminlte_lang::message.email_to_notify'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<div class="col-sm-7">
										{{ Form::text('email_for_notify', null, ['class' => 'text-left form-control',
																				 'placeholder' => trans('adminlte_lang::message.example').'info@mail.com']) }}
									</div>
									<label class="col-sm-1 text-left">
										<a class="fa fa-info-circle" id="email_for_notify" original-title="">&nbsp;</a>
									</label>
								</div>

								<div class="form-group">
									{{ Form::label('client_data_notify', trans('adminlte_lang::message.data_of_clients'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<label class="col-sm-7 text-left">
										{{ Form::checkbox('client_data_notify', 1, $settings[0]->client_data_notify, ['style' => 'margin-right: 10px']) }}
										{{ trans('adminlte_lang::message.send_data_of_clients') }} 
									</label>
									<label class="col-sm-1 text-left">
										<a class="fa fa-info-circle" id="client_data_notify" original-title="">&nbsp;</a>
									</label>
								</div>

								<hr>
								
								<h4>{{ trans('adminlte_lang::message.record') }}</h4>

								<div class="form-group">
									{{ Form::label('reg_permitted', trans('adminlte_lang::message.online_record'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<div class="col-sm-7 text-left">
										<label style="width: 100%">
											{{ Form::radio('reg_permitted', 1, $settings[0]->reg_permitted ? true : false, ['style' => 'margin-right: 10px']) }}
											{{ trans('adminlte_lang::message.resolve_online_record') }}
										</label>
										<label>
											{{ Form::radio('reg_permitted', 0, $settings[0]->reg_permitted ? true : false, ['style' => 'margin-right: 10px']) }}
											{{ trans('adminlte_lang::message.forbid_online_record') }}
										</label>
									</div>
									<label class="col-sm-1 text-left">
										<a class="fa fa-info-circle" id="reg_permitted" original-title="">&nbsp;</a>
									</label>
								</div>

								<div class="form-group">
									{{ Form::label('reg_permitted_nomaster', trans('adminlte_lang::message.admittance_of_choice'), 
																			 ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<div class="col-sm-7 text-left">
										<label style="width: 100%">
											{{ Form::radio('reg_permitted_nomaster', 1, $settings[0]->reg_permitted_nomaster ? true : false, 
															['style' => 'margin-right: 10px']) }}
											{{ trans('adminlte_lang::message.resolve_master_not_important') }}
										</label>
										<label>
											{{ Form::radio('reg_permitted_nomaster', 0, $settings[0]->reg_permitted_nomaster ? true : false, 
															['style' => 'margin-right: 10px']) }}
											{{ trans('adminlte_lang::message.forbid_master_not_important') }}
										</label>
									</div>
								</div>

								<div class="form-group">
									{{ Form::label('session_start', trans('adminlte_lang::message.widget_time_available'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<div class="col-sm-7 text-left">
										<div class="row">
											<div class="col-sm-6">
												{{ Form::select('session_start', $sessionStart, null, ['class' => 'form-control']) }}
											</div>
											<div class="col-sm-6">
												{{ Form::select('session_end', $sessionEnd, null, ['class' => 'form-control']) }}
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									{{ Form::label('add_interval', trans('adminlte_lang::message.additional_markup'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<div class="col-sm-7 text-left">
										<div class="row">
											<div class="col-sm-6">
												{{ Form::select('add_interval', $addInterval, null, ['class' => 'form-control']) }}
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									{{ Form::label('show_rating', trans('adminlte_lang::message.rating'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<label class="col-sm-7 text-left">
										{{ Form::checkbox('show_rating', 1, $settings[0]->show_rating, ['style' => 'margin-right: 10px']) }}
										{{ trans('adminlte_lang::message.show_rating') }}
									</label>
								</div>
								
								{{-- <div class="form-group">
									{{ Form::label('is_in_occupancy', 'Журнал записи', ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<label class="col-sm-7 text-left">
										{{ Form::checkbox('is_in_occupancy', 1, false, ['style' => 'margin-right: 10px']) }}
										 Не отображать в журнале записи
									</label>
								</div> --}}

								<hr>
								
								<h4>{{ trans('adminlte_lang::message.statistics') }}</h4>

								<div class="form-group">
									{{ Form::label('is_rejected', trans('adminlte_lang::message.status'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<label class="col-sm-7 text-left">
										{{ Form::checkbox('is_rejected', 1, $settings[0]->is_rejected, ['style' => 'margin-right: 10px']) }}
										{{ trans('adminlte_lang::message.dissmissed') }}
									</label>
									<label class="col-sm-1 text-left">
										<a class="fa fa-info-circle" id="is_rejected" original-title="">&nbsp;</a>
									</label>
								</div>

								<div class="form-group">
									{{ Form::label('is_in_occupancy', trans('adminlte_lang::message.consider'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<label class="col-sm-7 text-left">
										{{ Form::checkbox('is_in_occupancy', 1, $settings[0]->is_in_occupancy, ['style' => 'margin-right: 10px']) }}
										{{ trans('adminlte_lang::message.employee_is_considered') }}
									</label>
								</div>

								<div class="form-group">
									{{ Form::label('revenue_pctg', trans('adminlte_lang::message.percent_from_revenue'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<div class="col-sm-7 input-group">
										{{ Form::text('revenue_pctg', null, ['class' => 'text-left form-control', 
																			 'placeholder' => trans('adminlte_lang::message.use_for_payroll_calc')]) }}
										<span class="input-group-addon">%</span>
									</div>
								</div>

								<hr>
								
								<h4>{{ trans('adminlte_lang::message.integration') }}</h4>
									<div class="form-group">
										{{ Form::label('sync_with_google', trans('adminlte_lang::message.sync_with_google'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
										<label class="col-sm-7 text-left">
											{{ Form::checkbox('sync_with_google', 1, $settings[0]->sync_with_google, ['style' => 'margin-right: 10px']) }}
											{{ trans('adminlte_lang::message.upload_into_google') }}
										</label>
									</div>

									<div class="form-group">
										{{ Form::label('sync_with_1c', trans('adminlte_lang::message.sync_with_1C'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
										<label class="col-sm-7 text-left">
											{{ Form::checkbox('sync_with_1c', 1, $settings[0]->sync_with_1c, ['style' => 'margin-right: 10px']) }}
											{{ trans('adminlte_lang::message.upload_into_1C') }}
										</label>
									</div>
								<br>
							{!! Form::close() !!}
						</div>
						<div id="menu5" class="tab-pane fade">
							<h4>{{ trans('adminlte_lang::message.payroll_calc') }}</h4>
							<hr>
							{!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', "id" => "employee_form__wage"]) !!}
							{!! Form::close() !!}
						</div>

						<hr>
						
						<div class="row">
							<div class="col-sm-6 col-sm-offset-3">
								<div class="row">
									<div class="col-sm-6">
										{!! Html::linkRoute('employee.show', trans('adminlte_lang::message.cancel'), [$employee->employee_id], ['class'=>'btn btn-danger btn-block']) !!}
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
		{{-- {!! Form::close() !!} --}}
	</div>
@stop