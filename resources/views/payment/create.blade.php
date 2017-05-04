@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.payment_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.payment_create_new') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li><a href="{{ url('/payment')}}">{{ trans('adminlte_lang::message.payments') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.payment_create_new') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-12">

            {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
            {!! Form::open(['route' => 'payment.store', 'class' => 'form-horizontal']) !!}
            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('date', trans('adminlte_lang::message.date_and_time'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-4">
                    {{ Form::text('payment-date', '10-02-2017', ['class' => 'form-control hasDatepicker', 'required' => '', 'maxlength' => '110', 'id' => 'payment-date']) }}
                </div>
                <div class="col-sm-2">
                    {{ Form::select('payment-hour', $payment_hours, null, ['class' => 'js-select-basic-single', 'required' => '', 'id' => 'payment-hour']) }}
                </div>
                <div class="col-sm-2">
                    {{ Form::select('payment-minute', $payment_minutes, null, ['class' => 'js-select-basic-single', 'required' => '', 'id' => 'payment-minute']) }}
                </div>
                <label class="col-sm-1 text-left">
                    <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                </label>
            </div>

            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('item_id', trans('adminlte_lang::message.payment_item'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-8">
                    {{ Form::select('item_id', $items, null, ['class' => 'js-select-basic-single', 'required' => '']) }}
                </div>
                <label class="col-sm-1 text-left">
                    <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                </label>
            </div>

            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('account_id', trans('adminlte_lang::message.account'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-8">
                    {{ Form::select('account_id', $accounts, null, ['class' => 'js-select-basic-single', 'required' => '']) }}
                </div>
                <label class="col-sm-1 text-left">
                    <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                </label>
            </div>

            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('beneficiary_type', trans('adminlte_lang::message.beneficiary_type')) }}
                </div>
                <div class="col-sm-8">
                    <div class="radio">
                        <label>
                            {{ Form::radio('beneficiary_type', 'partner', false, ['style' => 'margin-right: 10px']) }}
                            {{ trans('adminlte_lang::message.partner') }}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            {{ Form::radio('beneficiary_type', 'client', false, ['style' => 'margin-right: 10px']) }}
                            {{ trans('adminlte_lang::message.client') }}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            {{ Form::radio('beneficiary_type', 'employee', false, ['style' => 'margin-right: 10px']) }}
                            {{ trans('adminlte_lang::message.employee') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('beneficiary_id',  trans('adminlte_lang::message.partner'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-8">
                    {{ Form::select('beneficiary_id', [''=>''], null, ['class' => 'js-select-basic-single', 'required' => '']) }}
                </div>
                <label class="col-sm-1 text-left">
                    <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                </label>
            </div>

            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('sum', trans('adminlte_lang::message.sum'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-8">
                    {{ Form::text('sum', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '10']) }}
                </div>
                <label class="col-sm-1 text-left">
                    <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                </label>
            </div>

            <div class="form-group">
                <div class="col-sm-3 control-label">
                    {{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-8">
                    {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                </div>
                <label class="col-sm-1 text-left">
                    <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                </label>
            </div>

            <div class="text-right m-t">
                {{	Form::submit(trans('adminlte_lang::message.payment_create_new'), ['class' => 'btn btn-primary']) }}
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection

@section('page-specific-scripts')
	<script>
		$(document).ready(function(e){
			$('input[name="beneficiary_type"]').on('change', function() {
				switch($(this).val()) {
					case 'client':
						$('label[for="beneficiary_id"]').html(<?php echo "'". trans('adminlte_lang::message.client')."'" ?>);
							break;
					case 'partner':
						$('label[for="beneficiary_id"]').html(<?php echo "'". trans('adminlte_lang::message.partner')."'" ?>);
							break;
					case 'employee':
						$('label[for="beneficiary_id"]').html(<?php echo "'". trans('adminlte_lang::message.employee')."'" ?>);
							break;
				}

				$.ajax({
					type: 'POST',
					dataType: 'json',
					data: {'beneficiary_type' : $(this).val()},
					url: "<?php echo route('payment.beneficiaryOptions')?>",
						success: function(data) {
							$("select[name='beneficiary_id']").html('');
							$("select[name='beneficiary_id']").html(data.options);
					}
				});
			});

			$('input[name="beneficiary_type"]').filter('[value="partner"]').trigger("click");
		});
	</script>
@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}