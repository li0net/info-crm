<div class="hidden templates">
    <div id="card-items-tpl">
        <div class="wrap-it alt-control-bar">
            <div class="col-sm-5">
                {{ Form::select('storage_id[]', $storages, '0', ['class' => 'js-select-basic-single-alt', 'maxlength' => '110', 'id' => '']) }}
            </div>
            <div class="col-sm-4">
                {{ Form::select('product_id[]', [], null, 	[
                'class' => 'js-select-basic-single-alt',
                'maxlength' => '110',
                'placeholder' => trans('adminlte_lang::message.select_good')
                ]) }}
            </div>
            <div class="col-sm-2">
                {{ Form::text('amount[]', null, ['class' => 'form-control', 'maxlength' => '110']) }}
            </div>
            <div class="col-sm-1 text-center">
                <button type="button" id="add-card-item" class="btn btn-add">
                    <i class="fa fa-plus-circle"></i>
                    <i class="fa fa-trash-o"></i>
                </button>
            </div>
        </div>
    </div>

</div>