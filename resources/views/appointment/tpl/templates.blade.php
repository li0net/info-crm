<div class="wrap-it alt-control-bar">
    <div class="col-sm-5">
        {{ Form::select('card_storage_id[]', $storages, '',
            [
            'placeholder' => trans('adminlte_lang::message.select_storage'),
            'class' => 'form-control',
            'maxlength' => '110',
            'id' => ''
            ]
        ) }}
    </div>
    <div class="col-sm-4">
        {{ Form::select('card_product_id[]', [], null,
            [
                'placeholder' => trans('adminlte_lang::message.select_good'),
                'class' => 'form-control',
                'maxlength' => '110',
            ]
        ) }}
    </div>
    <div class="col-sm-2">
        {{ Form::text('card_amount[]', null, ['class' => 'form-control text-center', 'maxlength' => '110']) }}
    </div>
    <div class="col-sm-1 text-center">
        <button type="button" id="add-card-item" class="btn btn-add">
            <i class="fa fa-plus-circle"></i>
            <i class="fa fa-trash-o"></i>
        </button>
    </div>
</div>