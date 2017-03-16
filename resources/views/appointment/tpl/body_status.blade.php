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
            @if(isset($appointment))
                {{--<label>{{ $appointment->service->name }}</label>--}}
                {{ Form::label('', $appointment->service->name, ['v-model' => 'service_name']) }}
            @else
                <label>@{{ service_name }}</label>
            @endif
        </div>
        <div class="col-sm-3">
            @if(isset($appointment))
                {{--<label>{{ $appointment->employee->name }}</label>--}}
                {{ Form::label('', $appointment->employee->name, ['v-model' => 'service_employee']) }}
            @else
                <label>@{{ service_employee }}</label>
            @endif
        </div>
        <div class="col-sm-2">
            {{ Form::text(
                "service_price",
                isset($appointment) ? $appointment->service_price : null,
                ['class' => 'form-control input-sm neo_visit_rec_cost', 'placeholder' => trans('adminlte_lang::message.price')]
            ) }}
        </div>
        <div class="col-sm-2">
            {{ Form::text(
                "service_discount",
                isset($appointment) ? $appointment->service_discount : null,
                ['class' => 'form-control input-sm neo_visit_rec_discount', 'placeholder' => trans('adminlte_lang::message.discount')]
            ) }}
        </div>
        <div class="col-sm-2">
            {{ Form::text(
                "service_sum",
                isset($appointment) ? $appointment->service_sum : null,
                ['class' => 'form-control input-sm neo_visit_rec_real', 'placeholder' => trans('adminlte_lang::message.sum')]
            ) }}
        </div>
    </div>

    <hr class="hr-line-dashed">

    <div class="form-group sale_product goods-content to-hide to-hide2" style="display: block;">
        <h4 class="col-sm-12">Продажа товаров</h4>
        <div class="goods_transactions_box">
            @if(isset($transactions))
                @foreach($transactions as $transaction)
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
                                {{ Form::select('storage_id[]', [], null, ['class' => 'form-control input-sm', 'data-initial-value' => $transaction->storage1_id]) }}
                            </div>
                            <div class="col-sm-4">
                                {{ Form::select('product_id[]', $storages[$transaction->storage1_id]->pluck('title', 'product_id')->all(), $transaction->product_id, ['class' => 'form-control input-sm', 'data-initial-value' => $transaction->product_id]) }}
                            </div>
                            <div class="col-sm-4">
                                {{ Form::select('master_id[]', $employees, null, ['class' => 'form-control input-sm', 'data-initial-value' => $transaction->employee_id]) }}
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
                                {{ Form::text(
                                    "amount[]",
                                    $transaction->amount,
                                    ['class' => 'form-control input-sm sg_amount add_goods_amount_input_1', 'placeholder' => trans('adminlte_lang::message.amount')]
                                ) }}
                            </div>
                            <div class="col-sm-2">
                                {{ Form::text(
                                    "price[]",
                                    $transaction->price,
                                    ['class' => 'form-control input-sm sg_price add_goods_price_input_1', 'placeholder' => trans('adminlte_lang::message.price')]
                                ) }}
                            </div>
                            <div class="col-sm-2">
                                {{ Form::text(
                                    "discount[]",
                                    $transaction->discount,
                                    ['class' => 'form-control input-sm sg_discount add_goods_discount_input_1', 'placeholder' => trans('adminlte_lang::message.discount')]
                                ) }}
                            </div>
                            <div class="col-sm-2">
                                {{ Form::text(
                                    "sum[]",
                                    $transaction->sum,
                                    ['class' => 'form-control input-sm sg_cost add_goods_cost_input_1', 'placeholder' => trans('adminlte_lang::message.sum')]
                                ) }}
                            </div>
                            <div class="col-sm-4">
                                <input type="button" id="remove_good_transaction" class="btn btn-white btn-sm center-block" value="Отменить">
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-sm-3">
            <input type="button" id="add_good_transaction" class="btn btn-primary btn-sm" value="Добавить товар">
        </div>
    </div>
</div>