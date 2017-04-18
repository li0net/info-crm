<div class="record-body body_reminds" id="neo_reminds_div" style="display: block;">
    <div class="form-horizontal">
        <div id="reminds_content">
            <div class="form-group" id="send_sms_now_box" style="display: none;"><label class="col-sm-3 control-label">Уведомление</label>
                <div class="col-sm-8">
                    <div class="checkbox">
                        <label> <input type="checkbox" name="" id="send_sms_now" value="1"> Отправить SMS с деталями записи сейчас</label>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 control-label text-right">Напоминания</label>
                <div class="col-sm-2">
                    <div class="checkbox">
                        <label for="remind_by_email_in">
                            {{ Form::checkbox('remind_by_email_in', true, isset($appointment) && $appointment->remind_by_email_in > 0), ['id' => 'remind_by_email_in'] }}
                            Email
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    {{ Form::select(
                        'remind_by_email_in_value',
                        ['1' => trans('adminlte_lang::message.1_hour'),
                        '2' => trans('adminlte_lang::message.2_hours'),
                        '3' => trans('adminlte_lang::message.3_hours'),
                        '4' => trans('adminlte_lang::message.4_hours'),
                        '5' => trans('adminlte_lang::message.5_hours'),
                        '6' => trans('adminlte_lang::message.6_hours'),
                        '9' => trans('adminlte_lang::message.9_hours'),
                        '12' => trans('adminlte_lang::message.12_hours'),
                        '15' => trans('adminlte_lang::message.15_hours'),
                        '18' => trans('adminlte_lang::message.18_hours'),
                        '21' => trans('adminlte_lang::message.21_hours'),
                        '24' => trans('adminlte_lang::message.1_day'),
                        '48' => trans('adminlte_lang::message.2_days'),
                        '72' => trans('adminlte_lang::message.3_days'),
                        '120' => trans('adminlte_lang::message.5_days'),
                        '168' => trans('adminlte_lang::message.7_days') ],
                         isset($appointment) && $appointment->remind_by_email_in > 0 ? $appointment->remind_by_email_in : '12',
                         ['id' => 'remind_by_email_in_value', 'class' => 'form-control input-sm']
                    )}}
                </div>
                <label class="col-sm-3 control-label text-left">до визита</label>
            </div>

            <div class="form-group hide"><label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-2">
                    <div class="checkbox">
                        <label for="remind_by_sms_in">
                            {{ Form::checkbox('remind_by_sms_in', true, isset($appointment) && $appointment->remind_by_sms_in > 0), ['id' => 'remind_by_sms_in'] }}
                            SMS
                        </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    {{ Form::select(
                        'remind_by_sms_in_value',
                        ['1' => trans('adminlte_lang::message.1_hour'),
                        '2' => trans('adminlte_lang::message.2_hours'),
                        '3' => trans('adminlte_lang::message.3_hours'),
                        '4' => trans('adminlte_lang::message.4_hours'),
                        '5' => trans('adminlte_lang::message.5_hours'),
                        '6' => trans('adminlte_lang::message.6_hours'),
                        '9' => trans('adminlte_lang::message.9_hours'),
                        '12' => trans('adminlte_lang::message.12_hours'),
                        '15' => trans('adminlte_lang::message.15_hours'),
                        '18' => trans('adminlte_lang::message.18_hours'),
                        '21' => trans('adminlte_lang::message.21_hours'),
                        '24' => trans('adminlte_lang::message.1_day'),
                        '48' => trans('adminlte_lang::message.2_days'),
                        '72' => trans('adminlte_lang::message.3_days'),
                        '120' => trans('adminlte_lang::message.5_days'),
                        '168' => trans('adminlte_lang::message.7_days') ],
                         isset($appointment) && $appointment->remind_by_sms_in > 0 ? $appointment->remind_by_sms_in : null,
                         ['id' => 'remind_by_sms_in_value', 'class' => 'form-control input-sm hide']
                    )}}
                </div>
                <div class="col-sm-3">до визита</div>
            </div>
        </div>
    </div>
</div>