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

            <div class="form-group"><label class="col-sm-3 control-label">Напоминания</label>
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
                        ['1' => '1 час',
                         '2' => '2 часа',
                         '3' => '3 часа',
                         '4' => '4 часа',
                         '5' => '5 часов',
                         '6' => '6 часов',
                         '9' => '9 часов',
                         '12' => '12 часов',
                         '15' => '15 часов',
                         '18' => '18 часов',
                         '21' => '21 час',
                         '24' => '1 день',
                         '48' => '2 дня',
                         '72' => '3 дня',
                         '120' => '5 дней',
                         '168' => '7 дней'],
                         isset($appointment) && $appointment->remind_by_email_in > 0 ? $appointment->remind_by_email_in : '12',
                         ['id' => 'remind_by_email_in_value', 'class' => 'form-control input-sm']
                    )}}
                </div>
                <div class="col-sm-3">до визита</div>
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
                        ['1' => '1 час',
                         '2' => '2 часа',
                         '3' => '3 часа',
                         '4' => '4 часа',
                         '5' => '5 часов',
                         '6' => '6 часов',
                         '9' => '9 часов',
                         '12' => '12 часов',
                         '15' => '15 часов',
                         '18' => '18 часов',
                         '21' => '21 час',
                         '24' => '1 день',
                         '48' => '2 дня',
                         '72' => '3 дня',
                         '120' => '5 дней',
                         '168' => '7 дней'],
                         isset($appointment) && $appointment->remind_by_sms_in > 0 ? $appointment->remind_by_sms_in : null,
                         ['id' => 'remind_by_sms_in_value', 'class' => 'form-control input-sm hide']
                    )}}
                </div>
                <div class="col-sm-3">до визита</div>
            </div>
        </div>
    </div>
</div>