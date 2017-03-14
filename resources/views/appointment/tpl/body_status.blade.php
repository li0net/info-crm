<div class="col-sm-12">
    <div class="row m-b">
        <div class="col-sm-3">
            <label>Услуга</label>
        </div>
        <div class="col-sm-3">
            <label>Сотрудник</label>
        </div>
        <div class="col-sm-2">
            <label>Цена, ₽</label>
        </div>
        <div class="col-sm-2">
            <label>Скидка, %</label>
        </div>
        <div class="col-sm-2">
            <label>Итог, ₽</label>
        </div>
    </div>

    <div class="row m-b">
        <div class="col-sm-3">
            <label>{{ $appointment->service->name }}</label>
        </div>
        <div class="col-sm-3">
            <label>{{ $appointment->employee->name }}</label>
        </div>
        <div class="col-sm-2">
            <input class="neo_visit_rec_cost form-control input-sm" data-type="1" data-rec="15110305" data-target="529105" type="text" name="cost" value="0">
        </div>
        <div class="col-sm-2">
            <input class="neo_visit_rec_discount form-control input-sm" data-type="1" data-rec="15110305" data-target="529105" type="text" name="discount" value="0">
        </div>
        <div class="col-sm-2">
            <input class="neo_visit_rec_real form-control input-sm" data-type="1" data-rec="15110305" data-target="529105" type="text" name="real" value="0">
        </div>
    </div>

    <hr class="hr-line-dashed">

    <div class="form-group sale_product goods-content to-hide to-hide2" style="display: block;">
        <h4 class="col-sm-12">Продажа товаров</h4>
        <div class="goods_transactions_box">
            <div class="goods_sale m-b col-sm-12" data-number="1" id="vis_sale_box_1">
                <div class="row">
                    <div class="col-sm-4">
                        <label>Склад</label>
                    </div>
                    <div class="col-sm-4">
                        <label>Товар</label>
                    </div>
                    <div class="col-sm-4">
                        <label>Сотрудник</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        {{ Form::select('storage_id[]', [], null, ['class' => 'form-control input-sm', 'data-initial-value' => 0]) }}
                    </div>
                    <div class="col-sm-4">
                        {{ Form::select('product_id[]', [], null, ['class' => 'form-control input-sm', 'data-initial-value' => 0]) }}
                        {{--{{ Form::select('product_id[]', $storages[$card_item[0]]->pluck('title', 'product_id')->all(), $card_item[1], ['class' => 'form-control', 'maxlength' => '110']) }}--}}
                        {{--<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input" type="text" id="add_goods_input_1" name="goods" value="" placeholder="Товар или артикул" autocomplete="off">--}}
                        {{--<input type="hidden" id="goods_transaction_id_1" value="undefined">--}}
                        {{--<input type="hidden" id="good_id_1" value="0">--}}
                        {{--<input type="hidden" id="unit_id_1" value="undefined">--}}
                        {{--<input type="hidden" id="certif_type_id_1" value="undefined">--}}
                        {{--<div id="add_goods_ac_box_1" class="neo-dropdown"><ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content ui-corner-all neo_autocomplete_results" id="ui-id-101" tabindex="0" style="display: none;"></ul></div>--}}
                    </div>
                    <div class="col-sm-4">
                        {{ Form::select('employee_id[]', $employees, null, ['class' => 'form-control input-sm', 'data-initial-value' => 0]) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <label>Количество</label>
                    </div>
                    <div class="col-sm-2">
                        <label>Цена, ₽</label>
                    </div>
                    <div class="col-sm-2">
                        <label>Скидка, %</label>
                    </div>
                    <div class="col-sm-2">
                        <label>Итог, ₽</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 ">
                        <input data-number="1" class="form-control input-sm sg_amount add_goods_amount_input_1" type="text" name="amount" value="1" placeholder="Кол-во">
                    </div>
                    <div class="col-sm-2">
                        <input data-number="1" class="form-control input-sm sg_price add_goods_price_input_1" type="text" name="price" value="0">
                    </div>
                    <div class="col-sm-2">
                        <input data-number="1" class="form-control input-sm sg_discount add_goods_discount_input_1" type="text" name="discount" value="0">
                    </div>
                    <div class="col-sm-2">
                        <input data-number="1" class="form-control input-sm sg_cost add_goods_cost_input_1" type="text" name="real" value="0">
                    </div>
                    <div class="col-sm-4">
                        <input type="button" id="remove_good_transaction" class="btn btn-white btn-sm center-block" value="Отменить">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <input type="button" id="add_good_transaction" class="btn btn-primary btn-sm" value="Добавить товар">
        </div>
    </div>
</div>