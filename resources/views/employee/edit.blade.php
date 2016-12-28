@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_edit') }}
@endsection

@section('main-content')
	<div class="row">
		{!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', "class" => "form-horizontal"]) !!}
			<div class="col-md-8 col-md-offset-2">
				<div class="well">
					<ul class="nav nav-tabs">
						<li class="active">
							<a data-toggle="tab" href="#menu1">Информация</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#menu2">Услуги</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#menu3">Расписание</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#menu4">Настройки</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#menu5">Расчет ЗП</a>
						</li>
					</ul>
				
					<div class="tab-content">
						<div id="menu1" class="tab-pane fade in active" style="margin-bottom: 15px">
							{{-- {{ Form::label('employee_id', 'Сотрудник:') }}
							<p class="lead">#{{ $employee->employee_id }}</p> --}}
							<div class="form-group">
								{{ Form::label('name', 'Имя:', ['class' => 'form-spacing-top form-label']) }}
								{{ Form::text('name', null, ['class' => 'form-control']) }}
							</div>

							<div class="form-group">
								{{ Form::label('position_id', 'Должность:', ['class' => 'form-spacing-top form-label']) }}
								{{ Form::select('position_id', [1 => 'Парикмахер', 2 => 'Мастер манюкюра', 3 => 'Визажист'], $employee->position_id, ['class' => 'form-control', 'required' => '']) }}
							</div>							

							<div class="form-group">
								{{ Form::label('spec', "Специализация: ", ['class' => 'form-spacing-top']) }}
								{{ Form::text('spec', null, ['class' => 'form-control']) }}
							</div>
	
							<div class="form-group">
								{{ Form::label('descr', "Описание: ", ['class' => 'form-spacing-top']) }}
								{{ Form::textarea('descr', null, ['class' => 'form-control']) }}
							</div>
						</div>

						<div id="menu2" class="form-group tab-pane fade">

						</div>
						
						<div id="menu3" class="form-group tab-pane fade">

						</div>

						<div id="menu4" class="tab-pane fade">
							<h4>Уведомления</h4>
							<br>
							<div class="form-group">
								{{ Form::label('online_reg_notify', 'Онлайн-записи', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<label class="col-sm-7 text-left">
									{{ Form::checkbox('online_reg_notify', 1, false, ['style' => 'margin-right: 10px']) }}
									 Отправлять уведомления об онлайн записях 
								</label>
							</div>

							<div class="form-group">
								{{ Form::label('phone_reg_notify', 'Записи по телефону', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<label class="col-sm-7 text-left">
									{{ Form::checkbox('phone_reg_notify', 1, false, ['style' => 'margin-right: 10px']) }}
									 Отправлять уведомления о записях по телефону 
								</label>
							</div>

							
							<div class="form-group">
								{{ Form::label('online_reg_notify_del', 'Удаление онлайн записи', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<label class="col-sm-7 text-left">
									{{ Form::checkbox('online_reg_notify_del', 1, false, ['style' => 'margin-right: 10px']) }}
									 Отправлять уведомления об удалении онлайн записей 
								</label>
							</div>

							<div class="form-group">
								{{ Form::label('phone_for_notify', 'Номер телефона для уведомлений', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<div class="col-sm-7">
									{{ Form::text('phone_for_notify', null, ['class' => 'text-left form-control', 'placeholder' => 'Пример: +7 495 123 45 67']) }}
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('email_for_notify', 'Email для уведомлений', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<div class="col-sm-7">
									{{ Form::text('email_for_notify', null, ['class' => 'text-left form-control', 'placeholder' => 'Пример: info@mail.com']) }}
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('client_data_notify', 'Данные клиентов', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<label class="col-sm-7 text-left">
									{{ Form::checkbox('client_data_notify', 1, false, ['style' => 'margin-right: 10px']) }}
									 Отправлять имя и номер телефона клиента 
								</label>
							</div>

							<hr>
							
							<h4>Запись</h4>

							<div class="form-group">
								{{ Form::label('reg_permitted', 'Онлайн-запись', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<div class="col-sm-7 text-left">
									<label style="width: 100%">
										{{ Form::radio('reg_permitted', 1, true, ['style' => 'margin-right: 10px']) }}
										 Разрешить онлайн-запись 
									</label>
									<label>
										{{ Form::radio('reg_permitted', 1, false, ['style' => 'margin-right: 10px']) }}
										 Запретить онлайн-запись 
									</label>
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('reg_permitted_nomaster', 'Пропуск выбора', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<div class="col-sm-7 text-left">
									<label style="width: 100%">
										{{ Form::radio('reg_permitted_nomaster', 1, true, ['style' => 'margin-right: 10px']) }}
										 Разрешить онлайн-запись при выборе опции "Мастер не важен"
									</label>
									<label>
										{{ Form::radio('reg_permitted_nomaster', 1, false, ['style' => 'margin-right: 10px']) }}
										 Запретить онлайн-запись при выборе опции "Мастер не важен"
									</label>
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('session_start', 'Время начала и окончания поиска сеансов в виджете', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<div class="col-sm-7 text-left">
									<div class="row">
										<div class="col-sm-6">
											{{ Form::select('session_start', ['0' => 'c 0:00', '1' => 'c 1:00', '2' => 'c 2:00'], '0', ['class' => 'form-control']) }}
										</div>
										<div class="col-sm-6">
											{{ Form::select('session_end', ['0' => 'до 0:00', '1' => 'до 1:00', '2' => 'до 2:00'], '0', ['class' => 'form-control']) }}
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('add_interval', 'Дополнительная разметка в журнале', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<div class="col-sm-7 text-left">
									<div class="row">
										<div class="col-sm-6">
											{{ Form::select('add_interval', ['0' => '---', '1' => '0:45', '2' => '1:00', '3' => '1:15'], '0', ['class' => 'form-control']) }}
										</div>
									</div>
								</div>
							</div>

							<div class="form-group">
								{{ Form::label('show_rating', 'Рейтинг', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<label class="col-sm-7 text-left">
									{{ Form::checkbox('show_rating', 1, false, ['style' => 'margin-right: 10px']) }}
									 Показывать рейтинг в виджете онлайн-записи 
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
							
							<h4>Статистика</h4>

							<div class="form-group">
								{{ Form::label('is_rejected', 'Статус', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<label class="col-sm-7 text-left">
									{{ Form::checkbox('is_rejected', 1, false, ['style' => 'margin-right: 10px']) }}
									 Сотрудник уволен
								</label>
							</div>

							<div class="form-group">
								{{ Form::label('is_in_occupancy', 'Учет в заполненности', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<label class="col-sm-7 text-left">
									{{ Form::checkbox('is_in_occupancy', 1, false, ['style' => 'margin-right: 10px']) }}
									 Сотрудник учитывается в заполненности
								</label>
							</div>

							<div class="form-group">
								{{ Form::label('revenue_pctg', 'Процент от выручки(%)', ['class' => 'col-sm-4 text-right ctrl-label']) }}
								<div class="col-sm-7">
									{{ Form::text('revenue_pctg', null, ['class' => 'text-left form-control', 'placeholder' => 'Используется для расчета зарплаты']) }}
								</div>
							</div>

							<hr>
							
							<h4>Интеграция</h4>
								<div class="form-group">
									{{ Form::label('sync_with_google', 'Синхронизация с Google', ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<label class="col-sm-7 text-left">
										{{ Form::checkbox('sync_with_google', 1, false, ['style' => 'margin-right: 10px']) }}
										 Выгружать данные клиентов в Google
									</label>
								</div>

								<div class="form-group">
									{{ Form::label('sync_with_1c', 'Синхронизация с 1С', ['class' => 'col-sm-4 text-right ctrl-label']) }}
									<label class="col-sm-7 text-left">
										{{ Form::checkbox('sync_with_1c', 1, false, ['style' => 'margin-right: 10px']) }}
										 Выгружать данные клиентов в 1С
									</label>
								</div>
							<br>
						</div>
						<div id="menu5" class="form-group tab-pane fade">

						</div>

						<hr>
						
						<div class="row">
							<div class="col-md-4 col-md-offset-4">
								<div class="row">
									<div class="col-md-6">
										{!! Html::linkRoute('employee.show', 'Отмена', [$employee->employee_id], ['class'=>'btn btn-danger btn-block']) !!}
									</div>
									<div class="col-md-6">
										{{ Form::submit('Сохранить', ['class'=>'btn btn-success btn-block']) }}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			{{-- <div class="col-sm-4">
				<div class="well">
					<dl class="dl-horizontal">
						<dt>Сотрудник создан:</dt>
						<dd>{{ date('d-m-Y H:i:s', strtotime($employee->created_at))}}</dd>
					</dl>

					<dl class="dl-horizontal">
						<dt>Данные сотрудника обновлены:</dt>
						<dd>{{ date('d-m-Y H:i:s', strtotime($employee->updated_at))}}</dd>
					</dl>
					
					<hr>

					<div class="row">
						<div class="col-sm-6">
							{!! Html::linkRoute('employee.show', 'Отмена', [$employee->employee_id], ['class'=>'btn btn-danger btn-block']) !!}
						</div>
						<div class="col-sm-6">
							{{ Form::submit('Сохранить', ['class'=>'btn btn-success btn-block']) }}
						</div>
					</div>
				</div>
			</div> --}}
		{!! Form::close() !!}
	</div>
@stop