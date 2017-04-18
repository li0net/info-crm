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
    <select name="service_id" id="app_service_id" class = "js-select-basic-single">
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
    <select name="employee_id" id="app_employee_id" class = "js-select-basic-single">
        @if (isset($employeesOptions) OR session()->has('employeesOptions'))
            <?php if(!isset($employeesOptions)) $employeesOptions = session('employeesOptions');?>
            @foreach($employeesOptions as $employee)
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
            <select name="time_from" id="app_time_from" class = "js-select-basic-single">
                @foreach($timeOptions as $time)
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
            <select name="duration_hours" id="app_duration_hours" class = "js-select-basic-single">
                @foreach($hoursOptions as $hour)
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
            <select name="duration_minutes" id="app_duration_minutes" class = "js-select-basic-single">
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