@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.appointment:list_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <h4>
                    @if (isset($appointment))
                        @lang('main.appointment:edit_form_header')
                    @else
                        @lang('main.appointment:create_form_header')
                    @endif
                </h4>

                <hr>

                <div class="well">
                    <div class="row">
                        <ul class="nav nav-pills nav-justified" id="appointment_tabs_header" role="tablist">
                            <li class="active"><a href="#tab_client_wait" role="pill" data-toggle="pill"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;@lang('main.appointment:client_wait_tab_label')</a></li>
                            <li><a href="#tab_client_came" role="pill" data-toggle="pill"><i class="fa fa-plus-circle"></i>&nbsp;@lang('main.appointment:client_came_tab_label')</a></li>
                            <li><a href="#tab_client_didnt_came" role="pill" data-toggle="pill"><i class="fa fa-minus-circle" aria-hidden="true"></i>&nbsp;@lang('main.appointment:client_didnt_came_tab_label')</a></li>
                            <li><a href="#tab_client_confirm" role="pill" data-toggle="pill"><i class="fa fa-check-circle-o" aria-hidden="true"></i>&nbsp;@lang('main.appointment:client_confirm_tab_label')</a></li>
                        </ul>
                    </div>
                    <div class="row m-t">
                        {!! Form::open(['url' => '/appointments/save', 'id' => 'appointment_form']) !!}
                            @if (isset($appointment))
                                <input type="hidden" name="appointment_id" id="app_appointment_id" value="{{$appointment->appointment_id}}">
                            @endif
                            <div class="col-sm-4 b-r">
                                <ul class="modal-menu list-group clear-list m-t">
                                    <li class="modal-menu-header">Визит</li><br>
                                        <li class="modal-menu-l record_tab list-group-item fist-item act" data-target="body_record">
                                            <i class="fa fa-calendar"></i> Запись</li>
                                        <li class="modal-menu-l visit_tab list-group-item" data-target="body_status">
                                            <i class="fa fa-clock-o"></i> Статус визита</li>
                                        <li class="modal-menu-l payments_tab list-group-item" data-target="body_payments" style="display: block;">
                                            <i class="fa fa-usd"></i> Оплата визита</li>
                                        <li class="modal-menu-l reminds_tab list-group-item" data-target="body_reminds" style="display: block;">
                                            <i class="fa fa-comments-o"></i> Уведомления </li>
                                        <li class="modal-menu-l history_tab list-group-item" data-target="body_history" style="display: block;">
                                            <i class="fa fa-file-text"></i> История изменений</li>
                                        <li class="modal-menu-l goods_history_tab list-group-item" data-target="goods_history" style="display: block;">
                                            <i class="fa fa-cubes"></i> Списание расходников</li>
                                    <br>
                                    <li class="modal-menu-header client_header_tab" style="display: list-item;">Клиент</li><br>
                                        <li class="modal-menu-l client_tab list-group-item fist-item" id="rec_client_fulldata" data-target="client_edit" style="display: block;">
                                            <i class="fa fa-user"></i> Данные клиента</li>
                                        <li class="modal-menu-l visit_history_tab list-group-item" data-target="visit_history" style="display: block;">
                                            <i class="fa fa-list-alt"></i> История посещений</li>
                                        <li class="modal-menu-l client_stats_tab list-group-item" data-target="client_stats" style="display: block;">
                                            <i class="fa fa-pie-chart"></i> Статистика</li>
                                        <li class="modal-menu-l sms_history_tab list-group-item" data-target="sms_history" style="display: block;">
                                            <i class="fa fa-envelope"></i> Отправленные SMS</li>
                                        <li class="modal-menu-l sms_tab list-group-item" data-target="body_sms" style="display: block;">
                                            <i class="fa fa-send"></i> Отправить SMS</li>
                                        <li class="modal-menu-l card_tab list-group-item" data-target="body_card" style="display: block;">
                                            <i class="fa fa-qrcode"></i> Электронная карта</li>
                                        <li class="modal-menu-l client_loyalty_cards_tab list-group-item" data-target="client_loyalty_cards_body"  style="display: block;"><i class="fa fa-credit-card">
                                            </i> Карты лояльности</li>
                                        <li class="modal-menu-l phone_call_tabs list-group-item" data-target="phone_call_body" style="display: block;"><i class="fa fa-phone">
                                            </i> История звонков</li>
                                </ul>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="app_client_name">@lang('main.appointment:client_name_label')</label>
                                    <?php
                                        $old = old('client_name');
                                        if (!is_null($old)) {
                                            $value = $old;
                                        } elseif (isset($appointment)) {
                                            $value = $appointment->client->name;
                                        } else {
                                            $value = '';
                                    }?>
                                    <input type="text" name="client_name" id="app_client_name" class = "form-control" value="{{$value}}">
                                    <div id="client_name_error">
                                        @foreach ($errors->get('client_name') as $message)
                                            <br/>{{$message}}
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="app_client_phone">@lang('main.appointment:client_phone_label')</label>
                                    <?php
                                        $old = old('client_phone');
                                        if (!is_null($old)) {
                                            $value = $old;
                                        } elseif (isset($appointment)) {
                                            $value = $appointment->client->phone;
                                        } else {
                                            $value = '';
                                    }?>
                                    <input type="text" name="client_phone" id="app_client_phone" class = "form-control" value="{{$value}}">
                                    <div id="client_phone_error">
                                        @foreach ($errors->get('client_phone') as $message)
                                            <br/>{{$message}}
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="app_client_email">@lang('main.appointment:client_email_label')</label>
                                    <?php
                                        $old = old('client_email');
                                        if (!is_null($old)) {
                                            $value = $old;
                                        } elseif (isset($appointment)) {
                                            $value = $appointment->client->email;
                                        } else {
                                            $value = '';
                                    }?>
                                    <input type="text" name="client_email" id="app_client_email" class = "form-control" value="{{$value}}">
                                    <div id="client_email_error">
                                        @foreach ($errors->get('client_email') as $message)
                                            <br/>{{$message}}
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="app_service_id">@lang('main.appointment:service_id_label')</label>
                                    <select name="service_id" id="app_service_id" class = "form-control">
                                        @foreach($servicesOptions as $service)
                                            <option
                                                @if (old('service_id') AND old('service_id') == $service['value'])
                                                selected="selected"
                                                @elseif (!old('service_id') AND isset($appointment) AND $appointment->service_id == $service['value'])
                                                selected="selected"
                                                @endif
                                                value="{{$service['value']}}">{{$service['label']}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="service_id_error">
                                        @foreach ($errors->get('service_id') as $message)
                                            <br/>{{$message}}
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="app_note">@lang('main.appointment:note_label')</label>
                                    <?php
                                        $old = old('note');
                                        if (!is_null($old)) {
                                            $value = $old;
                                        } elseif (isset($appointment)) {
                                            $value = $appointment->note;
                                        } else {
                                            $value = '';
                                    }?>
                                    <input type="text" name="note" id="app_note" class = "form-control" value="{{$value}}">
                                    <div id="note_error">
                                        @foreach ($errors->get('note') as $message)
                                            <br/>{{$message}}
                                        @endforeach
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="app_employee_id">@lang('main.appointment:employee_id_label')</label>
                                    <select name="employee_id" id="app_employee_id" class = "form-control">
                                        @if (isset($employeesOptions) OR session()->has('employeesOptions'))
                                            <?php if(!isset($employeesOptions)) $employeesOptions = session('employeesOptions');?>
                                            @foreach($employeesOptions AS $employee)
                                                <option
                                                    @if (old('employee_id') AND old('employee_id') == $employee['value'])
                                                    selected="selected"
                                                    @elseif (!old('employee_id') AND isset($appointment) AND $appointment->employee_id == $employee['value'])
                                                    selected="selected"
                                                    @endif
                                                    value="{{$employee['value']}}">{{$employee['label']}}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div id="employee_id_error">
                                        @foreach ($errors->get('employee_id') as $message)
                                            <br/>{{$message}}
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="app_date_from">@lang('main.appointment:date_time_from')</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?php
                                                $old = old('date_from');
                                                    if (!is_null($old)) {
                                                        $value = $old;
                                                    } elseif (isset($appointment)) {
                                                        $value = date('Y-m-d', strtotime($appointment->start));
                                                    } else {
                                                        $value = '';
                                                }?>
                                            <input type="text" name="date_from" id="app_date_from" class = "form-control" value="{{$value}}">
                                            <div id="date_from_error">
                                                @foreach ($errors->get('date_from') as $message)
                                                    <br/>{{$message}}
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <select name="time_from" id="app_time_from" class = "form-control">
                                                @foreach($timeOptions AS $time)
                                                    <option
                                                        @if (old('time_from') AND old('time_from') == $time['value'])
                                                        selected="selected"
                                                        @elseif (!old('time_from') AND isset($appointment) AND date('H:i', strtotime($appointment->start)) == $time['value'])
                                                        selected="selected"
                                                        @elseif (!old('time_from') AND !isset($appointment) AND isset($time['selected']) AND $time['selected'] == true)
                                                        selected="selected"
                                                        @endif
                                                        value="{{$time['value']}}">{{$time['label']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div id="time_from_error">
                                        @foreach ($errors->get('time_from') as $message)
                                            <br/>{{$message}}
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="app_duration">@lang('main.appointment:duration')</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <select name="duration_hours" id="app_duration_hours" class = "form-control">
                                                @foreach($hoursOptions AS $hour)
                                                    <option
                                                        @if (old('duration_hours') AND old('duration_hours') == $hour['value'])
                                                        selected="selected"
                                                        @elseif ( !old('duration_hours') AND isset($appointment) AND ( (int)floor((strtotime($appointment->end)-strtotime($appointment->start)) / 3600) == $time['value']) )
                                                        selected="selected"
                                                        @elseif ( !old('duration_hours') AND !isset($appointment) AND isset($hour['selected']) AND $hour['selected'] == true)
                                                        selected="selected"
                                                        @endif
                                                        value="{{$hour['value']}}">{{$hour['label']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div id="duration_hours_error">
                                                @foreach ($errors->get('duration_hours') as $message)
                                                    <br/>{{$message}}
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <select name="duration_minutes" id="app_duration_minutes" class = "form-control">
                                                @foreach($minutesOptions as $minute)
                                                    <option
                                                        @if (old('duration_minutes') AND old('duration_minutes') == $minute['value'])
                                                        selected="selected"
                                                        @elseif ( !old('duration_minutes') AND isset($appointment) AND ( ((strtotime($appointment->end)-strtotime($appointment->start))%3600) / 60 == $minute['value']) )
                                                        selected="selected"
                                                        @elseif ( !old('duration_minutes') AND !isset($appointment) AND isset($minute['selected']) AND $minute['selected'] == true)
                                                        selected="selected"
                                                        @endif
                                                        value="{{$minute['value']}}">{{$minute['label']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div id="duration_minutes_error">
                                                @foreach ($errors->get('duration_minutes') as $message)
                                                    <br/>{{$message}}
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        @if ($user->hasAccessTo('appointment_client_data', 'view', 0) >= 1)
                                            <div class="col-sm-12" id="app_client_info_container">
                                                @if(isset($clientInfo))
                                                    <hr/>{!! $clientInfo !!}
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="tab-content">
                                    <!-- Содержимое таба Ожидание клиента -->
                                    <div class="tab-pane fade in active" id="tab_client_wait">
                                        <!--<input type="hidden" name="state" id="app_state" value="created">-->
                                    </div>


                                    <!-- Содержимое вкладки Клиент пришел -->
                                    <div class="tab-pane fade" id="tab_client_came">
                                        @if (false)
                                            <input type="hidden" name="state" id="app_state" value="finished">
                                        @endif
                                    </div>
                                    <!-- Содержимое Клиент не пришел -->
                                    <div class="tab-pane fade" id="tab_client_didnt_came">
                                        @if (false)
                                            <input type="hidden" name="state" id="app_state" value="failed">
                                        @endif
                                    </div>
                                    <!-- Содержимое Клиент подтвердил -->
                                    <div class="tab-pane fade" id="tab_client_confirm">
                                        @if (false)
                                            <input type="hidden" name="state" id="app_state" value="confirmed">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <hr/>
                                <button type="submit" id="btn_submit_app_form" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
