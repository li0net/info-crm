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
                        <div class="form-group m-b">
                            <div class="col-sm-12">
                                <div class="btn-group in_status" data-toggle="buttons">
                                    <label class="btn btn-outline btn-success btn-sm active">
                                        <input type="radio" name="options" id="option1" autocomplete="off" checked>
                                        <i class="fa fa-clock-o"></i> <span class="hidden-xs">ожидание клиента</span>
                                    </label>
                                    <label class="btn btn-outline btn-success btn-sm">
                                        <input type="radio" name="options" id="option2" autocomplete="off">
                                        <i class="fa fa-plus-circle"></i> <span class="hidden-xs">клиент пришел</span>
                                    </label>
                                    <label class="btn btn-outline btn-success btn-sm">
                                        <input type="radio" name="options" id="option3" autocomplete="off">
                                        <i class="fa fa-minus-circle"></i> <span class="hidden-xs">клиент не пришел</span>
                                    </label>
                                    <label class="btn btn-outline btn-success btn-sm">
                                        <input type="radio" name="options" id="option4" autocomplete="off">
                                        <i class="fa fa-check-circle"></i> <span class="hidden-xs">клиент подтвердил</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row m-t">
                        {!! Form::open(['url' => '/appointments/save', 'id' => 'appointment_form']) !!}
                            {{ Form::hidden('storage_options', null, ['id' => 'storage_options']) }}
                            @if (isset($appointment))
                                <input type="hidden" name="appointment_id" id="app_appointment_id" value="{{$appointment->appointment_id}}">
                            @endif
                            <div class="col-sm-4 b-r">
                                <ul class="modal-menu list-group clear-list m-t nav nav-tabs nav-stacked">
                                    <li class="modal-menu-header nav-header">Визит</li><br>
                                        <li class="modal-menu-l record_tab list-group-item first-item active" data-toggle="tab" data-target="#body_record" style="display: block;">
                                            <i class="fa fa-calendar"></i> Запись</li>
                                        <li class="modal-menu-l visit_tab list-group-item" data-toggle="tab" data-target="#body_status">
                                            <i class="fa fa-clock-o"></i> Статус визита</li>
                                        <li class="modal-menu-l payments_tab list-group-item" data-toggle="tab" data-target="#body_payments" style="display: block;">
                                            <i class="fa fa-usd"></i> Оплата визита</li>
                                        <li class="modal-menu-l reminds_tab list-group-item" data-toggle="tab" data-target="#body_reminds" style="display: block;">
                                            <i class="fa fa-comments-o"></i> Уведомления </li>
                                        <li class="modal-menu-l history_tab list-group-item" data-toggle="tab" data-target="#body_history" style="display: block;">
                                            <i class="fa fa-file-text"></i> История изменений</li>
                                        <li class="modal-menu-l goods_history_tab list-group-item" data-toggle="tab" data-target="#goods_history" style="display: block;">
                                            <i class="fa fa-cubes"></i> Списание расходников</li>
                                    <br>
                                    <li class="modal-menu-header client_header_tab nav-header" style="display: list-item;">Клиент</li><br>
                                        <li class="modal-menu-l client_tab list-group-item first-item" id="#rec_client_fulldata" data-target="client_edit" style="display: block;">
                                            <i class="fa fa-user"></i> Данные клиента</li>
                                        <li class="modal-menu-l visit_history_tab list-group-item" data-target="#visit_history" style="display: block;">
                                            <i class="fa fa-list-alt"></i> История посещений</li>
                                        <li class="modal-menu-l client_stats_tab list-group-item" data-target="#client_stats" style="display: block;">
                                            <i class="fa fa-pie-chart"></i> Статистика</li>
                                        <li class="modal-menu-l sms_history_tab list-group-item" data-target="#sms_history" style="display: block;">
                                            <i class="fa fa-envelope"></i> Отправленные SMS</li>
                                        <li class="modal-menu-l sms_tab list-group-item" data-target="#body_sms" style="display: block;">
                                            <i class="fa fa-send"></i> Отправить SMS</li>
                                        <li class="modal-menu-l card_tab list-group-item" data-target="#body_card" style="display: block;">
                                            <i class="fa fa-qrcode"></i> Электронная карта</li>
                                        <li class="modal-menu-l client_loyalty_cards_tab list-group-item" data-target="client_loyalty_cards_body"  style="display: block;">
                                            <i class="fa fa-credit-card"></i> Карты лояльности</li>
                                        <li class="modal-menu-l phone_call_tabs list-group-item" data-target="phone_call_body" style="display: block;">
                                            <i class="fa fa-phone"></i> История звонков</li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="col-sm-8 tab-pane fade in active" id="body_record">
                                    @include('appointment.tpl.body_record')
                                </div>
                                <div class="col-sm-8 tab-pane fade" id="body_status">
                                    @include('appointment.tpl.body_status')
                                </div>
                                <div class="col-sm-8 tab-pane fade" id="body_payments">
                                    @include('appointment.tpl.body_payments')
                                </div>
                                <div class="col-sm-8 tab-pane fade" id="body_reminds">
                                    @include('appointment.tpl.body_reminds')
                                </div>
                                <div class="col-sm-8 tab-pane fade" id="body_history">
                                    @include('appointment.tpl.body_history')
                                </div>
                                <div class="col-sm-8 tab-pane fade" id="goods_history">
                                    @include('appointment.tpl.goods_history')
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

            $('#vis_sale_box_1').on('change', 'select[name="storage_id[]"]', function(e){
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
        });
    </script>
@endsection
