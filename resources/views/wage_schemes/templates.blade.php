<div class="hidden templates">
    <div id="detailed-products-tpl">
        <div class="wrap-it alt-control-bar">
            <div class="col-sm-11">
                <div class="col-sm-4">
                    {{ Form::select('products_cats_detailed[]', [], null, ['class' => 'js-select-basic-single-alt', 'placeholder' => 'Category']) }}
                </div>
                <div class="col-sm-4">
                    {{ Form::select('products_detailed[]', [], null, ['class' => 'js-select-basic-single-alt', 'placeholder' => trans('adminlte_lang::message.select_good')]) }}
                </div>
                <div class="col-sm-2">
                    {{ Form::text('products_percent_detailed[]', null, ['class' => 'form-control', 'maxlength' => '110', 'placeholder' => 'Percent']) }}
                </div>
                <div class="col-sm-2">
                    {{ Form::select('products_unit_detailed[]', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'js-select-basic-single-alt', 'placeholder' => trans('adminlte_lang::message.unit')]) }}
                </div>
            </div>
            <div class="col-sm-1 text-center">
                <button type="button" id="add-detailed-section" class="btn btn-add">
                    <i class="fa fa-plus-circle"></i>
                    <i class="fa fa-trash-o"></i>
                </button>
            </div>
        </div>
    </div>
    <div id="detailed-services-tpl">
        <div class="wrap-it alt-control-bar">
            <div class="col-sm-11">
                <div class="col-sm-4">
                    {{ Form::select('services_cats_detailed[]', [], null, ['class' => 'js-select-basic-single-alt', 'maxlength' => '110']) }}
                </div>
                <div class="col-sm-4">
                    {{ Form::select('services_detailed[]', [], null, ['class' => 'js-select-basic-single-alt', 'maxlength' => '110']) }}
                </div>
                <div class="col-sm-2">
                    {{ Form::text('services_percent_detailed[]', null, ['class' => 'form-control', 'maxlength' => '110']) }}
                </div>
                <div class="col-sm-2">
                    {{ Form::select('services_unit_detailed[]', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'js-select-basic-single-alt', 'maxlength' => '110']) }}
                </div>
            </div>
            <div class="col-sm-1 text-center" style="">
                <button type="button" id="add-detailed-section" class="btn btn-add">
                    <i class="fa fa-plus-circle"></i>
                    <i class="fa fa-trash-o"></i>
                </button>
            </div>
        </div>
    </div>
</div>