@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.storage_balances') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.storage_balances') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stats') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.storage_balances') }}</li>
    </ol>
</section>
<div class="container-fluid">

    @include('partials.alerts')

    <div class="row">
        <div class="col-sm-12">
            <a href="#" class="btn btn-info pull-right">{{ trans('adminlte_lang::message.upload_into_excel') }}</a>
        </div>
        <div class="col-sm-12">
            <hr>
        </div>
    </div>
    <form method="post" action="#" class="form">
        {{ csrf_field() }}
        {{ Form::hidden('organization_id', $user->organization_id, ['id' => 'organization_id']) }}
        <fieldset>
            <div class="row m-b">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-addon">{{ trans('adminlte_lang::message.on_date') }}&nbsp;&nbsp;</span>
                        <input class="form-control" name="report_date" data-days-offset="-1" type="text" id="report-date">
                    </div>
                </div>
                <div class="col-sm-4">
                    {{ Form::select('storage_id', $storages, null, ['class' => ' js-select-basic-single',
                    'required' => '',
                    'id' => 'storage_id',
                    'placeholder' => trans('adminlte_lang::message.storages')]) }}
                </div>
                <div class="col-sm-4">
                    {{ Form::select('partner_id', $partners, null, ['class' => ' js-select-basic-single',
                    'required' => '',
                    'id' => 'partner_id',
                    'placeholder' => trans('adminlte_lang::message.partners')]) }}
                </div>
            </div>
            <div class="row m-b">
                <div class="col-sm-4">
                    {{ Form::select('category_id', $categories, null, ['class' => ' js-select-basic-single',
                    'required' => '',
                    'id' => 'category_id',
                    'placeholder' => trans('adminlte_lang::message.categories')]) }}
                </div>
                <div class="col-sm-4">
                    <select class=" js-select-basic-single" name="show_critical_balance">
                        <option selected="" value="0">{{ trans('adminlte_lang::message.dont_show_critical_balances') }}</option>
                        <option value="1">{{ trans('adminlte_lang::message.show_critical_balances') }}</option>
                    </select>
                </div>
                <div class="form-horizontal col-sm-4">
                    <div class="form-group">
                        <label for="editable_length" class="col-sm-9 control-label text-right">
                            {{ trans('adminlte_lang::message.products_per_page') }}
                        </label>
                        <div class="col-sm-3">
                            <select name="editable_length" aria-controls="editable" class=" js-select-basic-single">
                                <option selected="" value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-b ">
                <div class="col-sm-12 text-right">
                    <input type="button" class="btn btn-primary" value={{ trans('adminlte_lang::message.show') }} id='form_submit'>
                </div>
            </div>
        </fieldset>
    </form>
    <div class="row">
        <div class="col-sm-12" id="result_container">
                <thead>
            <table class="table table-hover table-condensed">
                <th>{{ trans('adminlte_lang::message.article') }}</th>
                <th>{{ trans('adminlte_lang::message.product_title') }}</th>
                <th>{{ trans('adminlte_lang::message.amount') }}</th>
                <th>{{ trans('adminlte_lang::message.writeoff_balance') }}</th>
                <th>{{ trans('adminlte_lang::message.cost_price') }}</th>
                <th>{{ trans('adminlte_lang::message.margin') }}</th>
                <th>{{ trans('adminlte_lang::message.margin_pctg') }}</th>
                <th>{{ trans('adminlte_lang::message.price') }}</th>
                <th>{{ trans('adminlte_lang::message.integrated_cost') }}</th>
                </thead>
                <tbody>
                @foreach($products as $product)
                <tr>
                    <th class="text-center">{{ $product->article }}</th>
                    <td>
                        {{ $product->title }}
                    </td>
                    <td>
                        {{ $product->amount }}
                        @if($product->unit_for_sale == 'pcs')
                        {{ trans('adminlte_lang::message.pieces') }}&nbsp;
                        @else
                        {{ trans('adminlte_lang::message.milliliters') }}
                        @endif
                    </td>
                    <td>
                        {{ $product->amount * $product->is_equal }}
                        @if($product->unit_for_disposal == 'pcs')
                        {{ trans('adminlte_lang::message.pieces') }}&nbsp;
                        @else
                        {{ trans('adminlte_lang::message.milliliters') }}
                        @endif
                    </td>
                    <td>
                        0
                    </td>
                    <td>
                        0
                    </td>
                    <td>
                        0
                    </td>
                    <td>
                        {{ $product->price }}
                    </td>
                    <td>
                        {{ $product->price * $product->amount}}
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {!! $products->render(); !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-specific-scripts')
<script>
    $(document).ready(function(){
        $('#report-date').datepicker({
            autoclose: true,
            orientation: 'auto',
            format: 'dd-mm-yyyy',
            weekStart: 1
        });

        var today = new Date();

        $('#report-date').datepicker('update', today);

        $('#report-date').datepicker().on('show', function(e) {
            $('.datepicker.datepicker-dropdown').removeClass('datepicker-orient-bottom');
            $('.datepicker.datepicker-dropdown').addClass('datepicker-orient-top');
        });

        $('#form_submit').on('click', function(e){
            var me = this;
            $.ajax({
                type: "POST",
                dataType: 'html',
                data: {	'date_report'			: $('#date-report').val(),
                        'storage_id'			: $('#storage_id').val(),
                        'partner_id'			: $('#partner_id').val(),
                        'category_id'			: $('#category_id').val(),
                        'show_critical_balance'	: $('select[name="show_critical_balance"]').val(),
                        'organization_id'		: $('#organization_id').val(),
                        },
                url: "/storagebalance/list",
                success: function(data) {
                        $('#result_container').html(data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Error while processing payments data range!');
                }
            });
        });

        $('#result_container').on('click', '.filtered > .pagination', function(e) {
            var me = this, page = 0;
            if ($(e.target).html() == '»') {
                page = parseInt($('.pagination li.active span').html()) + 1;
            } else if ($(e.target).html() == '«'){
                page = parseInt($('.pagination li.active span').html()) - 1;
            } else {
                page = parseInt($(e.target).html());
            }

            $.ajax({
                type: "POST",
                dataType: 'html',
                data: {	'date_report'			: $('#date-report').val(),
                        'storage_id'			: $('#storage_id').val(),
                        'partner_id'			: $('#partner_id').val(),
                        'category_id'			: $('#category_id').val(),
                        'show_critical_balance'	: $('select[name="show_critical_balance"]').val(),
                        'organization_id'		: $('#organization_id').val(),
                        },
                url: "/storagebalance/list",
                success: function(data) {
                        $('#result_container').html(data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Error while processing payments data range!');
                }
            });

            return false;
        });
    });
</script>
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>