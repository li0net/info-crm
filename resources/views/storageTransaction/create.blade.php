@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.operation')}}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li><a href="{{ url('/storagetransaction')}}">{{ trans('adminlte_lang::message.operations') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.operation')}}</li>
    </ol>
</section>

<div class="container">

    @include('partials.alerts')

    <div class="row">
        <div class="col-sm-12">
            {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
            {!! Form::open(['route' => 'storagetransaction.store', 'class' => 'form-horizontal']) !!}
            {{ Form::hidden('storage_options', null, ['id' => 'storage_options']) }}
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-2 control-label">
                        {{ Form::label('date', trans('adminlte_lang::message.date_and_time')) }}
                    </div>
                    <div class="col-sm-5">
                        {{ Form::text('transaction-date', '', ['class' => 'form-control hasDatepicker', 'required' => '', 'maxlength' => '110', 'id' => 'transaction-date']) }}
                    </div>
                    <div class="col-sm-2">
                        {{ Form::select('transaction-hour', $transaction_hours, null, ['class' => 'js-select-basic-single', 'required' => '', 'id' => 'transaction-hour']) }}
                    </div>
                    <div class="col-sm-2">
                        {{ Form::select('transaction-minute', $transaction_minutes, null, ['class' => 'js-select-basic-single', 'required' => '', 'id' => 'transaction-minute']) }}
                    </div>
                    <label class="col-sm-1 text-left">
                        <a class="fa fa-info-circle" id='service_unit' original-title="">&nbsp;</a>
                    </label>
                </div>

                <div class="form-group">
                    <div class="col-sm-2 control-label">
                        {{ Form::label('type', trans('adminlte_lang::message.storage_type')) }}
                    </div>
                    <div class="col-sm-9">
                        {{ Form::select('type', [
                            'income' => trans('adminlte_lang::message.storage_income'),
                            'expenses' => trans('adminlte_lang::message.storage_expense'),
                            'discharge' => trans('adminlte_lang::message.storage_discharge'),
                            'transfer' => trans('adminlte_lang::message.transfer')
                            ],
                        'income', [
                        'class' => 'js-select-basic-single',
                        'required' => '']) }}
                    </div>
                    <label class="col-sm-1 text-left">
                        <a class="fa fa-info-circle" original-title="">&nbsp;</a>
                    </label>
                </div>
                <div class="transaction-type-content">
                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            {{ Form::label('partner_id', trans('adminlte_lang::message.partner')) }}
                        </div>
                        <div class="col-sm-9">
                            {{ Form::select('partner_id', $partners, null, ['class' => 'js-select-basic-single', 'required' => '']) }}
                        </div>
                        <label class="col-sm-1 text-left">
                            <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                        </label>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2 control-label">
                            {{ Form::label('storage_id', trans('adminlte_lang::message.storage')) }}
                        </div>
                        <div class="col-sm-9">
                            {{ Form::select('storage_id', $storages, null, [
                                'placeholder' => trans('adminlte_lang::message.select_storage'),
                                'class' => 'js-select-basic-single',
                                'required' => '']) }}
                        </div>
                        <label class="col-sm-1 text-left">
                            <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                        </label>
                    </div>
                </div>
                <div id="transaction-items" class="form-group collapse in">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-2">
                            <div class="col-sm-3 text-center">{{ trans('adminlte_lang::message.product') }}</div>
                            <div class="col-sm-2 text-center">{{ trans('adminlte_lang::message.price') }}</div>
                            <div class="col-sm-2 text-center">{{ trans('adminlte_lang::message.amount') }}</div>
                            <div class="col-sm-2 text-center">{{ trans('adminlte_lang::message.discount') }}</div>
                            <div class="col-sm-2 text-center">{{ trans('adminlte_lang::message.sum') }}</div>
                            <div class="col-sm-1 text-center">{{ trans('adminlte_lang::message.code') }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-2">
                            <hr>
                        </div>
                    </div>
                    <div class="row" id="transaction-content">
                        <div class="wrap-it alt-control-bar col-sm-9 col-sm-offset-2">
                            <div class="col-sm-3 text-center">
                                {{ Form::select('product_id', [], null, [
                                    'class' => 'js-select-basic-single-alt',
                                    'maxlength' => '110',
                                    'placeholder' => trans('adminlte_lang::message.select_good')
                                ]) }}
                            </div>
                            <div class="col-sm-2 text-center">
                                {{ Form::text('price', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-sm-2 text-center">
                                {{ Form::text('amount', null, ['class' => 'form-control', 'value'=>1]) }}
                            </div>
                            <div class="col-sm-2 text-center">
                                {{ Form::text('discount', null, ['class' => 'form-control', 'value'=>0]) }}
                            </div>
                            <div class="col-sm-2 text-center">
                                {{ Form::text('sum', null, ['class' => 'form-control']) }}
                            </div>
                            <div class="col-sm-1 text-center">
                                {{ Form::text('code', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">
                        {{ Form::label('is_paidfor', trans('adminlte_lang::message.payment')) }}
                    </div>
                    <label class="col-sm-9 text-left" style="font-weight: 300">
                        {{ Form::checkbox('is_paidfor', 1, 0, ['style' => 'margin-right: 10px;']) }}
                        {{ trans('adminlte_lang::message.paid') }}
                    </label>
                    <label class="col-sm-1 text-left">
                        <a class="fa fa-info-circle" id="is_paidfor" original-title="">&nbsp;</a>
                    </label>
                </div>

                <div class="form-group">
                    <div class="col-sm-2 control-label">
                        {{ Form::label('description', trans('adminlte_lang::message.description')) }}
                    </div>
                    <div class="col-sm-9">
                        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                    </div>
                    <label class="col-sm-1 text-left">
                        <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                    </label>
                </div>
            </div>

            <div class="m-t text-right col-sm-12">
                {{	Form::submit(trans('adminlte_lang::message.create'), ['class' => 'btn btn-primary']) }}
            </div>
            {!! Form::close() !!}
        </div>
	</div>
</div>
@endsection

@section('page-specific-scripts')
	<script type="text/javascript">
		$(document).ready(function($) {
			$('select[name="type"]').on('change', function(e){
				$('.transaction-type-content').children().remove();
				if( $(this).val() == 'income') {
					$('.transaction-type-content').append(
								'<div class="form-group"> \
									<div class="col-sm-2 control-label"> \
										{{ Form::label('partner_id', trans('adminlte_lang::message.partner')) }} \
									</div> \
									<div class="col-sm-9"> \
										{{ Form::select('partner_id', $partners, null, ['class' => 'js-select-basic-single', 'required' => '']) }} \
									</div> \
									<label class="col-sm-1 text-left"> \
										<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a> \
									</label> \
								</div> \
								\
								<div class="form-group"> \
									<div class="col-sm-2 control-label"> \
										{{ Form::label('storage_id',trans('adminlte_lang::message.storage')) }} \
									</div> \
									<div class="col-sm-9">\
										{{ Form::select('storage_id', $storages, null, ['placeholder' => trans('adminlte_lang::message.select_storage'),'class' => 'js-select-basic-single-alt', 'required' => '']) }} \
									</div> \
									<label class="col-sm-1 text-left"> \
										<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a> \
									</label> \
								</div>');
				} else if ($(this).val() == 'expenses') {
					$('.transaction-type-content').append(
								'<div class="form-group"> \
									<div class="col-sm-2 control-label"> \
										{{ Form::label('client_id', trans('adminlte_lang::message.client')) }} \
									</div> \
									<div class="col-sm-9"> \
										{{ Form::select('client_id', $clients, null, ['class' => 'js-select-basic-single', 'required' => '']) }} \
									</div> \
									<label class="col-sm-1 text-left"> \
										<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a> \
									</label> \
								</div> \
								\
								<div class="form-group"> \
									<div class="col-sm-2 control-label"> \
										{{ Form::label('employee_id', trans('adminlte_lang::message.employee')) }} \
									</div> \
									<div class="col-sm-9"> \
										{{ Form::select('employee_id', $employees, null, ['class' => 'js-select-basic-single', 'required' => '']) }} \
									</div> \
									<label class="col-sm-1 text-left"> \
										<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a> \
									</label> \
								</div> \
								\
								<div class="form-group"> \
									<div class="col-sm-2 control-label"> \
										{{ Form::label('storage_id', trans('adminlte_lang::message.storage')) }} \
									</div> \
									<div class="col-sm-9"> \
										{{ Form::select('storage_id', $storages, null, ['placeholder' => trans('adminlte_lang::message.select_storage'),'class' => 'js-select-basic-single', 'required' => '']) }} \
									</div> \
									<label class="col-sm-1 text-left"> \
										<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a> \
									</label> \
								</div>');
				} else if ($(this).val() == 'discharge') {
					$('.transaction-type-content').append(
									'<div class="form-group"> \
										<div class="col-sm-2 control-label"> \
											{{ Form::label('storage_id', trans('adminlte_lang::message.storage')) }} \
										</div> \
										<div class="col-sm-9"> \
											{{ Form::select('storage_id', $storages, null, ['placeholder' => trans('adminlte_lang::message.select_storage'),'class' => 'js-select-basic-single', 'required' => '']) }} \
										</div> \
										<label class="col-sm-1 text-left"> \
											<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a> \
										</label> \
									</div>');
				} else {
					$('.transaction-type-content').append(
									'<div class="form-group"> \
										<div class="col-sm-2 control-label"> \
											{{ Form::label('storage_id', trans('adminlte_lang::message.from_storage')) }} \
										</div> \
										<div class="col-sm-9"> \
											{{ Form::select('storage_id', $storages, null, ['placeholder' => trans('adminlte_lang::message.select_storage'),'class' => 'js-select-basic-single', 'required' => '']) }} \
										</div> \
										<label class="col-sm-1 text-left"> \
											<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a> \
										</label> \
									</div> \
									<div class="form-group"> \
										<div class="col-sm-2 control-label"> \
											{{ Form::label('storage2_id', trans('adminlte_lang::message.to_storage')) }} \
										</div> \
										<div class="col-sm-9"> \
											{{ Form::select('storage2_id', $storages, null, ['placeholder' => trans('adminlte_lang::message.select_storage'),'class' => 'js-select-basic-single', 'required' => '']) }} \
										</div> \
										<label class="col-sm-1 text-left"> \
											<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a> \
										</label> \
									</div>');
				}
                $(".js-select-basic-single").select2({
                    minimumResultsForSearch: Infinity
                }).on("select2:open", function () {
                    $('.select2-results__options').niceScroll({cursorcolor:"#ffae1a", cursorborder: "1px solid #DF9917", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
                });
			});

			$('.transaction-type-content').on('change', 'select[name="storage_id"]', function(e){
				$.ajax({
					type: 'POST',
					dataType: 'json',
					data: {'storage_id' : $(this).val()},
					url: "<?php echo route('card.productOptions') ?>",
					success: function(data) {
						$('select[name="product_id"]').first().html('');
						$('select[name="product_id"]').first().html(data.options);
					}
				});
			});
		});
	</script>
@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}