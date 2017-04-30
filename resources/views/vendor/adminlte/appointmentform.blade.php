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

        {{ Form::hidden('storage_options', null, ['id' => 'storage_options']) }}
        {{ Form::hidden('employee_options', null, ['id' => 'employee_options']) }}
        {{ Form::hidden('organization_id', $user->organization_id, ['id' => 'organization_id']) }}

        @if (isset($appointment))
        <input type="hidden" name="appointment_id" id="app_appointment_id" value="{{$appointment->appointment_id}}">
        @endif
        <div class="col-sm-4 nav-stacked-block" >
            <ul id="app_side_tabs" class="modal-menu list-group clear-list m-t nav nav-tabs nav-stacked">
                <li class="modal-menu-header nav-header">Визит</li>

                <li class="modal-menu-l record_tab list-group-item first-item active" data-toggle="tab" data-target="#body_client" >
                    <i class="fa fa-user"></i> Клиент</li>
                <li class="modal-menu-l record_tab list-group-item" data-toggle="tab" data-target="#body_service" >
                    <i class="fa fa-calendar"></i> Услуга</li>
                <li class="modal-menu-l visit_tab list-group-item" data-toggle="tab" data-target="#body_status">
                    <i class="fa fa-clock-o"></i> Статус визита</li>
                <li class="modal-menu-l payments_tab list-group-item" data-toggle="tab" data-target="#body_payments" >
                    <i class="fa fa-usd"></i> Оплата визита</li>
<!--                <li class="modal-menu-l reminds_tab list-group-item" data-toggle="tab" data-target="#body_reminds" >-->
<!--                    <i class="fa fa-comments-o"></i> Уведомления </li>-->
<!--                <li class="modal-menu-l history_tab list-group-item" data-toggle="tab" data-target="#body_history" >-->
<!--                    <i class="fa fa-file-text"></i> История изменений</li>-->
                <li class="modal-menu-l goods_history_tab list-group-item last-item" data-toggle="tab" data-target="#goods_history" >
                    <i class="fa fa-cubes"></i> Списание расходников</li>

                <li class="modal-menu-header client_header_tab nav-header">Клиент</li>

                <li class="modal-menu-l client_info_tab list-group-item first-item" data-toggle="tab" id="#rec_client_fulldata" data-target="#client_info" >
                    <i class="fa fa-address-card-o"></i> Данные клиента</li>
                <li class="modal-menu-l client_history_tab list-group-item" data-toggle="tab" data-target="#client_history" >
                    <i class="fa fa-list-alt"></i> История посещений</li>
                <li class="modal-menu-l client_statistics_tab list-group-item" data-toggle="tab"  data-target="#client_statistics" >
                    <i class="fa fa-pie-chart"></i> Статистика</li>
<!--                <li class="modal-menu-l sms_history_tab list-group-item" data-target="#sms_history" >-->
<!--                    <i class="fa fa-envelope"></i> Отправленные SMS</li>-->
<!--                <li class="modal-menu-l sms_tab list-group-item" data-target="#body_sms" >-->
<!--                    <i class="fa fa-send"></i> Отправить SMS</li>-->
<!--                <li class="modal-menu-l card_tab list-group-item" data-target="#body_card" >-->
<!--                    <i class="fa fa-qrcode"></i> Электронная карта</li>-->
                <li class="modal-menu-l client_loyalty_cards_tab list-group-item disabled" data-target="client_loyalty_cards_body"  >
                    <i class="fa fa-credit-card"></i> Карты лояльности</li>
                <li class="modal-menu-l phone_call_tabs list-group-item last-item"data-toggle="tab"  data-target="#client_calls" >
                    <i class="fa fa-phone"></i> История звонков</li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="col-sm-8 tab-pane fade in active" id="body_client">
                @include('appointment.tpl.body_client')
            </div>
             <div class="col-sm-8 tab-pane fade" id="body_service">
                @include('appointment.tpl.body_service')
            </div>
            <div class="col-sm-8 tab-pane fade" id="body_status">
                @include('appointment.tpl.body_status')
            </div>
            <div class="col-sm-8 tab-pane fade" id="body_payments">
                @include('appointment.tpl.body_payments')
            </div>
<!--            <div class="col-sm-8 tab-pane fade" id="body_reminds">-->

