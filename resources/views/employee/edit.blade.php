@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_edit') }}
@endsection

@section('main-content')
    <section class="content-header">
        <h1>{{ trans('adminlte_lang::message.employee') }}</h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
            <li><a href="{{ url('/employee') }}">{{ trans('adminlte_lang::message.employees') }}</a></li>
            <li class="active">{{ trans('adminlte_lang::message.employee') }}</li>
        </ol>
    </section>
    <div class="container">

        @include('partials.alerts')

        <div class="row">
            {{-- {!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', "class" => "hidden", "id" => "form228"]) !!} --}}
            <div class="row">
                <div class="col-sm-12">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#menu1"><i class="fa fa-id-card-o" aria-hidden="true"></i>{{ trans('adminlte_lang::message.information') }}</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#menu2"><i class="fa fa-list" aria-hidden="true"></i>{{ trans('adminlte_lang::message.services') }}</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#menu3"><i class="fa fa-calendar" aria-hidden="true"></i>{{ trans('adminlte_lang::message.schedule') }}</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#menu4"><i class="fa fa-cog" aria-hidden="true"></i>{{ trans('adminlte_lang::message.employee_settings') }}</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#menu5"><i class="fa fa-money" aria-hidden="true"></i>{{ trans('adminlte_lang::message.payroll_calc') }}</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="menu1" class="tab-pane fade in active">
                            {!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', 'class' => 'hidden form-horizontal', 'id' => 'employee_form__info', 'files' => 'true']) !!}
                            {!! Form::hidden('id', 'employee_form__info') !!}
                            <div class="col-sm-8">
                                <div class="form-group">
                                    {{ Form::label('name',trans('adminlte_lang::message.employee_name'), ['class' => 'col-sm-4 control-label text-right']) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('name', null, ['class' => 'text-left form-control', 'placeholder' => trans('adminlte_lang::message.name_example')]) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('position_id', trans('adminlte_lang::message.employee_position'), ['class' => 'col-sm-4 control-label text-right']) }}
                                    <div class="col-sm-8">
                                        {{ Form::select('position_id', $items, $employee->position_id, ['class' => 'js-select-basic-single', 'required' => '']) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('spec', trans('adminlte_lang::message.employee_specialization'), ['class' => 'col-sm-4 control-label text-right']) }}
                                    <div class="col-sm-8">
                                        {{ Form::text('spec', null, ['class' => 'form-control', 'placeholder' => trans('adminlte_lang::message.specialization_example')]) }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('descr', trans('adminlte_lang::message.description'), ['class' => 'col-sm-4 control-label text-right']) }}
                                    <div class="col-sm-8">
                                        {{ Form::textarea('descr', null, ['class' => 'form-control']) }}
                                    </div>
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
                                <span class="btn btn-info btn-file">
                                    {{ trans('adminlte_lang::message.load_photo') }}<input type="file" name="avatar" @change="onFileChange">
                                </span>
                            </div>
                            {!! Form::close() !!}
                        </div>

                        <div id="menu2" class="tab-pane fade">
                            <div class="jumbotron">
                                <p class="lead">{{ trans('adminlte_lang::message.section_under_construction') }}</p>
                            </div>
                            {!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', "id" => "employee_form__schedule"]) !!}
                            {!! Form::close() !!}
                        </div>

                        <div id="menu3" class="tab-pane fade">
                            @include('employee.shedule')
                        </div>

                        <div id="menu4" class="tab-pane fade form-horizontal">
                            {!! Form::model($settings[0], ['route' => ['employee.update', $employee->employee_id], "method" => 'PUT', "id" => "employee_form__settings"]) !!}
                            {!! Form::hidden('id', 'employee_form__settings') !!}
                            <h4 class="fat">{{ trans('adminlte_lang::message.notifications') }}</h4>
                            <br>
                            <div class="form-group">
                                {{ Form::label('online_reg_notify', trans('adminlte_lang::message.online_records'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
                                <label class="col-sm-7 text-left">
                                    {{ Form::checkbox('online_reg_notify', 1, $settings[0]->online_reg_notify, ['class'=>'flat-red', 'style' => 'margin-right: 10px']) }}
                                    {{ trans('adminlte_lang::message.send_notes_online_records') }}
                                </label>
                                <label class="col-sm-1 text-left">
                                    <a class="fa fa-info-circle" id="online_reg_notify" original-title="">&nbsp;</a>
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
                                    'placeholder' => trans('adminlte_lang::message.example').'7 495 123 45 67']) }}
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

                            <h4 class="fat">{{ trans('adminlte_lang::message.record') }}</h4>
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
                                            {{ Form::select('session_start', $sessionStart, null, ['class' => 'js-select-basic-single']) }}
                                        </div>
                                        <div class="col-sm-6">
                                            {{ Form::select('session_end', $sessionEnd, null, ['class' => 'js-select-basic-single']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('add_interval', trans('adminlte_lang::message.additional_markup'), ['class' => 'col-sm-4 text-right ctrl-label']) }}
                                <div class="col-sm-7 text-left">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            {{ Form::select('add_interval', $addInterval, null, ['class' => 'js-select-basic-single']) }}
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

                            <h4 class="fat">{{ trans('adminlte_lang::message.statistics') }}</h4>
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
                                <div class="col-sm-7 input-group input-group-addon-right">
                                    {{ Form::text('revenue_pctg', null, ['class' => 'text-left form-control',
                                    'placeholder' => trans('adminlte_lang::message.use_for_payroll_calc')]) }}
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                            <hr>

                            <h4 class="fat">{{ trans('adminlte_lang::message.integration') }}</h4>
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
                            <?php $accessLevel = $crmuser->hasAccessTo('wage_schemes', 'edit', 0); ?>
                            @if($accessLevel > 0)

                            <form id="employee_form__wage" method="post" action="/employee/saveWageScheme">
                                {{csrf_field()}}
                                <input type="hidden" name="employee_id" id="ws_employee_id" value="{{$employee->employee_id}}">
                                <!-- // выбор схемы расчета зп -->
                                <div class="form-group">
                                    <label for="ws_wage_scheme_id" class="col-sm-4 text-right ctrl-label">@lang('main.employee:wage_scheme_label')</label>
                                    <div class="col-sm-7">
                                        <select name="wage_scheme_id" id="ws_wage_scheme_id" class="js-select-basic" >
                                            @foreach($wageSchemeOptions AS $wageScheme)
                                                <option
                                                    @if(old('wage_scheme_id') AND old('wage_scheme_id') == $wageScheme['value'])
                                                        selected="selected"
                                                    @elseif(!old('wage_scheme_id') AND isset($employee))
                                                        <?php $ws = $employee->wageSchemes()->first();?>
                                                        @if($ws AND $ws->scheme_id == $wageScheme['value'])
                                                            selected="selected"
                                                        @endif
                                                    @endif

                                                    value="{{$wageScheme['value']}}">{{$wageScheme['label']}}</option>
                                            @endforeach
                                        </select>
                                        @foreach ($errors->get('wage_scheme_id') as $message)
                                            <br/>{{$message}}
                                        @endforeach
                                    </div>
                                </div>

                                <!-- выбор даты с которой схема начинает действовать -->
                                <div class="form-group">
                                    <label for="ws_scheme_start" class="col-sm-4 text-right ctrl-label">@lang('main.employee:wage_scheme_start_from_label')</label>
                                    <div class="col-sm-7">
                                        <div class="input-group">
                                            <?php
                                            $old = old('scheme_start');
                                            $value = '';
                                            if (!is_null($old)) {
                                                $value = $old;
                                            } elseif (isset($employee)) {
                                                $currWs = $employee->wageSchemes()->first();
                                                if ($currWs) {
                                                    $value = date('Y-m-d', strtotime($currWs->pivot->scheme_start));
                                                }
                                            }?>
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input type="text" class="form-control" name="scheme_start" id="ws_scheme_start" value="{{$value}}" placeholder="@lang('main.employee:wage_scheme_start_from_label')">
                                            @foreach ($errors->get('scheme_start') as $message)
                                                <br/>{{$message}}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 text-right">
                    {!! Html::linkRoute('employee.show', trans('adminlte_lang::message.cancel'), [$employee->employee_id], ['class'=>'btn btn-info m-r']) !!}
                    {{ Form::button(trans('adminlte_lang::message.save'), ['class'=>'btn btn-primary  ', 'id' => 'form_submit']) }}
                </div>
            </div>
            {{-- {!! Form::close() !!} --}}
        </div>
    </div>
@stop
@section('page-specific-scripts')
<script type="text/javascript">
    // формируем структуру данных
    <?php
    //TODO получать по ajax. Структура должна отдаваться по любому, елси нет расписания то пустые значения полей

    $shData = [
        'employee_id' => '',
        'start_date'  => '2017-04-10',
        'last_date'   => '2017-04-16',
        'schedule'    => [
            0 => [8,10,16],
            1 => [12,19],
            2 => [],
            3 => [7,14],
            4 => [2,14],
            5 => [10,14],
            6 => [9]
        ],
        'fill_weeks' => 0
    ];
    $shData =  json_encode($shData);
    ?>

    // TODO получать по AJAX
    // получаем стартовое значение и обновляем вид таблиц
    var shData = JSON.parse('<?=$shData?>');
    shData.employee_id = $('#employee_id').val();

    /**
     * обновляет отображение таблицы прасписания на основании массива shData
     */
    function updateSheduleTable() {
        // зачищаем старые значения
        $("#operating_schedule tbody").find("td").removeClass('ui-datepicker-current-day');

        for (i = 0; i <= 6; i++) {
            var day = i;
            var hours = shData.schedule[i];
            for (j = 0; j <= hours.length; j++) {
                var hour = shData.schedule[i][j];
                $("#operating_schedule tbody").find("td[data-day='" + day + "'][data-hour='" + hour + "']").addClass('ui-datepicker-current-day');
            }
        }
    }

    $(document).ready(function(){
        // инициируем датапикер
        $("#shedule_week").datepicker({
            format: 'YYYY-MM-DD',
            weekStart: 1,
            calendarWeeks: true,
            todayHighlight: true
        });

        // инициируем moment.js
        moment.locale('en', {
            week: { dow: 1 } // Monday is the first day of the week
        });

        //Get the value of Start and End of Week
        $('#shedule_week').datepicker()
            .on('changeDate', function(e) {
                //console.log(e);
                var value = e.date;

                //TODO получить данные по AJAX
                //обновляем массив данных
                shData = shData;

                // обновляем отображение
                updateSheduleTable();

                shData.start_date = moment(value, "YYYY-MM-DD").day(1).format("YYYY-MM-DD");
                shData.last_date =  moment(value, "YYYY-MM-DD").day(7).format("YYYY-MM-DD");

                $('#shedule_week .datepicker tr').removeClass('active');
                $('#shedule_week .datepicker').find('td.active').parent('tr').addClass('active');

                $("#sheduleWeek").val(shData.start_date + " - " + shData.last_date);
            });
        $('#shedule_week').find('td.today.day').click();

        // обновляем отображение
        updateSheduleTable();

        // обработчки заголовков - часов
        $( "#operating_schedule thead th")
            .mouseover(function() {
                var hour = $(this).data('head-hour');
                $( "#operating_schedule tbody").find("td[data-hour='"+hour+"']").addClass('ui-datepicker-hover-day');
            })
            .mouseout(function() {
                var hour = $(this).data('head-hour');
                $( "#operating_schedule tbody").find("td[data-hour='"+hour+"']").removeClass('ui-datepicker-hover-day');
            })
            .click(function() {
                var hour = $(this).data('head-hour');

                if ( $(this).hasClass('ui-datepicker-fullhour') ){
                    // снимаем с ячейки отметку
                    $( "#operating_schedule tbody").find("td[data-hour='"+hour+"']").removeClass('ui-datepicker-current-day');

                    // обновляем массив данных
                    for (i = 0; i <= 6; i++) {
                        var day = i;
                        var index = shData.schedule[day].indexOf(hour);
                        if(index != -1){
                            shData.schedule[day].splice( index, 1 );
                        }
                    }
                } else {
                    // отмечаем ячейку
                    $( "#operating_schedule tbody").find("td[data-hour='"+hour+"']").addClass('ui-datepicker-current-day');

                    // добавляем час во все дни
                    for (i = 0; i <= 6; i++) {
                        var day = i;
                        // проверяем что такого значения уже нет в массиве
                        if ( shData.schedule[day].indexOf(hour) == -1 ){
                            shData.schedule[day].push(hour);
                            // выстраиваем часы по порядку
                            shData.schedule[day] =  shData.schedule[day].sort(function(a, b) {
                                return a - b;
                            });
                        }
                    }
                }

                $(this).toggleClass('ui-datepicker-fullhour');
            });

        // обработчки заголовков - дней
        $( "#operating_schedule td.legend")
            .mouseover(function() {
                var day = $(this).data('head-day');
                $( "#operating_schedule tbody").find("td[data-day='"+day+"']").addClass('ui-datepicker-hover-day');
            })
            .mouseout(function() {
                var day = $(this).data('head-day');
                $( "#operating_schedule tbody").find("td[data-day='"+day+"']").removeClass('ui-datepicker-hover-day');
            })
            .click(function() {
                var day = $(this).data('head-day');
                console.log(day);

                if ( $(this).hasClass('ui-datepicker-fullday') ){
                    //обновляем данные 
                    shData.schedule[day] = [];
                    
                    // снимаем отметки с ячеек
                    $( "#operating_schedule tbody").find("td[data-day='"+day+"']").removeClass('ui-datepicker-current-day');
                } else {
                    //обновляем данные 
                    shData.schedule[day] = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];

                    // отмечаем ячейки
                    $( "#operating_schedule tbody").find("td[data-day='"+day+"']").addClass('ui-datepicker-current-day');
                }

                $(this).toggleClass('ui-datepicker-fullday');
            });

        // обработчки кликов по  ячейкам
        $( "#operating_schedule td:not(.legend)").click(function() {

            // определяем день и час выбранной ячейки
            var day =  $(this).data('day');
            var hour =  $(this).data('hour');

            if ( $(this).hasClass('ui-datepicker-current-day') ){
                // если снимаем отмеченную ячейку - удаляем из массива часов данного дня
                var index = shData.schedule[day].indexOf(hour);
                shData.schedule[day].splice(index, 1);
            } else {
                // если отмечаем пустую ячейку - добавляем в массив часов данного дня
                shData.schedule[day].push(hour);
            }

            // ставим/убиреаем отметку в ячейке
            $(this).toggleClass('ui-datepicker-current-day');

            // выстраиваем часы по порядку
            shData.schedule[day] =  shData.schedule[day].sort(function(a, b) {
                return a - b;
            });
        });

        // очистка расписания
        $( "#shedule-clear").click(function() {
            // добавляем час во все дни
            for (i = 0; i <= 6; i++) {
                shData.schedule[i] = [];
            }

            // обновляем отображение
            updateSheduleTable();
        });

        // смена дропдауна выбора недель
        $( "#fill_weeks").on('change', function() {
            shData.fill_weeks = $( "select#fill_weeks option:checked" ).val();
        });

        //TODO убрать
        $( "#shedule-show").on('click', function() {
            console.log(shData);
        });
    });
</script>
@endsection