<div class="record-body body_payments" id="neo_payments_div">
    <div id="payments_content" style="display: block;"><style type="text/css">
            .details-row td {
                padding: 10px !important;
                font-weight: bold;
            }
            .with-padding-left {
                padding-left: 30px !important;
            }

            .total-row {
                border-bottom: 2px solid rgb(231, 231, 231) !important;
            }

            .delete-transaction-btn, .cancel-loyalty-btn {
                line-height: 1;
            }

            .table-bg-white {
                background: #fff;
            }

            i.info-toggle {
                font-weight: normal !important;
                font-size: small;
                color: grey;
            }

            tr.info-toggle {
                cursor: pointer;
            }

            tbody.info-section {
                border: none !important;
            }

            .section-header, .section-header tr {
                border: none !important;
            }

            .section-subtotal {
                border: none !important;
                /*background: #fafafa !important;*/
                font-weight: bold;
            }
        </style>
        <div class="form-group">
            <table class="table table-bordered table-hover table-bg-white">
                <thead>
                <tr class="small">
                    <td class="col-xs-7"><b>Товар/услуга</b></td>
                    <td class="col-xs-1"><b>Цена,₽</b></td>
                    <td class="col-xs-1" style="width: 12.499999995%"><b>Оплачено,₽</b></td>
                    <td class="col-xs-1" style="width: 12.499999995%"><b>Остаток,₽</b></td>
                    <td class="col-xs-1">&nbsp;</td>
                </tr>
                </thead>

                <tbody class="section-header">
                <tr class="details-row info-toggle" data-section-id="1">
                    <td>Свадебный</td>
                    <td>0</td>
                    <td id="section-header-paid-1">0</td>
                    <td id="section-header-unpaid-1">0</td>
                    <td class="text-center">
                        <button id="toggle-info-section-1-btn" class="btn btn-link btn-xs"><i class="fa fa-caret-down"></i></button>
                    </td>
                </tr>
                </tbody>
                <tbody id="info-section-1" style="display:none;" class="info-section" data-id="1">

                <tr class="small total-row">
                    <td colspan="2" class="text-right">
                        <span class="section-subtotal-title" id="section-subtotal-title-1" style="display: none;">Итог:</span>
                    </td>
                    <td id="section-footer-paid-1">0</td>
                    <td id="section-footer-unpaid-1">0</td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
                <tbody class="section-header">
                    <tr class="details-row info-toggle" data-section-id="2">
                        <td>Деловой</td>
                        <td>0</td>
                        <td id="section-header-paid-2">0</td>
                        <td id="section-header-unpaid-2">0</td>
                        <td class="text-center">
                            <button id="toggle-info-section-2-btn" class="btn btn-link btn-xs"><i class="fa fa-caret-down"></i></button>
                        </td>
                    </tr>
                </tbody>
                <tbody id="info-section-2" style="display:none;" class="info-section" data-id="2">

                <tr class="small total-row">
                    <td colspan="2" class="text-right">
                        <span class="section-subtotal-title" id="section-subtotal-title-2" style="display: none;">Итог:</span>
                    </td>
                    <td id="section-footer-paid-2">0</td>
                    <td id="section-footer-unpaid-2">0</td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
                <tbody class="section-header">
                </tbody>
            </table>

            <table class="table table-bordered table-hover table-bg-white payments-total-table">
                <thead>
                <tr class="details-row">
                    <td class="col-xs-8">Оплачено (полностью)</td>
                    <td class="col-xs-1" style="width: 12.499999995%">0</td>
                    <td class="col-xs-1" style="width: 12.499999995%">0</td>
                    <td class="col-xs-1"></td>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <hr class="hr-line-dashed">

            <h3>Оплата в кассу</h3>
            <div class="row">
                <div class="col-sm-8">
                    {{ Form::select('new-transaction-account-id', $accounts, null, ['class' => 'form-control input-sm']) }}
                    {{--<select id="new-transaction-account-id" class="form-control input-sm" data-placeholder="Выберите">--}}
                        {{--<option value="87128">Основная касса</option>--}}
                        {{--<option value="87129">Расчетный счет</option>--}}
                    {{--</select>--}}
                </div>
                <div class="col-sm-2">
                    <input id="new-transaction-amount" class="form-control input-sm" type="text" value="0">
                </div>
                <div class="text-right col-sm-2">
                    <button class="btn btn-primary btn-sm" id="create-transaction-btn" data-record-id="15537667" data-visit-id="12413512" data-salon-id="62909">Оплатить</button>
                </div>
            </div>
        </div></div>
    <div id="payments_content_preloader" style="display: none;"></div>
</div>