<!--            </div>-->
<!--            <div class="col-sm-8 tab-pane fade" id="body_history">-->
<!--                @include('appointment.tpl.body_history')-->
<!--            </div>-->
            <div class="col-sm-8 tab-pane fade" id="goods_history">
                @include('appointment.tpl.body_goods_history')
            </div>

            <div class="col-sm-8 tab-pane fade" id="client_info"></div>
            <div class="col-sm-8 tab-pane fade" id="client_history">Client history</div>
            <div class="col-sm-8 tab-pane fade" id="client_statistics"></div>
            <div class="col-sm-8 tab-pane fade" id="client_calls">
                @include('appointment.tpl.body_client_calls')
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
@endsection

@section('page-specific-scripts')
    <script type="text/javascript">
        $(document).ready(function($) {
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

            // Update data at client tabs
            updateClientData();

            // Client dropdown change event
            $('#app_client_id').on('change', function(){
                updateClientData();
            });

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
                            console.log(data);
                            $('#client_info').html(data);
//                        if (data != "[][]") {
//                            var data = $.parseJSON(data);
//                            for (var i in data) {
//                                $('<option>').val(data[i]).text(data[i]).appendTo('#app_date_from');
//                            }
//                            $('#app_date_from').prop("disabled", false);
//                        } else {
//                            $('#app_date_from').prop("disabled", true);
//                        }
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
                            console.log(data);
                            $('#client_statistics').html(data);
//                        if (data != "[][]") {
//                            var data = $.parseJSON(data);
//                            for (var i in data) {
//                                $('<option>').val(data[i]).text(data[i]).appendTo('#app_date_from');
//                            }
//                            $('#app_date_from').prop("disabled", false);
//                        } else {
//                            $('#app_date_from').prop("disabled", true);
//                        }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('Server error:'+textStatus);
                        }
                    });
                }
            }

            if ( $('#app_employee_id > option').length == 0) {
                $('#service_employee').text('Сотрудник не выбран');
            } else {
                var employee_name = $('#app_employee_id option:selected').text();
                $('#service_employee').text('' == employee_name ? $('#app_employee_id option:first').text() : employee_name);
            }
            $('#service_name').text($('#app_service_id option:selected').text());

            $('.goods_transactions_box').on('change', 'select[name="storage_id[]"]', function(e){
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

            // Service dropdown change event
            $('#app_service_id').on('change', function(){
                $('#app_service_id_empty').remove();
                // удаляем все опции из селекта с сотрудниками
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
                            var data = $.parseJSON(data);
                            for (var i in data) {
                                $('<option>').val(data[i].value).text(data[i].label).appendTo('#app_employee_id');
                            }

                            $('#service_name').text($('#app_service_id option:selected').text());
                            if ( $('#app_employee_id > option').length == 0) {
                                $('#service_employee').text('Сотрудник не выбран');
                            } else {
                                var employee_name = $('#app_employee_id option:selected').text();
                                $('#service_employee').text('' == employee_name ? $('#app_employee_id option:first').text() : employee_name);
                            }
                            $('#app_employee_id').prop("disabled", false);
                        } else {
                            $('#app_employee_id').prop("disabled", true);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert('Server error:'+textStatus);
                    }
                });
            });

            $('#app_employee_id').on('change', function(){
                if ( $('#app_employee_id > option').length == 0) {
                    $('#service_employee').text('Сотрудник не выбран');
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

            $('#app_date_from').on('change', function(){
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

            $('#app_time_from').on('change', function(){
               $('#app_duration_hours').prop("disabled", false);
               $('#app_duration_minutes').prop("disabled", false);
            });

            $('.toggle-info').on('click', function() {
                var id = $(this).data('id');
                $("#info-section-"+id).toggle();
                console.log("#info-section-"+id);Z
                $(this).find('.fa-caret-down').toggle();
                $(this).find('.fa-caret-up').toggle();

            });
            $('#add_good_transaction').on('click', function() {
                $('.goods_transactions_box').append(
                    '<div id="vis_sale_box_1" class="goods_sale m-b col-sm-12 alt-control-bar"><div class="row"><div class="col-sm-4"><label>Склад</label></div> <div class="col-sm-4"><label>Товар</label></div> <div class="col-sm-4"><label>Сотрудник</label></div></div> <div class="row"><div class="col-sm-4"><select data-initial-value="0" name="storage_id[]" class="js-select-basic-single"></select></div> <div class="col-sm-4"><select data-initial-value="0" name="product_id[]" class="js-select-basic-single"></select></div> <div class="col-sm-4"><select data-initial-value="0" name="master_id[]" class="js-select-basic-single"></option></select></div></div> <div class="row"><div class="col-sm-2"><label>Количество</label></div> <div class="col-sm-2"><label>Цена, ₽</label></div> <div class="col-sm-2"><label>Скидка, %</label></div> <div class="col-sm-2"><label>Итог, ₽</label></div></div> <div class="row"><div class="col-sm-2 "><input data-number="1" type="text" name="amount[]" value="1" placeholder="Кол-во" class="form-control input-sm sg_amount add_goods_amount_input_1"></div> <div class="col-sm-2"><input data-number="1" type="text" name="price[]" value="0" class="form-control input-sm sg_price add_goods_price_input_1"></div> <div class="col-sm-2"><input data-number="1" type="text" name="discount[]" value="0" class="form-control input-sm sg_discount add_goods_discount_input_1"></div> <div class="col-sm-2"><input data-number="1" type="text" name="sum[]" value="0" class="form-control input-sm sg_cost add_goods_cost_input_1"></div> <div class="col-sm-4 text-right"><button id="remove_good_transaction" class="btn btn-danger" ><i class="fa fa-trash-o"></i></button></div></div></div>');

                $('select.form-control[name="storage_id[]"]').last().find('option').remove();
                $('select.form-control[name="storage_id[]"]').last().append($('#storage_options').val());

                $('select.form-control[name="master_id[]"]').last().find('option').remove();
                $('select.form-control[name="master_id[]"]').last().append($('#employee_options').val());

                $(".alt-control-bar .js-select-basic-single").select2({
                    theme: "alt-control",
                    minimumResultsForSearch: Infinity
                }).on("select2:open", function () {
                    $('.select2-results__options').niceScroll({cursorcolor:"#969696", cursorborder: "1px solid #444", cursorborderradius: "0", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
                });
            });

            $('.goods_transactions_box').on('click', '#remove_good_transaction', function(e) {
                $(e.target).parents('.goods_sale').remove();
            });


            $('#btn_app_form_create_client').on('click', function() {
                var name = $('#app_new_client_name').val();
                var phone = $('#app_new_client_phone').val();
                var email = $('#app_new_client_email').val();

                //TODO нормальный вывод
                if (phone == '' || name == ''){
                    alert('Name and Phone fields are required');
                    return;
                }
                $('#body_client .tab-content').addClass('loadingbox');
                $.ajax({
                    type: "POST",
                    url: "/appointments/findClient/",
                    data: {'organization_id': $('#organization_id').val(), 'client_name': name,'client_phone':phone, 'client_email':email},
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

            // Calls form
            $('#save_call_info').on('click', function(e) {
                // getting data
                var call_title = $('#app_call_title').val();
                var call_date = $('#app_call_date').val();
                var call_description = $('#app_call_description').val();
                var client_id = $('#app_client_id').val();
                var call_id = $('#app_call_id').val();

                if (call_title =='' || call_date =='' || call_description ==''){
                    alert('All call form\'s fields are required');
                    return;
                }

                if ($('#app_appointment_id').length && $('#app_appointment_id').val() !=''){
                    // loader animation
                    $('#client_history').addClass('loadingbox');

                    var appointment_id = ($('#app_call_appointment_id').val()=='') ? $('#app_call_appointment_id').val() : $('#app_appointment_id').val();

                    console.log(call_title, call_date, call_description,appointment_id,client_id);

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
                            console.log(data);
                            // clear form
                            $('#call_title').val('');
                            $('#call_date').val('');
                            $('#call_description').val('');

//                            // clear clients select
//                            $("#app_client_id option").each(function() {
//                                $(this).remove();
//                            });
//
//                            for (var i in data.clients) {
//                                $('<option>').val(data.clients[i].client_id).text(data.clients[i].name).appendTo('#app_client_id');
//                            }
//                            // set new client checked
//                            $('#app_client_id').val(data.client.client_id).prop('selected', true);
//
//                            $('#body_client a:first').tab('show');
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

            $('#app_call_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                firstDay: 1
            });
        });
    </script>
@endsection
