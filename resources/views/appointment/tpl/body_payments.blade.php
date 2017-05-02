<div class="record-body body_payments" id="neo_payments_div">
    <div id="payments_content" >
        <div class="form-group">
            <table class="table table-bordered table-hover table-bg-white">
                <thead>
                    <tr >
                        <td class="col-xs-5">@lang('adminlte_lang::message.good_service')</td>
                        <td class="col-xs-2 text-center">@lang('adminlte_lang::message.price_val')</td>
                        <td class="col-xs-2 text-center">@lang('adminlte_lang::message.paid_val')</td>
                        <td class="col-xs-2 text-center">@lang('adminlte_lang::message.balance_val')</td>
                        <td class="col-xs-1">@lang('adminlte_lang::message.details')</td>
                    </tr>
                </thead>

                <tbody class="section-header">
                    <tr class="details-row toggle-info-section" data-section-id="1">
                        <td class="col-xs-5">Свадебный</td>
                        <td class="col-xs-2 text-center">0</td>
                        <td class="col-xs-2 text-center" id="section-header-paid-1">0</td>
                        <td class="col-xs-2 text-center" id="section-header-unpaid-1">0</td>
                        <td class="col-xs-1 text-center">
                            <a  href='#' data-id="1" class="btn btn-link toggle-info"><i class="fa fa-caret-down"></i><i class="fa fa-caret-up"></i></a>
                        </td>
                    </tr>
                </tbody>
                <tbody id="info-section-1" class="info-section" data-id="1">
                    <tr class="small total-row">
                        <td class="col-xs-5"></td>
                        <td class="col-xs-2 text-center">
                            <span class="section-subtotal-title" id="section-subtotal-title-1" >Итог:</span>
                        </td>
                        <td class="text-center" id="section-footer-paid-1">0</td>
                        <td class="text-center" id="section-footer-unpaid-1">0</td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
                <tbody class="section-header">
                    <tr class="details-row toggle-info-section" data-section-id="2">
                        <td class="col-xs-5">Деловой</td>
                        <td class="col-xs-2 text-center" >0</td>
                        <td class="col-xs-2 text-center" id="section-header-paid-2">0</td>
                        <td class="col-xs-2 text-center" id="section-header-unpaid-2">0</td>
                        <td class="col-xs-1 text-center">
                            <a  href='#' data-id="2" class="btn btn-link toggle-info"><i class="fa fa-caret-down"></i><i class="fa fa-caret-up"></i></a>
                        </td>
                        </td>
                    </tr>
                </tbody>
                <tbody id="info-section-2" class="info-section" data-id="2">
                    <tr class="small total-row">
                        <td class="col-xs-5"></td>
                        <td class="col-xs-2 text-center">
                            <span class="section-subtotal-title" id="section-subtotal-title-2">Итог:</span>
                        </td>
                        <td class="text-center" id="section-footer-paid-2">0</td>
                        <td class="text-center" id="section-footer-unpaid-2">0</td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
                <tbody class="section-header">
                </tbody>
            </table>

            <table class="table table-bordered table-hover payments-total-table">
                <thead>
                <tr class="details-row">
                    <td class="col-xs-5">@lang('adminlte_lang::message.paid_total')</td>
                    <td class="col-xs-2 text-center">0</td>
                    <td class="col-xs-2 text-center">0</td>
                    <td class="col-xs-2 text-center"></td>
                    <td class="col-xs-1 text-center"></td>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <hr class="hr-line-dashed">

            <h3>@lang('adminlte_lang::message.payment_to_cashbox')</h3>
            <div class="row  form-horizontal">
                <div class="col-sm-8">
                    {{ Form::select('new-transaction-account-id', $accounts, null, ['class' => 'js-select-basic-single']) }}
                    {{--<select id="new-transaction-account-id" class="js-select-basic-single" data-placeholder="@lang('adminlte_lang::message.choose')">--}}
                        {{--<option value="87128">Основная касса</option>--}}
                        {{--<option value="87129">Расчетный счет</option>--}}
                    {{--</select>--}}
                </div>
                <div class="col-sm-2">
                    <input id="new-transaction-amount" class="form-control input-sm" type="text" value="0">
                </div>
                <div class="text-right col-sm-2">
                    <button class="btn btn-primary" id="create-transaction-btn" data-record-id="15537667" data-visit-id="12413512" data-salon-id="62909">@lang('adminlte_lang::message.pay')</button>
                </div>
            </div>
        </div></div>
    <div id="payments_content_preloader" style="display: none;"></div>
</div>