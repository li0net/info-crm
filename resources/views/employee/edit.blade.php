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
                            <a data-toggle="tab" href="#info-tab"><i class="fa fa-id-card-o" aria-hidden="true"></i>{{ trans('adminlte_lang::message.information') }}</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#services-tab"><i class="fa fa-tags" aria-hidden="true"></i>{{ trans('adminlte_lang::message.services') }}</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#schedule-tab"><i class="fa fa-calendar" aria-hidden="true"></i>{{ trans('adminlte_lang::message.schedule') }}</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#settings-tab"><i class="fa fa-cog" aria-hidden="true"></i>{{ trans('adminlte_lang::message.employee_settings') }}</a>
                        </li>
                        <li class="">
                            <a data-toggle="tab" href="#payroll-tab"><i class="fa fa-money" aria-hidden="true"></i>{{ trans('adminlte_lang::message.payroll_calc') }}</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="info-tab" class="tab-pane fade in active">
                            @include('employee.tpl.info_tab')
                        </div>
                        <div id="schedule-tab" class="tab-pane fade">
                            @include('employee.tpl.shedule_tab')
                        </div>
                        <div id="settings-tab" class="tab-pane fade form-horizontal">
                            @include('employee.tpl.setings_tab')
                        </div>
                        <div id="payroll-tab" class="tab-pane fade">
                            @include('employee.tpl.payroll_tab')
                        </div>
                    </div>
                </div>
                <div class="col-ersm-12 text-center">
                    <hr>
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
    // получаем стартовое значение и обновляем вид таблиц
    var $scheduleData = JSON.parse('<?=$shedule_data?>');

    /**
     * обновляет отображение таблицы прасписания на основании массива $scheduleData
     */
    function updateSheduleTable() {
        // зачищаем старые значения
        $("#operating_schedule tbody").find("td").removeClass('ui-datepicker-current-day');

        for (i = 0; i <= 6; i++) {
            var day = i;
            var hours = $scheduleData.schedule[i];
            for (j = 0; j <= hours.length; j++) {
                var hour = $scheduleData.schedule[i][j];
                $("#operating_schedule tbody").find("td[data-day='" + day + "'][data-hour='" + hour + "']").addClass('ui-datepicker-current-day');
            }
        }
    }

    $(document).ready(function(){

        //checking hash - if have - open hashed tab
        var hash = window.location.hash ;
        if (hash != undefined && hash != ''){
            $('.nav-tabs a[href="'+hash+'-tab"]').tab('show');
            console.log(hash);
            console.log(hash+"-tab");
        }

        window.serviceOptions = [];
        window.routingOptions = [];

        // обновляем отображение
        updateSheduleTable();

        // инициируем moment.js
        moment.locale('en', {
            week: { dow: 1 } // Monday is the first day of the week
        });

        /**
         * обработчик клика по датапикеру
         * выделаяет неделю, получает дату начала недели
         * запрашивает по ajax расписание на данную неделю
         * */
        $('#shedule_week').datepicker().on('changeDate', function(e) {
            //анимация
            $('#operating_schedule').addClass('loadingbox');
            $('#employeegs_form_error_alert').hide();
            $('#shedule_week .datepicker tr').removeClass('active');

            var value = e.date;
            start_date = moment(value, "YYYY-MM-DD").day(1).format("YYYY-MM-DD");

            //обновляем массив данных
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: '/employees/getSchedule',
                data: {start_date: start_date, employee_id: $scheduleData.employee_id},
                success: function(data) {
                    if (data.res) {
                        $scheduleData = data.shedule_data;

                        // обновляем отображение
                        updateSheduleTable();

                        $('#shedule_week .datepicker').find('td.active').parent('tr').addClass('active');
                        $("#sheduleWeek").val($scheduleData.start_date);

                    } else {
                        $('#employeegs_form_error_alert span').append(' '+data.error);
                        $('#employeegs_form_error_alert').show();
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#employeegs_form_error_alert span').append(' Error while processing shedule changing!');
                    $('#employeegs_form_error_alert').show();
                }
            });

            //анимация
            $('#operating_schedule').removeClass('loadingbox');
        });

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
                        var index = $scheduleData.schedule[day].indexOf(hour);
                        if(index != -1){
                            $scheduleData.schedule[day].splice( index, 1 );
                        }
                    }
                } else {
                    // отмечаем ячейку
                    $( "#operating_schedule tbody").find("td[data-hour='"+hour+"']").addClass('ui-datepicker-current-day');

                    // добавляем час во все дни
                    for (i = 0; i <= 6; i++) {
                        var day = i;
                        // проверяем что такого значения уже нет в массиве
                        if ( $scheduleData.schedule[day].indexOf(hour) == -1 ){
                            $scheduleData.schedule[day].push(hour);
                            // выстраиваем часы по порядку
                            $scheduleData.schedule[day] =  $scheduleData.schedule[day].sort(function(a, b) {
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
                    $scheduleData.schedule[day] = [];

                    // снимаем отметки с ячеек
                    $( "#operating_schedule tbody").find("td[data-day='"+day+"']").removeClass('ui-datepicker-current-day');
                } else {
                    //обновляем данные
                    $scheduleData.schedule[day] = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];

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
                var index = $scheduleData.schedule[day].indexOf(hour);
                $scheduleData.schedule[day].splice(index, 1);
            } else {
                // если отмечаем пустую ячейку - добавляем в массив часов данного дня
                $scheduleData.schedule[day].push(hour);
            }

            // ставим/убиреаем отметку в ячейке
            $(this).toggleClass('ui-datepicker-current-day');

            // выстраиваем часы по порядку
            $scheduleData.schedule[day] =  $scheduleData.schedule[day].sort(function(a, b) {
                return a - b;
            });
        });

        // очистка расписания
        $( "#shedule-clear").click(function() {
            // добавляем час во все дни
            for (i = 0; i <= 6; i++) {
                $scheduleData.schedule[i] = [];
            }

            // обновляем отображение
            updateSheduleTable();
        });

        // смена дропдауна выбора недель
        $( "#fill_weeks").on('change', function() {
            $scheduleData.fill_weeks = $( "select#fill_weeks option:checked" ).val();
        });

        /**
         * сабмит формы смены рапсписания
         * */
        function submitSheduleForm() {
            //анимация
            $('#employeegs_form_error_alert').hide();
            $('#employee_form_success_alert').hide();
            $('#menu3').addClass('loadingbox');

            //обновляем массив данных
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: '/employees/updateSchedule',
                data: {scheduleData: $scheduleData},
                success: function(data) {
                    if (data.res) {
                        $('#employee_form_success_alert').show();
                    } else {
                        $('#employeegs_form_error_alert span').append(' '+data.error);
                        $('#employeegs_form_error_alert').show();
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#employeegs_form_error_alert span').append(' '+data.error);
                    $('#employeegs_form_error_alert').show();
                }
            });
            //анимация
            $('#menu3').removeClass('loadingbox');
        }

        /** end of shedule scripts***/

        $('#add-service').on('click', function(e){
            $('.service-content').prepend('<div class="row"><div class="col-sm-3"><select required="required" name="employee-service[]" class="js-select-basic-single"></select></div> <div class="col-sm-2"><select required="required" name="service-duration-hour[]" class="js-select-basic-single"><option value="0">0 ч</option><option value="1">1 ч</option><option value="2">2 ч</option><option value="3">3 ч</option><option value="4">4 ч</option><option value="5">5 ч</option><option value="6">6 ч</option><option value="7">7 ч</option><option value="8">8 ч</option><option value="9">9 ч</option></select></div> <div class="col-sm-2"><select required="required" name="service-duration-minute[]" class="js-select-basic-single"><option value="00">00 мин</option><option value="15">15 мин</option><option value="30">30 мин</option><option value="45">45 мин</option></select></div> <div class="col-sm-3"><select required="required" name="service-routing[]" class="js-select-basic-single"></select></div> <div class="col-sm-2"><button type="button" id="delete-employee" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></div></div>');
            sel = $('.service-content').children('.row').first().children('.col-sm-3').children('select[name="employee-service[]"]').first();
            sel.html(window.serviceOptions);

            sel = $('.service-content').children('.row').first().children('.col-sm-3').children('select[name="service-routing[]"]').first();
            sel.html(window.routingOptions);

            $(".service-content .js-select-basic-single").select2({
                theme: "alt-control",
                placeholder: "choose one",
                minimumResultsForSearch: Infinity
            }).on("select2:open", function () {
                $('.select2-results__options').niceScroll({cursorcolor:"#ffae1a", cursorborder: "1px solid #DF9917", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
            });
        });

        $('.service-content').on('click', '#delete-employee', function(e){
            $(this).parent().parent().remove();
        });

        $.ajax({
            type: "GET",
            dataType: 'json',
            url: '/employees/serviceOptions',
            data: {},
            success: function(data) {
                $('select[name="employee-service[]"]').html('');
                $('select[name="employee-service[]"]').html(data.options);

                //$('#service-options').val(data.options);
                window.serviceOptions = data.options;
                //console.log('window.serviceOptions:', window.serviceOptions);
                // $('select.form-control[name="products_cats_detailed[]"]').find('option').remove();
                // $('select.form-control[name="products_cats_detailed[]"]').append(options);

                $('select.js-select-basic-single[name="employee-service[]"]').each(function() {
                    var initialValue = $(this).attr('data-initial-value');
                    //console.log('initialValue:', initialValue);

                    $(this).val(initialValue).trigger("change");
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log('Error while processing service data range!');
            }
        });

        $.ajax({
            type: "GET",
            dataType: 'json',
            url: '/service/routingOptions',
            data: {},
            success: function(data) {
                $('select[name="service-routing[]"]').html('');
                $('select[name="service-routing[]"]').html(data.options);

                //$('#routing-options').val(data.options);
                window.routingOptions = data.options;

                $('select.js-select-basic-single[name="service-routing[]"]').each(function() {
                    var initialValue = $(this).attr('data-initial-value');

                    $(this).val(initialValue).trigger("change");
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log('Error while processing routing data range!');
            }
        });

        // EMPLOYEE FORM SUBMIT
        $('#form_submit').on('click', function() {
            var activeTab = $('ul.nav.nav-tabs li.active a').attr('href');

            if(activeTab == '#menu1') {
                $('#employee_form__info').submit();
            }

            if(activeTab == '#menu2') {
                $('#employee_form__services').submit();
            }

            if(activeTab == '#menu3') {
                //('#employee_form__schedule').submit();
                submitSheduleForm();
                return false;
            }

            if(activeTab == '#menu4') {
                $('#employee_form__settings').submit();
            }

            if(activeTab == '#menu5') {
                $('#employee_form__wage').submit();
            }
        });

        // check if important lists are empty and show info-window
        checkZeroLists(['position_id', 'wage_scheme_id']);
        $('#shedule_week').find('td.today.day').click();
    });
</script>
@endsection