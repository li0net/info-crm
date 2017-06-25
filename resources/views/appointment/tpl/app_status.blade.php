<input type="hidden" name="app_need_save_status" id="app_need_save_status" value="1">
<div class="col-sm-12">
    <div class="row m-b alt-control-bar">
        <div class="col-sm-3">
            <label>@lang('adminlte_lang::message.service')</label>
        </div>
        <div class="col-sm-3">
            <label>@lang('adminlte_lang::message.employee')</label>
        </div>
        <div class="col-sm-2">
            <label>@lang('adminlte_lang::message.price_val')</label>
        </div>
        <div class="col-sm-2">
            <label>@lang('adminlte_lang::message.discount_val')</label>
        </div>
        <div class="col-sm-2">
            <label>@lang('adminlte_lang::message.total_val')</label>
        </div>
    </div>

    <div class="row m-b alt-control-bar">
        <div class="col-sm-3">
            @if(isset($appointment))
                {{ Form::label('', $appointment->service->name, ['id' => 'service_name']) }}
            @else
                {{ Form::label('', trans('adminlte_lang::message.employee_not_chosen'), ['id' => 'service_name']) }}
            @endif
        </div>
        <div class="col-sm-3">
            @if(isset($appointment))
            {{ Form::label('', $appointment->employee->name, ['id' => 'service_employee']) }}
            @else
            {{ Form::label('', trans('adminlte_lang::message.service_not_chosen'), ['id' => 'service_employee']) }}
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
            (isset($appointment)&& !empty($appointment->service_discount)) ? $appointment->service_discount : 0,
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

    <div class="form-group sale_product goods-content to-hide to-hide2 alt-control-bar" style="display: block;">
        <h2>@lang('adminlte_lang::message.goods_sale')</h2>
        <div class="goods_transactions_box">
            @if(isset($transactions))
                <?php $i=0; ?>
                @foreach($transactions as $transaction)
                    <div class="goods_sale m-b col-sm-12 alt-control-bar" data-number="{{$i}}" id="vis_sale_box_{{$i}}">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>@lang('adminlte_lang::message.stock')</label>
                            </div>
                            <div class="col-sm-4">
                                <label>@lang('adminlte_lang::message.good')</label>
                            </div>
                            <div class="col-sm-4">
                                <label>@lang('adminlte_lang::message.employee')</label>
                            </div>
                        </div>
                        <div class="row alt-control-bar">
                            <div class="col-sm-4">
                                {{ Form::select('storage_id[]', $storages, null, ['class' => 'js-select-basic-single-alt', 'data-initial-value' => $transaction->storage1_id]) }}
                            </div>
                            <div class="col-sm-4">
                                {{ Form::select('product_id[]', $products[$transaction->storage1_id]->pluck('title', 'product_id')->all(), $transaction->product_id, ['class' => 'js-select-basic-single-alt', 'data-initial-value' => $transaction->product_id]) }}
                            </div>
                            <div class="col-sm-4">
                                {{ Form::select('master_id[]', $transactionEmployeesOptions, $transaction->employee_id, ['class' => 'js-select-basic-single-alt', 'data-initial-value' => $transaction->employee_id]) }}
                            </div>
                        </div>
                        <div class="row alt-control-bar">
                            <div class="col-sm-2">
                                <label>{{ trans('adminlte_lang::message.amount') }}</label>
                            </div>
                            <div class="col-sm-2">
                                <label>{{ trans('adminlte_lang::message.price_val') }}</label>
                            </div>
                            <div class="col-sm-2">
                                <label>{{ trans('adminlte_lang::message.discount_val') }}</label>
                            </div>
                            <div class="col-sm-2">
                                <label>{{ trans('adminlte_lang::message.total_val') }}</label>
                            </div>
                        </div>
                        <div class="row alt-control-bar">
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
                            <div class="col-sm-4 text-right">
                                <div id="remove_good_transaction" class="btn btn-danger"><i class="fa fa-trash-o"></i></div>
                            </div>
                        </div>
                    </div>
                    <?php $i++; ?>
                @endforeach
            @endif
        </div>
        <div class="text-right">
            <input type="button" id="add_good_transaction" class="btn btn-info" value="@lang('adminlte_lang::message.add_product')">
        </div>
    </div>
</div>