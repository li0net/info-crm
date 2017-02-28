@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.sales_analysis') }}
@endsection

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
			<div class="alert alert-success" role="alert">
				<strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
			</div>
		@endif
	</div>

	<div class="row">
		<div class="col-sm-4">
			<h4>{{ trans('adminlte_lang::message.sales_analysis') }}</h4>
		</div>	

		<div class="col-sm-8">
			<a href="#" class="btn btn-default m-r pull-right">{{ trans('adminlte_lang::message.upload_into_excel') }}</a>
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
						<span class="input-group-addon">{{ trans('adminlte_lang::message.date_from') }}&nbsp;&nbsp;</span>
						<input class="form-control" name="report_date" data-days-offset="-1" type="text" id="date-from">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="input-group">
						<span class="input-group-addon">{{ trans('adminlte_lang::message.date_to') }}&nbsp;&nbsp;</span>
						<input class="form-control" name="report_date" data-days-offset="-1" type="text" id="date-to">
					</div>
				</div>
				<div class="col-sm-4">
					{{ Form::select('category_id', $categories, null, ['class' => 'form-control', 
																	   'required' => '', 
																	   'id' => 'category_id', 
																	   'placeholder' => trans('adminlte_lang::message.categories')]) }}
				</div>	
			</div>
			<div class="row m-b">
				<div class="col-sm-4">
					{{ Form::select('employee_id', $employees, null, ['class' => 'form-control', 
																	  'required' => '', 
																	  'id' => 'employee_id', 
																	  'placeholder' => trans('adminlte_lang::message.employees')]) }}			
				</div>
				<div class="col-sm-4">
					{{ Form::select('partner_id', $partners, null, ['class' => 'form-control', 
																	'required' => '', 
																	'id' => 'partner_id', 
																	'placeholder' => trans('adminlte_lang::message.partners')]) }}
				</div>
				<div class="form-inline">
					<div class="col-sm-4">
						<select name="editable_length" aria-controls="editable" class="form-control input-sm">
							<option selected="" value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select>&nbsp;&nbsp;{{ trans('adminlte_lang::message.products_per_page') }}
					</div>
				</div>
			</div>
			<div class="row m-b ">
				<div class="col-sm-2 col-sm-offset-10">
					<input type="button" class="btn btn-success btn-sm pull-right" value={{ trans('adminlte_lang::message.show') }} id='form_submit'>
				</div>
			</div>
		</fieldset>
	</form>
	<div class="row">
		<div class="col-sm-12" id="result_container">
			<table class="table">
				<thead>
					<th>{{ trans('adminlte_lang::message.article') }}</th>
					<th>{{ trans('adminlte_lang::message.product_title') }}</th>
					<th>{{ trans('adminlte_lang::message.amount') }}</th>
					<th>{{ trans('adminlte_lang::message.cost_price') }}</th>
					<th>{{ trans('adminlte_lang::message.margin') }}</th>
					<th>{{ trans('adminlte_lang::message.margin_pctg') }}</th>
					<th>{{ trans('adminlte_lang::message.integrated_cost') }}</th>
				</thead>
				<tbody>
					@foreach($transactions as $transaction)
						<tr>
							<th class="text-center">{{ $transaction->product->article }}</th>
							<td>
								{{ $transaction->product->title }}
							</td>
							<td>
								{{ $transaction->amount }}
								@if($transaction->product->unit_for_sale == 'pcs') 
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
								{{ $transaction->price * $transaction->amount}}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{!! $transactions->render(); !!} 
			</div>
		</div>
	</div>		
@endsection

@section('page-specific-scripts')
	<script>
		$(document).ready(function(){
			$('#date-from').datepicker({
				autoclose: true,
				orientation: 'auto',
				format: 'dd-mm-yyyy',
				weekStart: 1
			});

			var today = new Date();

			$('#date-from').datepicker('update', today);

			$('#date-from').datepicker().on('show', function(e) {
				$('.datepicker.datepicker-dropdown').removeClass('datepicker-orient-bottom');
				$('.datepicker.datepicker-dropdown').addClass('datepicker-orient-top');
			});

			$('#date-to').datepicker({
				autoclose: true,
				orientation: 'auto',
				format: 'dd-mm-yyyy',
				weekStart: 1
			});

			var today = new Date();

			$('#date-to').datepicker('update', today);

			$('#date-to').datepicker().on('show', function(e) {
				$('.datepicker.datepicker-dropdown').removeClass('datepicker-orient-bottom');
				$('.datepicker.datepicker-dropdown').addClass('datepicker-orient-top');
			});

			$('#form_submit').on('click', function(e){
				var me = this;
				$.ajax({
					type: "POST",
					dataType: 'html',
					data: {	'date_from'				: $('#date-from').val(),
							'date_to'				: $('#date-to').val(),
							'employee_id'			: $('#employee_id').val(),
							'partner_id'			: $('#partner_id').val(),
							'category_id'			: $('#category_id').val(),
							'organization_id'		: $('#organization_id').val(),
							},
					url: "/salesanalysis/sales",
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
					data: {	'date_from'				: $('#date-from').val(),
							'date_to'				: $('#date-to').val(),
							'employee_id'			: $('#employee_id').val(),
							'partner_id'			: $('#partner_id').val(),
							'category_id'			: $('#category_id').val(),
							'organization_id'		: $('#organization_id').val(),
							},
					url: "/salesanalysis/sales",
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