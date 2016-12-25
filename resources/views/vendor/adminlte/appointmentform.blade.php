@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.appointment:list_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if (isset($appointment))
                            @lang('main.appointment:edit_form_header')
                        @else
                            @lang('main.appointment:create_form_header')
                        @endif
                    </div>

                    <div class="panel-body">

                        <form method="post" action="/appointments/save">
                            {{csrf_field()}}
                            @if (isset($appointment))
                                <input type="hidden" name="appointment_id" id="sc_appointment_id" value="{{$appointment->appointment_id}}">
                            @endif

                                <div class="col-md-6">
                                    <label for="app_client_name">@lang('main.appointment:client_name_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('client_name');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($appointment)) {
                                        $value = $appointment->client->name;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="client_name" id="app_client_name" value="{{$value}}">
                                    @foreach ($errors->get('client_name') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="app_client_phone">@lang('main.appointment:client_phone_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('client_phone');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($appointment)) {
                                        $value = $appointment->client->phone;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="client_phone" id="app_client_phone" value="{{$value}}">
                                    @foreach ($errors->get('client_phone') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="app_client_email">@lang('main.appointment:client_email_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('client_email');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($appointment)) {
                                        $value = $appointment->client->email;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="client_email" id="app_client_email" value="{{$value}}">
                                    @foreach ($errors->get('client_email') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="app_service_id">@lang('main.appointment:service_id_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="service_id" id="app_service_id">
                                        @foreach($servicesOptions AS $service)
                                            <option
                                                @if (isset($appointment) AND $appointment->service_id == $service['value'])
                                                selected="selected"
                                                @endif
                                                value="{{$service['value']}}">{{$service['label']}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @foreach ($errors->get('service_id') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="app_note">@lang('main.appointment:note_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('note');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($appointment)) {
                                        $value = $appointment->note;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="note" id="app_note" value="{{$value}}">
                                    @foreach ($errors->get('note') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>




                                <div class="col-md-6">
                                    <label for="app_employee_id">@lang('main.appointment:employee_id_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="employee_id" id="app_employee_id">
                                    </select>
                                    @foreach ($errors->get('employee_id') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="app_date_from">@lang('main.appointment:date_time_from')</label>
                                </div>
                                <div class="col-md-3">
                                    <?php
                                    $old = old('date_from');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($appointment)) {
                                        $value = date('Y-m-d', strtotime($appointment->start));
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="date_from" id="app_date_from" value="{{$value}}">
                                    @foreach ($errors->get('date_from') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>
                                <div class="col-md-3">
                                    <select name="time_from" id="app_time_from">
                                        @foreach($timeOptions AS $time)
                                            <option
                                                @if (old('time_from') AND old('time_from') == $time['value'])
                                                    selected="selected"
                                                @elseif (!old('time_from') AND isset($appointment) AND date('H:i', strtotime($appointment->start)) == $time['value'])
                                                    selected="selected"
                                                @elseif (isset($time['selected']) AND $time['selected'] == true)
                                                    selected="selected"
                                                @endif
                                                value="{{$time['value']}}">{{$time['label']}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @foreach ($errors->get('time_from') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>

                                <!-- duration -->
                                <div class="col-md-6">
                                    <label for="app_duration">@lang('main.appointment:duration')</label>
                                </div>
                                <div class="col-md-3">
                                    <select name="duration_hours" id="app_duration_hours">
                                        @foreach($hoursOptions AS $hour)
                                            <option
                                                @if (old('duration_hours') AND old('duration_hours') == $hour['value'])
                                                selected="selected"
                                                @elseif ( !old('duration_hours') AND isset($appointment) AND ((strtotime($appointment->end)-strtotime($appointment->start) % 3600) == $time['value']) )
                                                selected="selected"
                                                @elseif (isset($hour['selected']) AND $hour['selected'] == true)
                                                selected="selected"
                                                @endif
                                                value="{{$hour['value']}}">{{$hour['label']}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @foreach ($errors->get('duration_hours') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>
                                <div class="col-md-3">
                                    <select name="duration_minutes" id="app_duration_minutes">
                                        @foreach($minutesOptions AS $minute)
                                            <option
                                                @if (old('duration_minutes') AND old('duration_minutes') == $minute['value'])
                                                selected="selected"
                                                @elseif ( !old('duration_minutes') AND isset($appointment) AND (floor(strtotime($appointment->end)-strtotime($appointment->start)/60) == $minute['value']) )
                                                selected="selected"
                                                @elseif (isset($minute['selected']) AND $minute['selected'] == true)
                                                selected="selected"
                                                @endif
                                                value="{{$minute['value']}}">{{$minute['label']}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @foreach ($errors->get('duration_minutes') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-12">
                                    <hr/>
                                    <button type="submit" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
                                </div>

                                <div class="col-md-4 col-md-offset-4" id="app_client_info_container">
                                </div>

                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
