<div class="form-group">
    <label for="app_service_id">@lang('main.appointment:service_id_label')</label>
    <select name="service_id" id="app_service_id" class = "js-select-basic-single-search">
        <option id="app_service_id_empty" value="null">{{ trans('adminlte_lang::message.select_service') }}</option>
        @foreach($servicesOptions as $label => $services)
            <optgroup label="{{ $label }}">
                @foreach($services as $service)
                <option
                    @if (old('service_id') AND old('service_id') == $service['value'])
                    selected="selected"
                    @elseif (!old('service_id') AND isset($appointment) AND $appointment->service_id == $service['value'])
                    selected="selected"
                    @endif
                    value="{{$service['value']}}">{{$service['label']}}
                </option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="app_employee_id">@lang('main.appointment:employee_id_label')</label>
    <select name="employee_id" id="app_employee_id" class = "js-select-basic-single" >
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
</div>

<div class="form-group">
    <label for="app_date_from">@lang('main.appointment:date_time_from')</label>
    <div class="row">
        <div class="col-sm-6">
            <select name="date_from" id="app_date_from" class = "js-select-basic-single" >
                <?php
                    $oldDate = FALSE;
                    if(isset($appointment)){
                        $oldDate = date('Y-m-d', strtotime($appointment->start));
                    }
                ?>
                @if(!empty($daysOptions))
                    @foreach($daysOptions as $key => $val)
                    <option
                        @if ($oldDate AND $oldDate == $val)
                            selected="selected"
                        @endif
                            value="{{$val}}">{{$val}}
                    </option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-sm-6">
            <select name="time_from" id="app_time_from" class = "js-select-basic-single" >
                <?php
                    $oldTime = FALSE;
                    if(isset($appointment)){
                        $oldTime = date('H:i', strtotime($appointment->start));
                    }
                ?>
                @if(!empty($timeOptions))
                    @foreach($timeOptions as $key => $val)
                        <option
                            @if ($oldTime AND $oldTime == $val)
                                selected="selected"
                            @endif
                                value="{{$val}}">{{$val}}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="app_duration">@lang('main.appointment:duration')</label>
    <div class="row">
        <div class="col-sm-6">
            <select name="duration_hours" id="app_duration_hours" class = "js-select-basic-single" >
                <?php
                $oldHour = FALSE;
                if(isset($appointment)){
                    $oldHour = (int)floor((strtotime($appointment->end)-strtotime($appointment->start)) / 3600);
                }
                ?>
                @if(!empty($hoursOptions))
                    @foreach($hoursOptions as $hour)
                        <option
                            @if ($oldHour AND $oldHour ==$hour['value'])
                                selected="selected"
                            @endif
                                value="{{$hour['value']}}">{{$hour['label']}}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-sm-6">
            <select name="duration_minutes" id="app_duration_minutes" class = "js-select-basic-single" >
                <?php
                $oldMinute = FALSE;
                if(isset($appointment)){
                    $oldMinute = ((strtotime($appointment->end)-strtotime($appointment->start))%3600) / 60;
                }
                ?>
                @if(!empty($minutesOptions))
                    @foreach($minutesOptions as $minute)
                        <option
                            @if ($oldMinute AND $oldMinute ==$minute['value'])
                                selected="selected"
                            @endif
                                value="{{$minute['value']}}">{{$minute['label']}}
                        </option>
                    @endforeach
                @endif
            </select>
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