@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.appointment:list_page_header')
@endsection

@section('main-content')
<section class="content-header">
    <h1>
        @if (isset($appointment))
        @lang('main.appointment:edit_form_header')
        @else
        @lang('main.appointment:create_form_header')
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.dashboard') }}</li>
        <li><a href="/home">{{ trans('adminlte_lang::message.appointments') }}</a></li>
        <li class="active">
            @if (isset($appointment))
            @lang('main.appointment:edit_form_header')
            @else
            @lang('main.appointment:create_form_header')
            @endif
        </li>
    </ol>
</section>
<div class="container-fluid">

    @include('partials.alerts')

    <div id="appointment_form_container">
        <div class="row">
            <div class="form-group m-b">
                <div class="col-sm-12">
                    <div class="input-group input-pills in_status">
                        <input type="radio" class="raw" name="options" id="option1" autocomplete="off" checked>
                        <label for="option1">
                            <i class="fa fa-clock-o"></i> <span class="hidden-xs">@lang('main.appointment:client_wait_tab_label')</span>
                        </label>
                        <input type="radio" class="raw" name="options" id="option2" autocomplete="off">
                        <label for="option2">
                            <i class="fa fa-plus-circle"></i> <span class="hidden-xs">@lang('main.appointment:client_came_tab_label')</span>
                        </label>
                        <input type="radio" class="raw" name="options" id="option3" autocomplete="off">
                        <label for="option3">
                            <i class="fa fa-minus-circle"></i> <span class="hidden-xs">@lang('main.appointment:client_didnt_came_tab_label')</span>
                        </label>
                        <input type="radio" class="raw" name="options" id="option4" autocomplete="off">
                        <label for="option4">
                            <i class="fa fa-check-circle"></i> <span class="hidden-xs">@lang('main.appointment:client_confirm_tab_label')</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-t">
            {!! Form::open(['url' => '/appointments/save', 'id' => 'appointment_form']) !!}

            {{ Form::hidden('employee_options', null, ['id' => 'employee_options']) }}
            {{ Form::hidden('storage_options', null, ['id' => 'storage_options']) }}
            {{ Form::hidden('organization_id', $user->organization_id, ['id' => 'organization_id']) }}

            <input type="hidden" name="appointment_id" id="app_appointment_id" value="@if (isset($appointment)) {{$appointment->appointment_id}} @endif">

            <div class="col-sm-4 nav-stacked-block" >
                <ul id="app_side_tabs" class="modal-menu list-group clear-list m-t nav nav-tabs nav-stacked">
                    <li class="modal-menu-header nav-header">@lang('adminlte_lang::message.visit')</li>

                    <li class="modal-menu-l record_tab list-group-item first-item active" data-toggle="tab" id="app_client" data-target="#app_client_tab" >
                        <i class="fa fa-user"></i> @lang('adminlte_lang::message.client')</li>
                    <li class="modal-menu-l record_tab list-group-item" data-toggle="tab" id="app_service"  data-target="#app_service_tab">
                        <i class="fa fa-calendar"></i> @lang('adminlte_lang::message.service')</li>
                    <li class="modal-menu-l visit_tab list-group-item" data-toggle="tab" id="app_status" data-target="#app_status_tab">
                        <i class="fa fa-clock-o"></i> @lang('adminlte_lang::message.visit_status')</li>
                    <li class="modal-menu-l goods_history_tab list-group-item last-item " data-toggle="tab" id="app_goods_history" data-target="#app_goods_history_tab">
                        <i class="fa fa-cubes"></i> @lang('adminlte_lang::message.writeoff_goods')</li>
                    <li class="modal-menu-l payments_tab list-group-item" data-toggle="tab" id="app_payments" data-target="#app_payments_tab"  >
                        <i class="fa fa-usd"></i> @lang('adminlte_lang::message.visit_payment')</li>
                    <li class="modal-menu-header client_header_tab nav-header">@lang('adminlte_lang::message.client')</li>

                    <li class="modal-menu-l client_info_tab list-group-item first-item" data-toggle="tab" id="app_client_info" data-target="#app_client_info_tab" >
                        <i class="fa fa-address-card-o"></i> @lang('adminlte_lang::message.client_info')</li>
                    <li class="modal-menu-l client_statistics_tab list-group-item" data-toggle="tab"  id="app_client_statistics" data-target="#app_client_statistics_tab">
                        <i class="fa fa-pie-chart"></i> @lang('adminlte_lang::message.attendance_statistics')</li>
                    {{--<li class="modal-menu-l client_loyalty_cards_tab list-group-item disabled" data-target="client_loyalty_cards_body"  >--}}
                        {{--<i class="fa fa-credit-card"></i> @lang('adminlte_lang::message.loyalty_cards')</li>--}}
                    <li class="modal-menu-l phone_call_tabs list-group-item last-item"data-toggle="tab" id="app_client_calls" data-target="#app_client_calls_tab">
                        <i class="fa fa-phone"></i> @lang('adminlte_lang::message.calls_history')</li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="col-sm-8 tab-pane fade in active" id="app_client_tab">
                    @include('appointment.tpl.app_client')
                </div>
                <div class="col-sm-8 tab-pane fade" id="app_service_tab">
                    @include('appointment.tpl.app_service')
                </div>
                <div class="col-sm-8 tab-pane fade" id="app_status_tab"></div>
                <div class="col-sm-8 tab-pane fade" id="app_goods_history_tab"></div>
                <div class="col-sm-8 tab-pane fade" id="app_payments_tab"></div>

                <div class="col-sm-8 tab-pane fade" id="app_client_info_tab"></div>
                <div class="col-sm-8 tab-pane fade" id="app_client_statistics_tab"></div>
                <div class="col-sm-8 tab-pane fade" id="app_client_calls_tab">
                    @include('appointment.tpl.app_client_calls')
                </div>
            </div>
            <div class="col-sm-12">
                <hr>
            </div>
            <div class="col-sm-12 m-t text-right">
                <button type="submit" id="btn_submit_app_form" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('page-specific-scripts')
    <script type="text/javascript">
        // индикаторы табов для учёта переходов
        var tab_active = 'app_client';
        var tab_current = 'app_client';

        $(document).ready(function($) {

            // при смене табов проверяем форму и пытаемся засабмитить
//            $('.list-group-item').on('click', function (e) {
            $('.list-group-item').on('shown.bs.tab', function (e) {

                tab_current = $(this).attr('id');
                //если надо вернуться к предыдущему
                //$('#app_side_tabs li#'+tab_current).tab('show');
                //                if (tab_current != tab_active){
//                    console.log("from "+tab_active+" to "+tab_current);
//                }
                //  tab_active = tab_current;
                //console.log("from "+tab_active+" to "+tab_current);

                if (tab_active != tab_current){

                    // валидация таба, который покидаем
                    switch (tab_active) {
                        case 'app_client':
                            //елси покидаем таб выбора клиента - проверяем, выбран ли клиент
                            var client_id = $('#app_client_id option:selected').val();
//                            console.log('client_id ' + client_id );
                            if (client_id == 'null' || client_id == undefined){
                                // ототбражаем сообщение о необходимости выбрать клиента
                                $('#app_side_tabs li#' + tab_active).tab('show');
                                addErrorMessage(
                                    'app_client_message',
                                    '@lang("main.general_error")',
                                    '@lang('adminlte_lang::message.select_client')'
                                );
                                tab_active = tab_current = 'app_client';
                            } else {
                                // чистим системные сообщения внутри форм
                                clearMessages()
                            }
                            break;
                        case 'app_service':
                            //елси покидаем таб выбора услуги, проверяем, что быбрана услуга и исполнитель
                            var employee_id = $('#app_employee_id option:selected').val();
                            var service_id = $('#app_service_id option:selected').val();
                            var date = $('#app_date_from option:selected').val();
                            var time = $('#app_time_from option:selected').val();

                            // ототбражаем сообщение о необходимости выбрать услугу и исполнителя
                            if (
                                employee_id == 'null' || employee_id == undefined ||
                                service_id == 'null' || service_id == undefined ||
                                date == 'null' || date == undefined ||
                                time == 'null' || time == undefined
                            ){
                                $('#app_side_tabs li#' + tab_active).tab('show');
                                addErrorMessage(
                                    'app_service_message',
                                    '@lang("main.general_error")',
                                    '@lang('adminlte_lang::message.call_form_required')');
                                tab_active = tab_current = 'app_service';
                            } else {
                                // чистим системные сообщения внутри форм
                                clearMessages()

                            }
                            break;
                    }


                    // особенности показа нового таба
                    tab_active = tab_current;
//                    console.log("switch to "+tab_current);
                    switch (tab_current) {
                        case 'app_client':
                        case 'app_service':
                            //никаких осбенностей
                            break;
                        //при переходе на другие табы, сабмитим форму и подгружаем содержимое аджаксом
                        case 'app_status':
                            // предварительный сабмит формы
                            $("#appointment_form").submit();
                            //TODO проверять что сабмит прошёл

                            //подгрузка содержимого открываемого таба
                            var appointment_id = $('#app_appointment_id').val();
                            if (appointment_id != 'null') {
                                //update tab
                                $.ajax({
                                    type: "GET",
                                    url: "/appointments/getStatus",
                                    data: {
                                        appointment_id: appointment_id,
                                        organization_id: $('#organization_id').val()
                                    },
                                    success: function(data) {
                                        $('#app_status_tab').html(data);
                                        $(".js-select-basic-single-alt").select2({
                                            theme: "alt-control",
                                            minimumResultsForSearch: Infinity
                                        }).on("select2:open", function () {
                                            $('.select2-results__options').niceScroll({cursorcolor:"#969696", cursorborder: "1px solid #444", cursorborderradius: "0", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
                                        });
                                    },
                                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                                        alert('Server error:'+textStatus);
                                    }
                                });
                            }
                            break;
                        case 'app_goods_history':
                            // предварительный сабмит формы
                            $("#appointment_form").submit();
                            //TODO проверять что сабмит прошёл

                            //подгрузка содержимого открываемого таба
                            var appointment_id = $('#app_appointment_id').val();
                            if ( appointment_id != 'null') {
                                //update tab
                                $.ajax({
                                    type: "GET",
                                    url: "/appointments/getGoodHistory",
                                    data: {
                                        appointment_id: appointment_id,
                                        organization_id: $('#organization_id').val()
                                    },
                                    success: function(data) {
                                        $('#app_goods_history_tab').html(data);

                                        $('#card-items .wrap-it:last-of-type select.form-control').removeClass('form-control').addClass('js-select-basic-single-alt');
                                        $('#card-items .wrap-it:last-of-type .js-select-basic-single-alt').select2({
                                            theme: "alt-control",
                                            minimumResultsForSearch: Infinity
                                        }).on("select2:open", function () {
                                            $('.select2-results__options').niceScroll({cursorcolor:"#969696", cursorborder: "1px solid #787878", cursorborderradius: "0", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.9, cursoropacitymax:1, boxzoom:true, autohidemode:false});
                                        });

                                        $(".js-select-basic-single-alt").select2({
                                            theme: "alt-control",
                                            minimumResultsForSearch: Infinity
                                        }).on("select2:open", function () {
                                            $('.select2-results__options').niceScroll({cursorcolor:"#969696", cursorborder: "1px solid #444", cursorborderradius: "0", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
                                        });

                                    },
                                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                                        alert('Server error:'+textStatus);
                                    }
                                });
                            }
                            break;
                        case 'app_payments':
                            // предварительный сабмит формы
                            $("#appointment_form").submit();
                            //TODO проверять что сабмит прошёл

                            //подгрузка содержимого открываемого таба
                            var appointment_id = $('#app_appointment_id').val();
                            if ( appointment_id != 'null') {
                                //update tab
                                $.ajax({
                                    type: "GET",
                                    url: "/appointments/getPayments",
                                    data: {
                                        appointment_id: appointment_id,
                                        organization_id: $('#organization_id').val()
                                    },
                                    success: function(data) {
                                        $('#app_payments_tab').html(data);

                                        $(".js-select-basic-single").select2({
                                            minimumResultsForSearch: Infinity
                                        }).on("select2:open", function () {
                                            $('.select2-results__options').niceScroll({cursorcolor:"#ffae1a", cursorborder: "1px solid #DF9917", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
                                        });

                                    },
                                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                                        alert('Server error:'+textStatus);
                                    }
                                });
                            }
                            break;
                        case 'app_client_info':
                        case 'app_client_statistics':
                        case 'app_client_calls':
                            // предварительный сабмит формы
                            $("#appointment_form").submit();
                            //TODO проверять что сабмит прошёл

                            updateClientData();
                            break;
                    }
                }
            });


            /*******************************
             * Appointment form submit
             ******************************/
            $("#appointment_form").on("submit", function (e) {
                e.preventDefault();

                // clear alerts
                clearFormAlerts();

                if($('#app_client_id').val() == 'null' || $('#app_service_id').val() == 'null'){
                    showFormError('At least Client and Service should be chosen!');
                    return false;
                }

                if ( $('#app_state').length ) {
                    $('#app_state').remove();
                }

                var selectedTab = $('#appointment_tabs_header li.active a');
                if (selectedTab.length > 0) {
                    var selectedTabId = $(selectedTab[0]).attr('href');
                    if (selectedTabId == '#tab_client_wait') {
                        var stateVal = 'created';
                    } else if (selectedTabId == '#tab_client_came') {
                        var stateVal = 'finished';
                    } else if (selectedTabId == '#tab_client_didnt_came') {
                        var stateVal = 'failed';
                    } else if (selectedTabId == '#tab_client_confirm') {
                        var stateVal = 'confirmed';
                    }
                }

                if (stateVal !== undefined) {
                    $('<input>').attr({
                        type: 'hidden',
                        id: 'app_state',
                        name: 'state',
                        value: stateVal
                    }).appendTo('#appointment_form');
                }

                $.ajax({
                    type: "POST",
                    url: "/appointments/save",
                    data: $("#appointment_form").serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $('#appointment_form_container').addClass('loadingbox');
                    },
                    success: function(data) {
//                        console.log('SUCCESS DATA');
//                        console.log(data);

                        if (data.success) {
//                            console.log('success');
                            showFormSuccess('Changes successfully saved');
                            // преобразуем форму создания в форму редактирования
                            // для пошагового сабмита
                            if (data.appid != undefined && data.appid != null) {
                                $('#app_appointment_id').val(data.appid);
                            }
                        } else {
//                            console.log('error');
                            if (data.validation_errors !== undefined) {
                                var errorMsg = '';
                                for (var field_name in data.validation_errors) {
                                    if (data.validation_errors.hasOwnProperty(field_name)) {
                                        errorMsg += data.validation_errors[field_name]+'<br/>';
                                    }
                                }
                                if(errorMsg !=''){
                                    showFormError(errorMsg);
                                }
                            }
                            if (data.error !== undefined) {
                                showFormError(data.error);
                            }
                        }
                        // window.location.href = '/home';
                    },
                    error: function(data) {
//                        console.log('ERROR DATA');
//                        console.log(data);
                    }
                });

                $('#appointment_form_container').removeClass('loadingbox');

                return false;
            });

            /*******************************
             * Choose client tab functions
             ******************************/

            // поиск или создание клиента
            $('#btn_app_form_create_client').on('click', function() {
                var name = $('#app_new_client_name').val();
                var phone = $('#app_new_client_phone').val();
                var email = $('#app_new_client_email').val();

                if (phone == '' || name == ''){
                    addErrorMessage(
                        'app_client_message',
                        '@lang("main.general_error")',
                        '@lang('adminlte_lang::message.name_phone_required')'
                    );
                    return;
                }
                $('#body_client .tab-content').addClass('loadingbox');
                $.ajax({
                    type: "POST",
                    url: "/appointments/findClient/",
                    data: {
                        'organization_id': $('#organization_id').val(),
                        'client_name': name,
                        'client_phone':phone,
                        'client_email':email
                    },
                    success: function(data) {
                        // clear form
                        $('#app_new_client_name').val('');
                        $('#app_new_client_phone').val('');
                        $('#app_new_client_email').val('');

                        // clear clients select
                        $("#app_client_id option").each(function() {
                            $(this).remove();
                        });

                        for (var i in data.clients) {
                            $('<option>').val(data.clients[i].client_id).text(data.clients[i].name).appendTo('#app_client_id');
                        }
                        // set new client checked
                        $('#app_client_id').val(data.client.client_id).prop('selected', true);
                        $('#body_client a:first').tab('show');
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert('Server error:'+textStatus);
                    }
                });
                $('#body_client .tab-content').removeClass('loadingbox');
            });

            /*******************************
             * Service tab functions
             ******************************/
            // Реакция на выбор услуги -  подгрузка списка исполнителей
            $('#app_service_id').on('change', function(){
                // удаляем все опции из селекта с сотрудниками
                $('#app_service_id_empty').remove();
                $("#app_employee_id option").each(function() {
                    $(this).remove();
                });

                var that = this;
                $.ajax({
                    type: "POST",
                    url: "/appointments/getEmployeesForService/"+$(that).val(),
                    data: {'organization_id':$('#organization_id').val()},
                    success: function(data) {
                        if (data != "[][]") {
                            // построение списка исполнителей
                            var data = $.parseJSON(data);

                            for (var i in data) {
                                $('<option>').val(data[i].value).text(data[i].label).appendTo('#app_employee_id');
                            }

                            $('#service_name').text($('#app_service_id option:selected').text());

                            if ( $('#app_employee_id > option').length == 0) {
                                $('#service_employee').text("@lang('adminlte_lang::message.employee_not_chosen')");
                            } else {
                                var employee_name = $('#app_employee_id option:selected').text();
                                $('#service_employee').text('' == employee_name ? $('#app_employee_id option:first').text() : employee_name);
                            }

                            $('#app_employee_id').prepend('<option id="app_employee_id_empty" selected value="null">{{ trans('adminlte_lang::message.select_employee') }}</option>');
                            $('#app_employee_id').prop("disabled", false);
                        } else {
                            $('#app_employee_id').prop("disabled", true);
                        }
                        updateRelatedSelects();
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert('Server error:'+textStatus);
                    }
                });
            });

            // Реакция на выбор исполнителя - подгрузка дат
            $('#app_employee_id').on('change', function(){
                $('#app_employee_id_empty').remove();
                if ( $('#app_employee_id > option').length == 0) {
                    $('#service_employee').text("@lang('adminlte_lang::message.employee_not_chosen')");
                } else {
                    var employee_name = $('#app_employee_id option:selected').text();
                    $('#service_employee').text('' == employee_name ? $('#app_employee_id option:first').text() : employee_name);
                    var employee_id =  $(this).val();
                    var service_id =  $('#app_service_id').val();

                    var that = this;
                    $.ajax({
                        type: "POST",
                        url: "/appointments/getAvailableDays/",
                        data: {'employee_id':employee_id, 'service_id':service_id},
                        success: function(data) {
                            if (data != "[][]") {
                                var data = $.parseJSON(data);
                                for (var i in data) {
                                    $('<option>').val(data[i]).text(data[i]).appendTo('#app_date_from');
                                }
                                $('#app_date_from').prop("disabled", false);
                                $('#app_date_from').prepend('<option id="app_date_from_empty" selected value="null">@lang('main.appointment:date_time_from')</option>');
                            } else {
                                $('#app_date_from').prop("disabled", true);
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('Server error:'+textStatus);
                        }
                    });
                }
            });

            // Реакция на выбор даты - подгрузка временных интервалов
            $('#app_date_from').on('change', function(){
                $('#app_date_from_empty').remove();
                var date = $(this).val();
                var employee_id =  $('#app_employee_id').val();
                var service_id =  $('#app_service_id').val();

                $.ajax({
                    type: "POST",
                    url: "/appointments/getAvailableTime/",
                    data: {'date': date,'employee_id':employee_id, 'service_id':service_id},
                    success: function(data) {
                        if (data != "[][]") {
                            var data = $.parseJSON(data);
                            for (var i in data) {
                                $('<option>').val(data[i]).text(data[i]).appendTo('#app_time_from');
                            }

                            $('#app_time_from').prop("disabled", false);
                        } else {
                            $('#app_time_from').prop("disabled", true);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert('Server error:'+textStatus);
                    }
                });
            });

            // Реакция на выбор времени
            $('#app_time_from').on('change', function(){
                $('#app_duration_hours').prop("disabled", false);
                $('#app_duration_minutes').prop("disabled", false);
            });

            $('#service_name').text( $('#app_service_id option:selected').text() );

            // enable/disable related selects
            updateRelatedSelects();

            /*******************************
             * Status tab functions
             ******************************/

            var options = '';
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: '/storageData',
                data: {},
                success: function(data) {
                    for (var i = 0; i < data.length; i++) {
                        options = options + '<option value=' + data[i].storage_id + '>' + data[i].title + '</option>';
                    }

                    $('#storage_options').val(options);

                    $('select.form-control[name="storage_id[]"]').find('option').remove();
                    $('select.form-control[name="storage_id[]"]').append(options);

                    $('select.form-control[name="storage_id[]"]').each(function() {
                        var initialValue = $(this).attr('data-initial-value');

                        if ( 0 != initialValue ) {
                            $(this).val(initialValue);
                        } else {
                            $(this).val($(this).find('option').first().val());
                        }
                    });
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log('Error while processing services data range!');
                }
            });

            $.ajax({
                type: 'GET',
                dataType: 'json',
                data: {},
                url: "<?php echo route('appointments.employeeOptions') ?>",
                success: function(data) {
                    $('#employee_options').val(data.options);

                    $('select.form-control[name="master_id[]"]').find('option').remove();
                    $('select.form-control[name="master_id[]"]').append(data.options);

                    $('select.form-control[name="master_id[]"]').each(function() {
                        var initialValue = $(this).attr('data-initial-value');

                        if ( 0 != initialValue ) {
                            $(this).val(initialValue);
                        } else {
                            $(this).val($(this).find('option').first().val());
                        }
                    });
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log('Error while processing services data range!');
                }
            });

            // пересчёт стоимости услуги
            $('body').on('change', 'input[name=service_price]', function() {
                calculateServiceSum();
            });
            $('body').on('change', 'input[name=service_discount]', function() {
                calculateServiceSum();
            });
            function calculateServiceSum(){
                var service_discount = $('input[name=service_discount]').val();//скидка в процентах
                var service_price = $('input[name=service_price]').val();

                var service_sum = service_price - (service_price / 100) * service_discount;

                $('input[name=service_sum]').val( service_sum );
            }

            // добавление блока продажи товара
            $('body').on('click', '#add_good_transaction', function() {
//                console.log('add_good_transaction');

                $('.goods_transactions_box').append(
                    '<div id="vis_sale_box_1" class="goods_sale m-b col-sm-12 alt-control-bar"><div class="row"><div class="col-sm-4"><label>Склад</label></div> <div class="col-sm-4"><label>@lang('adminlte_lang::message.good')</label></div> <div class="col-sm-4"><label>@lang('adminlte_lang::message.employee')</label></div></div> <div class="row"><div class="col-sm-4"><select data-initial-value="0" name="storage_id[]" class="js-select-basic-single-alt"></select></div> <div class="col-sm-4"><select data-initial-value="0" name="product_id[]" class="js-select-basic-single-alt"></select></div> <div class="col-sm-4"><select data-initial-value="0" name="master_id[]" class="js-select-basic-single-alt"></option></select></div></div> <div class="row"><div class="col-sm-2"><label>@lang('adminlte_lang::message.amount')</label></div> <div class="col-sm-2"><label>@lang('adminlte_lang::message.price_val')</label></div> <div class="col-sm-2"><label>@lang('adminlte_lang::message.discount_val')</label></div> <div class="col-sm-2"><label>@lang('adminlte_lang::message.total_val')</label></div></div> <div class="row"><div class="col-sm-2 "><input data-number="1" type="text" name="amount[]" value="1" placeholder="Кол-во" class="form-control input-sm sg_amount add_goods_amount_input_1"></div> <div class="col-sm-2"><input data-number="1" type="text" name="price[]" value="0" class="form-control input-sm sg_price add_goods_price_input_1"></div> <div class="col-sm-2"><input data-number="1" type="text" name="discount[]" value="0" class="form-control input-sm sg_discount add_goods_discount_input_1"></div> <div class="col-sm-2"><input data-number="1" type="text" name="sum[]" value="0" class="form-control input-sm sg_cost add_goods_cost_input_1"></div> <div class="col-sm-4 text-right"><div id="remove_good_transaction" class="btn btn-danger" ><i class="fa fa-trash-o"></i></div></div></div></div>');

                $('select.js-select-basic-single-alt[name="storage_id[]"]').last().find('option').remove();
                $('select.js-select-basic-single-alt[name="storage_id[]"]').last().prepend('<option id="storage_id_empty" selected value="null">@lang('adminlte_lang::message.select_storage')</option>');
                $('select.js-select-basic-single-alt[name="storage_id[]"]').last().append($('#storage_options').val());
//                console.log($('#storage_options').val());

                $('select.js-select-basic-single-alt[name="master_id[]"]').last().find('option').remove();
                $('select.js-select-basic-single-alt[name="master_id[]"]').last().append($('#employee_options').val());

                $(".js-select-basic-single-alt").select2({
                    theme: "alt-control",
                    minimumResultsForSearch: Infinity
                }).on("select2:open", function () {
                    $('.select2-results__options').niceScroll({cursorcolor:"#969696", cursorborder: "1px solid #444", cursorborderradius: "0", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
                });
            });
            // удаление блока продажи товара
            $('body').on('click', '#remove_good_transaction', function(e) {
                $(e.target).parents('.goods_sale').remove();
            });
            // подгрузка товаров при выборе склада в блоке продажи товаров
            $('body').on('change', 'select[name="storage_id[]"]', function(e){
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {'storage_id' : $(this).val()},
                    url: "<?php echo route('card.productOptions') ?>",
                    success: function(data) {
                        $(e.target).parent().next().children('select[name="product_id[]"]').first().html('');
                        $(e.target).parent().next().children('select[name="product_id[]"]').first().html(data.options);
                    }
                });
            });

            // пересчёт стоимости услуги
            $('body').on('change', '.sg_amount', function() {
                calculateProductSum(this);
            });
            $('body').on('change', '.sg_price', function() {
                calculateProductSum(this);
            });
            $('body').on('change', '.sg_discount', function() {
                calculateProductSum(this);
            });
            function calculateProductSum(el){
                var product_amount   = $(el).closest('.row').find('input.sg_amount').val();
                var product_price    = $(el).closest('.row').find('input.sg_price').val();
                var product_discount = $(el).closest('.row').find('input.sg_discount').val();

                if(product_amount < 1){
                    product_amount = 1;
                }

                var product_sum = ( product_price * product_amount ) - (( product_price * product_amount ) / 100) * product_discount;

                $(el).closest('.row').find('input.sg_cost').val( product_sum );
            }


            /*******************************
             * Goods history tab functions
             ******************************/
            // вкл/выкл использование технологической карты

            $('body').on('click', '.use_routing_card_block, .use_routing_card_block input, .use_routing_card_block .iCheck-helper', function(e){
                $('#card-items .wrap-it:last-of-type select.form-control').removeClass('form-control').addClass('js-select-basic-single-alt');
                $('#card-items .wrap-it:last-of-type .js-select-basic-single-alt').select2({
                    theme: "alt-control",
                    minimumResultsForSearch: Infinity
                }).on("select2:open", function () {
                    $('.select2-results__options').niceScroll({cursorcolor:"#969696", cursorborder: "1px solid #787878", cursorborderradius: "0", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.9, cursoropacitymax:1, boxzoom:true, autohidemode:false});
                });

                if( $('input[name=use_routing_card]').is(":checked") ) {
                    $('#card-items').removeClass('disabled');
                } else {
                    $('#card-items').addClass('disabled');
                }

            });
            $('body').on('click', '#card-items #add-card-item', function(e){
                if( $(this).hasClass('btn-add') ) {
                    $('#card-items').append($('#card-items-tpl').html());
                    $('#card-items .wrap-it:last-of-type select[name="storage_id[]"]').removeClass('form-control').addClass('js-select-basic-single-alt');
                    // $('#card-items .wrap-it:last-of-type select[name="storage_id[]"]').prepend('<option id="storage_id_empty" selected value="null">'+$('#select_storage-placeholder-tpl').html()+'</option>');
                    $('#card-items .wrap-it:last-of-type select[name="product_id[]"]').removeClass('form-control').addClass('js-select-basic-single-alt');

                    $('#card-items .wrap-it:last-of-type select[name="card_storage_id[]"]').removeClass('form-control').addClass('js-select-basic-single-alt');
                    // $('#card-items .wrap-it:last-of-type select[name="card_storage_id[]"]').prepend('<option id="storage_id_empty" selected value="null">'+$('#select_storage-placeholder-tpl').html()+'</option>');

                    $('#card-items .wrap-it:last-of-type select[name="card_product_id[]"]').removeClass('form-control').addClass('js-select-basic-single-alt');

                    $('#card-items .wrap-it:last-of-type select.form-control').removeClass('form-control').addClass('js-select-basic-single-alt');

                    $('#card-items .wrap-it:last-of-type .js-select-basic-single-alt').select2({
                        theme: "alt-control",
                        minimumResultsForSearch: Infinity
                    }).on("select2:open", function () {
                        $('.select2-results__options').niceScroll({cursorcolor:"#969696", cursorborder: "1px solid #787878", cursorborderradius: "0", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.9, cursoropacitymax:1, boxzoom:true, autohidemode:false});
                    });

                    app.card_items_count++;

                    $(this).addClass('btn-remove').removeClass('btn-add');
                    $(this).off();
                    $(this).on('click', function(e) {
                        $(this).parents('.wrap-it').remove();
                        app.card_items_count--;
                    });
                } else {
                    $(this).parents('.wrap-it').remove();
                    app.card_items_count--;
                }
            });
            // подгрузка товаров при выборе склада
            $('body').on('change', '#card-items select[name="card_storage_id[]"]', function(e){
                // getting the list of products when choose storage
                $(this).find('[value=null]').remove();
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {'storage_id' : $(this).val()},
                    url: "<?php echo route('card.productOptions') ?>",
                    success: function(data) {
                        $(e.target).parent().next().children('select[name="card_product_id[]"]').first().html('');
                        $(e.target).parent().next().children('select[name="card_product_id[]"]').first().html(data.options);
                    }
                });
            });


            /*******************************
             * Payment tab functions
             ******************************/
            //оплата визита
            $('body').on('click', '#create-transaction-btn', function(e){
                $('#body_payments').addClass('loadingbox');
                $('#payment_message').html('');
                $('#payment_message .alert').hide();

                var service_id = $('#app_service_id option:selected').val();
                var account_id = $('select[name="new-transaction-account-id"] option:selected').val();
                var service_sum = $('#new-transaction-services').val();
                var organization_id = $('#organization_id').val();
                var appointment_id = $('#app_appointment_id').val();
                var employee_id = $('#app_employee_id').val();

                var products = [];
                $.each( $('select[name="product_id[]"]') , function( key, value ) {
                    if($(this).find('option:selected').val() != undefined){
                        products.push($(this).find('option:selected').val())
                    }
                });

                var products_sum = [];
                $.each( $('input[name="sum[]"]') , function( key, value ) {
                    products_sum .push($(this).val());
                });

                if (account_id == undefined || account_id == ''){
                    $('#payment_message').html('<div class="alert alert-inline alert-error" role="alert"><strong>@lang("main.general_error"):</strong> @lang("adminlte_lang::message.select_account")</div>');
                    $('#payment_message .alert').show();
                    $('#body_payments').removeClass('loadingbox');
                    return;
                }

                // если есть услуги и продукты для оплаты
                if( products.length > 0 || service_id != undefined && service_id != ''){
                    $.ajax({
                        type: "POST",
                        url: "/appointments/savePayment/",
                        data: {
                            service_id: service_id,
                            account_id: account_id,
                            service_sum: service_sum,
                            organization_id: organization_id,
                            appointment_id: appointment_id,
                            employee_id: employee_id,
                            products: products,
                            products_sum: products_sum,
                        },
                        success: function(data) {
                            if(data.result){
                                $('#payment_message').html('<div class="alert alert-inline alert-success" role="alert"><strong>@lang("adminlte_lang::message.success"):</strong> @lang("adminlte_lang::message.payment_done")</div>');
                                $('#payment_message .alert').show();
                            }

                            //перегружаем  таб
                            $.ajax({
                                type: "GET",
                                url: "/appointments/getPayments",
                                data: {
                                    appointment_id: appointment_id,
                                    organization_id:organization_id
                                },
                                success: function(data) {
                                    $('#app_payments_tab').html(data);

                                    $(".js-select-basic-single").select2({
                                        minimumResultsForSearch: Infinity
                                    }).on("select2:open", function () {
                                        $('.select2-results__options').niceScroll({cursorcolor:"#ffae1a", cursorborder: "1px solid #DF9917", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
                                    });

                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    alert('Server error:'+textStatus);
                                }
                            });

                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('Server error:'+textStatus);
                        }
                    });
                }
                $('#body_payments').removeClass('loadingbox');

            });

            /*******************************
             * Client info tab functions
             ******************************/
            /**
             * Update client calls
             */
            function updateClientCalls() {
                var client_id = $('#app_client_id option:selected').val();
                if(client_id != 'null'){
                    //update client calls
                    $.ajax({
                        type: "GET",
                        url: "/appointments/getCalls",
                        data: {appointment_id:$('#app_appointment_id').val(),client_id:client_id},
                        success: function(data) {
                            $('#app_calls_history').html(data);
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('Server error:'+textStatus);
                        }
                    });
                }
            }
            /**
             * Update data at client tabs
             */
            function updateClientData() {
                var client_id = $('#app_client_id option:selected').val();
                if(client_id != 'null'){
                    // Update client information tab
                    $.ajax({
                        type: "GET",
                        url: "/client/"+client_id,
                        data: {ajax_call:true},
                        success: function(data) {
                            $('#app_client_info_tab').html(data);

                            $('#app_client_info_tab').find('.col-md-12.text-left').removeClass('text-left').addClass('text-right');
                            $('#app_client_info_tab').find('.btn-primary').removeClass('btn-primary').addClass('btn-info');
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('Server error:'+textStatus);
                        }
                    });
                    //update client stats tab
                    $.ajax({
                        type: "GET",
                        url: "/appointments/getClientStats",
                        data: {'organization_id':$('#organization_id').val(),client_id:client_id},
                        success: function(data) {
                            $('#app_client_statistics_tab').html(data);
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('Server error:'+textStatus);
                        }
                    });
                }

                //Update client calls
                updateClientCalls()
            }
            // Calls form
            $('#save_call_info').on('click', function(e) {
                // getting data
                var call_title = $('#app_call_title').val();
                var call_date = $('#app_call_date').val();
                var call_description = $('#app_call_description').val();
                var client_id = $('#app_client_id').val();
                var call_id = $('#app_call_id').val();

                if (call_title =='' || call_date =='' || call_description ==''){
                    alert("@lang('adminlte_lang::message.call_form_required')");
                    return;
                }

                if ($('#app_appointment_id').length && $('#app_appointment_id').val() != ''){
                    // loader animation
                    $('#client_history').addClass('loadingbox');

                    var appointment_id = ($('#app_call_appointment_id').val() != '') ? $('#app_call_appointment_id').val() : $('#app_appointment_id').val();

                    $.ajax({
                        type: "POST",
                        url: "/appointments/saveCall/",
                        data: {
                            call_id: call_id,
                            call_title: call_title,
                            call_date: call_date,
                            call_description: call_description,
                            appointment_id: appointment_id,
                            client_id:client_id
                        },
                        success: function(data) {
                            // clear form
                            $('#app_call_title').val('');
                            $('#app_call_date').val('');
                            $('#app_call_description').val('');

                            //Update client calls
                            updateClientCalls()
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('Server error:'+textStatus);
                        }
                    });
                    $('#client_history').removeClass('loadingbox');
                } else {
                    alert('You must create appointment before adding calls');
                }
            });
            // заносим данные звонка в форму для просмотра
            $('body').on('click', '#table_calls .table-action-link', function() {
                var id = $(this).data('id');
//                console.log(id);

                $('#app_call_title').val($('#tr_'+id).find('.td_title').text());
                $('#app_call_date').val($('#tr_'+id).find('.td_date').text());
                $('#app_call_description').val($('#tr_'+id).find('.td_description').text());
                $('#app_call_id').val(id)
            });

            /*******************************
             * MISC.
             ******************************/

            // enable/disable related selects
            function updateRelatedSelects() {
                if ($('#app_employee_id option').size() == 0){
                    $('#app_employee_id').prop("disabled", true);
                } else {
                    $('#app_employee_id').prop("disabled", false);
                }
                if ($('#app_time_from option').size() == 0){
                    $('#app_time_from').prop("disabled", true);
                } else {
                    $('#app_time_from').prop("disabled", false);
                }
                if ($('#app_date_from option').size() == 0){
                    $('#app_date_from').prop("disabled", true);
                } else {
                    $('#app_date_from').prop("disabled", false);
                }
            }

            $('body').on('click', '.toggle-info', function() {
                var id = $(this).data('id');
                $("#info-section-"+id).toggle();
//                console.log("#info-section-"+id);
                $(this).find('.fa-caret-down').toggle();
                $(this).find('.fa-caret-up').toggle();
            });
        });

        /**
         * Actions with form alerts
         */
        function showFormSuccess(msg){
            $('#alerts_block').html('<div class="alert alert-success">'+msg+'</div>');
            $('#alerts_block').find('.alert').show();
        }
        function showFormError(msg){
            $('#alerts_block').html('<div class="alert alert-danger">'+msg+'</div>');
            $('#alerts_block').find('.alert').show();
        }
        function clearFormAlerts(){
            $('#alerts_block').html('');
            $('#alerts_block').find('.alert').hide();
        }

        // добавить сообщение об ошибке в блок
        function addErrorMessage(container,title,message){
            $('#'+container).html('<div class="alert alert-error" role="alert"><strong>'+title+':</strong> '+message+'</div>');
            $('#'+container).find('.alert').show();
        }

        // добавить сообщение об успехе в блок
        function addSuccessMessage(container,title,message){
            $('#'+container).html('<div class="alert alert-success" role="alert"><strong>'+title+':</strong> '+message+'</div>');
            $('#'+container).find('.alert').show();
        }
        // добавить сообщение об успехе в блок
        function clearMessages(){
            $('.sub-form-messages').html();
            $('.sub-form-messages .alert').hide();
        }
    </script>
@endsection
