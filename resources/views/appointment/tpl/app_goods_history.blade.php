<input type="hidden" name="app_need_save_history" id="app_need_save_history" value="1">
@if (count($dischargeItems) > 0)
    <input type="hidden" name="use_routing_card_block" val="0"/>
    {{--отображаем списанные товары--}}
    <div id="card-items" class="form-group col-sm-12">
        <div class="wrap-it">
            <div class="col-sm-5">{{ trans('adminlte_lang::message.stock') }}</div>
            <div class="col-sm-4">{{ trans('adminlte_lang::message.title') }}</div>
            <div class="col-sm-2">{{ trans('adminlte_lang::message.amount') }}</div>
            <div class="col-sm-1"></div>
            <div class="col-sm-12">
                <hr>
            </div>
        </div>
        @foreach( $dischargeItems as $card_item )
            <div class="wrap-it alt-control-bar">
                <div class="col-sm-5">
                    {{ Form::select('card_storage_id[]', $storages, $card_item[0],
                        [
                            'placeholder' => trans('adminlte_lang::message.select_storage'),
                            'class' => 'js-select-basic-single-alt',
                            'maxlength' => '110',
                            'data-initial-value' => $card_item[0]
                        ]
                    )}}
                </div>
                <div class="col-sm-4">
                    {{ Form::select('card_product_id[]', $products[$card_item[0]]->pluck('title', 'product_id')->all() , $card_item[1],
                        [
                            'placeholder' => trans('adminlte_lang::message.select_good'),
                            'class' => 'js-select-basic-single-alt',
                            'maxlength' => '110'
                        ]
                    )}}
                </div>
                <div class="col-sm-2">
                    {{ Form::text('card_amount[]', $card_item[2], ['class' => 'form-control text-center', 'maxlength' => '110']) }}
                </div>
                <div class="col-sm-1 text-center">
                    <button type="button" id="add-card-item" class="btn btn-remove">
                        <i class="fa fa-plus-circle"></i>
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        @endforeach

        @include('appointment.tpl.templates')

    </div>
@elseif (count($cardItems) > 0)
    {{--отображаем доступную карту--}}
    <input type="hidden" name="use_routing_card_block" val="1"/>
    <div class="form-group col-sm-12">
        <label class="col-sm-12 text-left use_routing_card_block">
            {{ Form::checkbox('use_routing_card', 1, 0 ) }}
            {{ trans('adminlte_lang::message.use_routing_card') }}
        </label>
    </div>
    <div id="card-items" class="form-group col-sm-12 disabled">
        <div class="wrap-it">
            <div class="col-sm-5">{{ trans('adminlte_lang::message.stock') }}</div>
            <div class="col-sm-4">{{ trans('adminlte_lang::message.title') }}</div>
            <div class="col-sm-2">{{ trans('adminlte_lang::message.amount') }}</div>
            <div class="col-sm-1"></div>
            <div class="col-sm-12">
                <hr>
            </div>
        </div>
        @foreach( $cardItems as $card_item )
            <div class="wrap-it alt-control-bar">
                <div class="col-sm-5">
                    {{ Form::select('card_storage_id[]', $storages, $card_item[0],
                        [
                            'placeholder' => trans('adminlte_lang::message.select_storage'),
                            'class' => 'js-select-basic-single-alt',
                            'maxlength' => '110',
                            'data-initial-value' => $card_item[0]
                        ]
                    )}}
                </div>
                <div class="col-sm-4">
                    {{ Form::select('card_product_id[]', $products[$card_item[0]]->pluck('title', 'product_id')->all() , $card_item[1],
                        [
                            'placeholder' => trans('adminlte_lang::message.select_good'),
                            'class' => 'js-select-basic-single-alt',
                            'maxlength' => '110'
                        ]
                    )}}
                </div>
                <div class="col-sm-2">
                    {{ Form::text('card_amount[]', $card_item[2], ['class' => 'form-control text-center', 'maxlength' => '110']) }}
                </div>
                <div class="col-sm-1 text-center">
                    <button type="button" id="add-card-item" class="btn btn-remove">
                        <i class="fa fa-plus-circle"></i>
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        @endforeach

        @include('appointment.tpl.templates')

    </div>
@else
    <div class="form-group col-sm-12">
        <h4>
            {{ trans('adminlte_lang::message.no_routing_cards') }}
        </h4>
    </div>
@endif

<!--templates-->
<div class="hidden templates">
    <div id="card-items-tpl">
        @include('appointment.tpl.templates')
    </div>
    <div id="select_storage-placeholder-tpl">
        @lang('adminlte_lang::message.select_storage')
    </div>
</div>
<!--templates-->