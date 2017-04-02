@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.information_about_payroll_scheme') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.information_about_payroll_scheme') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li><a href="{{ url('/wage_scheme')}}">{{ trans('adminlte_lang::message.schemes') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.information_about_payroll_scheme') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
        {!! Form::open(['route' => ['wage_scheme.store']]) !!}
        {{ Form::hidden('service_ctgs_options', null, ['id' => 'service_ctgs_options']) }}
        {{ Form::hidden('product_ctgs_options', null, ['id' => 'product_ctgs_options']) }}
        <div class="form-group">
            <div class="col-sm-11">
                {{ Form::label('scheme_name', trans('adminlte_lang::message.scheme_name')) }}
                {{ Form::text('scheme_name', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
            </div>
            <div class="col-sm-1"></div>
        </div>
        <div class="form-group">
            <div class="col-sm-8">
                {{ Form::label('services_percent', trans('adminlte_lang::message.services')) }}
            </div>
            <div class="col-sm-8">
                {{ Form::text('services_percent', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
            </div>
            <div class="col-sm-3">
                {{ Form::select('service_unit', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'js-select-basic-single',
                'required' => '',
                'maxlength' => '110']) }}
            </div>
            <label class="col-sm-1 text-left">
                <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
            </label>
        </div>
        <div class="form-group">
            <div class="col-sm-11">
                <div class="box box-details box-solid collapsed-box">
                    <div class="box-header with-border">
                        <h3>
                            <a href="#detailed-services" data-toggle="collapse" class="btn btn-link btn-xs" data-widget="collapse">
                                <i class="fa fa-caret-down"></i>
                                {{ trans('adminlte_lang::message.specify_val_4_services') }}
                            </a>
                        </h3>
                        <div class="box-tools pull-right">
                            <span class="badge label-danger" v-model="detailed_services_count">@{{detailed_services_count}}</span>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" >
                        <div id="detailed-services" class="form-group ">
                            <div class="wrap-it alt-control-bar">
                                <div class="col-sm-11">
                                    <div class="col-sm-4">
                                        {{ Form::select('services_cats_detailed[]', [], null, ['class' => 'form-control', 'maxlength' => '110']) }}
                                    </div>
                                    <div class="col-sm-4">
                                        {{ Form::select('services_detailed[]', [], null, ['class' => 'form-control', 'maxlength' => '110']) }}
                                    </div>
                                    <div class="col-sm-2">
                                        {{ Form::text('services_percent_detailed[]', null, ['class' => 'form-control', 'maxlength' => '110']) }}
                                    </div>
                                    <div class="col-sm-2">
                                        {{ Form::select('services_unit_detailed[]', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'form-control', 'maxlength' => '110']) }}
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
                    <!-- /.box-body -->
                </div>
            </div>
            <label class="col-sm-1 text-left">
                <br>
                <a class="fa fa-info-circle" id="products_unit" original-title="">&nbsp;</a>
            </label>
        </div>

        <div class="form-group">
            <label class="col-sm-8">
                {{ Form::label('products_percent', trans('adminlte_lang::message.products'), ['class' => 'form-spacing-top']) }}
            </label>
            <div class="col-sm-8">
                {{ Form::text('products_percent', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
            </div>
            <div class="col-sm-3">
                {{ Form::select('products_unit', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'js-select-basic-single', 'required' => '', 'maxlength' => '110']) }}
            </div>
            <label class="col-sm-1 text-left">
                <a class="fa fa-info-circle" id="products_unit" original-title="">&nbsp;</a>
            </label>
        </div>
        <div class="form-group">
            <div class="col-sm-11">
                <div class="box box-details box-solid collapsed-box">
                    <div class="box-header with-border">
                        <h3>
                            <a href="#detailed-products" data-toggle="collapse" class="btn btn-link btn-xs" data-widget="collapse">
                                <i class="fa fa-caret-down"></i>
                                {{ trans('adminlte_lang::message.specify_val_4_products') }}
                            </a>
                        </h3>
                        <div class="box-tools pull-right">
                            <span class="badge label-danger" v-model="detailed_products_count">@{{detailed_products_count}}</span>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" >
                        <div id="detailed-products" class="form-group ">
                            <div class="wrap-it alt-control-bar">
                                <div class="col-sm-11">
                                    <div class="col-sm-4">
                                        {{ Form::select('products_cats_detailed[]', [], null, ['class' => 'form-control', 'placeholder' => 'Category']) }}
                                    </div>
                                    <div class="col-sm-4">
                                        {{ Form::select('products_detailed[]', [], null, ['class' => 'form-control', 'placeholder' => trans('adminlte_lang::message.select_good')]) }}
                                    </div>
                                    <div class="col-sm-2">
                                        {{ Form::text('products_percent_detailed[]', null, ['class' => 'form-control', 'maxlength' => '110', 'placeholder' => 'Percent']) }}
                                    </div>
                                    <div class="col-sm-2">
                                        {{ Form::select('products_unit_detailed[]', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'form-control', 'placeholder' => trans('adminlte_lang::message.unit')]) }}
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
                    <!-- /.box-body -->
                </div>
            </div>
            <label class="col-sm-1 text-left">
                <br>
                <a class="fa fa-info-circle" id="products_unit" original-title="">&nbsp;</a>
            </label>
        </div>

<!--        <div class="form-group">-->
<!--            <div class="col-sm-6">-->
<!--                <a href="#detailed-products" data-toggle="collapse" class="btn btn-link btn-xs">-->
<!--                    <span class="badge label-danger hidden" v-model="detailed_products_count">@{{ detailed_products_count }}</span>-->
<!--                    &nbsp;&nbsp;{{ trans('adminlte_lang::message.specify_val_4_products') }}&nbsp;&nbsp;-->
<!--                    <i class="fa fa-caret-down"></i></a>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div id="detailed-products" class="form-group collapse">-->
<!--            <div class="wrap-it alt-control-bar">-->
<!--                <div class="col-sm-10" style="padding:0">-->
<!--                    <div class="col-sm-4">-->
<!--                        {{ Form::select('products_cats_detailed[]', [], null, ['class' => 'form-control', 'maxlength' => '110']) }}-->
<!--                    </div>-->
<!--                    <div class="col-sm-4">-->
<!--                        {{ Form::select('products_detailed[]', [], null, ['class' => 'form-control', 'maxlength' => '110']) }}-->
<!--                    </div>-->
<!--                    <div class="col-sm-2">-->
<!--                        {{ Form::text('products_percent_detailed[]', null, ['class' => 'form-control', 'maxlength' => '110']) }}-->
<!--                    </div>-->
<!--                    <div class="col-sm-2">-->
<!--                        {{ Form::select('products_unit_detailed[]', ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'form-control', 'maxlength' => '110']) }}-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-sm-2" style="margin-bottom: 15px;">-->
<!--                    <input type="button" id="add-detailed-section" class="btn btn-info btn-sm" value="Добавить">-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

        <div class="form-group">
            <label class="col-sm-12">
                {{ Form::label('wage_rate', trans('adminlte_lang::message.wage'), ['class' => 'form-spacing-top']) }}
            </label>
            <div class="col-sm-8">
                {{ Form::text('wage_rate', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
            </div>
            <div class="col-sm-3">
                {{ Form::select('wage_rate_period', ['hour' => trans('adminlte_lang::message.hour'),
                'day' => trans('adminlte_lang::message.day'),
                'month' => trans('adminlte_lang::message.month')],
                'day',
                ['class' => 'js-select-basic-single', 'required' => '', 'maxlength' => '110']) }}
            </div>
            <label class="col-sm-1 text-left">
                <a class="fa fa-info-circle" id="wage_rate" original-title="">&nbsp;</a>
            </label>
        </div>

        <div class="form-group">
            {{-- {{ Form::label(null, null, ['class' => 'col-sm-2 text-right ctrl-label']) }} --}}
            <label class="col-sm-11 text-left">
                {{ Form::checkbox('is_client_discount_counted', true, true, ['style' => 'margin-right: 10px']) }}
                {{ trans('adminlte_lang::message.consider_discount') }}
            </label>
            <label class="col-sm-1 text-left">
                <a class="fa fa-info-circle" id="is_client_discount_counted" original-title="">&nbsp;</a>
            </label>
        </div>

        <div class="form-group">
            {{-- {{ Form::label(null, null, ['class' => 'col-sm-2 text-right ctrl-label']) }} --}}
            <label class="col-sm-11 text-left">
                {{ Form::checkbox('is_material_cost_counted', true, true, ['style' => 'margin-right: 10px']) }}
                {{ trans('adminlte_lang::message.consider_cost_of_materials') }}
            </label>
            <label class="col-sm-1 text-left">
                <a class="fa fa-info-circle" id="is_material_cost_counted" original-title="">&nbsp;</a>
            </label>
        </div>
        <div class="col-sm-11 m-t text-right">
            {{	Form::submit(trans('adminlte_lang::message.scheme_create_new'), ['class' => 'btn btn-primary']) }}
        </div>
        {!! Form::close() !!}
    </div>
</div>

<!--templates-->
@include('wage_schemes.templates')
<!--templates-->

@endsection

@section('page-specific-scripts')
	<script type="text/javascript">
		$(document).ready(function($) {
			var options = '';

			$.ajax({
				type: "GET",
				dataType: 'json',
				url: '/serviceCategories/gridData',
				data: {},
				success: function(data) {
					for (var i = 0; i < data.rows.length; i++) {
						options += '<option value=' + data.rows[i].service_category_id + '>' + data.rows[i].name + '</option>';
					}

					$('#service_ctgs_options').val(options);

					$('select.form-control[name="services_cats_detailed[]"]').find('option').remove();
					$('select.form-control[name="services_cats_detailed[]"]').append(options);

					// $('select.form-control[name="services_cats_detailed[]"]').each(function() {
					// 	var initialValue = $(this).attr('data-initial-value');
						
					// 	if ( 0 != initialValue ) {
					// 		$(this).val(initialValue);
					// 	} else {
					// 		$(this).val($(this).find('option').first().val());
					// 		console.log($(this).find('option').first().val());
					// 	}
					// });
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Error while processing services data range!');
				}
			});

			$.ajax({
				type: "GET",
				dataType: 'json',
				url: '/productCategoriesData',
				data: {},
				success: function(data) {
					options = '';
					for (var i = 0; i < data.length; i++) {
						options += '<option value=' + data[i].product_category_id + '>' + data[i].title + '</option>';
					}

					$('#product_ctgs_options').val(options);

					$('select.form-control[name="products_cats_detailed[]"]').find('option').remove();
					$('select.form-control[name="products_cats_detailed[]"]').append(options);

					// $('select.form-control[name="products_cats_detailed[]"]').each(function() {
					// 	var initialValue = $(this).attr('data-initial-value');
						
					// 	if ( 0 != initialValue ) {
					// 		$(this).val(initialValue);
					// 	} else {
					// 		$(this).val($(this).find('option').first().val());
					// 		console.log($(this).find('option').first().val());
					// 	}
					// });
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Error while processing products data range!');
				}
			});

			$('#detailed-services').on('change', 'select[name="services_cats_detailed[]"]', function(e){
				$.ajax({
					type: 'POST',
					dataType: 'json',
					data: {'service_ctgs' : $(this).val()},
					url: "<?php echo route('wage_scheme.detailedServiceOptions') ?>",
					success: function(data) {
						$(e.target).parent().next().children('select[name="services_detailed[]"]').first().html('');
						$(e.target).parent().next().children('select[name="services_detailed[]"]').first().html(data.options);
					}
				});
			});

			$('#detailed-products').on('change', 'select[name="products_cats_detailed[]"]', function(e){
				$.ajax({
					type: 'POST',
					dataType: 'json',
					data: {'product_ctgs' : $(this).val()},
					url: "<?php echo route('wage_scheme.detailedProductOptions') ?>",
					success: function(data) {
						$(e.target).parent().next().children('select[name="products_detailed[]"]').first().html('');
						$(e.target).parent().next().children('select[name="products_detailed[]"]').first().html(data.options);
					}
				});
			});
		});
	</script>
@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}