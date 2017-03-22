@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.routine_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.routine_create_new') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li><a href="{{ url('/card')}}">{{ trans('adminlte_lang::message.routings') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.routine_create_new') }}</li>
    </ol>
</section>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
		</div>

        <div class="col-sm-12">
            {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
            {!! Form::open(['route' => 'card.store', 'class' => 'form-horizontal']) !!}
            {{ Form::hidden('storage_options', null, ['id' => 'storage_options']) }}
            <div class="form-group">
                <div class="col-sm-2 control-label">
                    {{ Form::label('title', trans('adminlte_lang::message.title'), ['class' => 'form-spacing-top']) }}
                </div>
                <div class="col-sm-9">
                    {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
                <label class="col-sm-1 text-left">
                    <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                </label>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-6">
                    <a href="#card-items" data-toggle="collapse" class="btn btn-link btn-xs">
                        <span class="badge label-danger hidden">@{{ card_items_count }}</span>
                        &nbsp;&nbsp;{{ trans('adminlte_lang::message.routine_structure') }}&nbsp;&nbsp;
                        <i class="fa fa-caret-down"></i></a>
                </div>
            </div>

            <div id="card-items" class="form-group collapse">
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <div class="col-sm-5">{{ trans('adminlte_lang::message.stock') }}</div>
                        <div class="col-sm-5">{{ trans('adminlte_lang::message.title') }}</div>
                        <div class="col-sm-2">{{ trans('adminlte_lang::message.amount') }}</div>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <hr>
                    </div>
                </div>
                <div class="wrap-it">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8" style="padding:0">
                        <div class="col-sm-5">
                            {{ Form::select('storage_id[]', $storages, '0', ['class' => 'form-control', 'maxlength' => '110', 'id' => '']) }}
                        </div>
                        <div class="col-sm-5">
                            {{ Form::select('product_id[]', [], null, 	[
                            'class' => 'form-control',
                            'maxlength' => '110',
                            'placeholder' => trans('adminlte_lang::message.select_good')
                            ]) }}
                        </div>
                        <div class="col-sm-2">
                            {{ Form::text('amount[]', null, ['class' => 'form-control', 'maxlength' => '110']) }}
                        </div>
                    </div>
                    <div class="col-sm-2" style="margin-bottom: 15px;">
                        <input type="button" id="add-card-item" class="btn btn-info" value={{ trans('adminlte_lang::message.add') }}>
                    </div>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'form-spacing-top col-sm-2 control-label']) }}
                <div class="col-sm-9">
                    {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                </div>
                <label class="col-sm-1 text-left">
                    <a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
                </label>
            </div>

            <div class="m-t text-right">
                {{	Form::submit(trans('adminlte_lang::message.routine_create_new'), ['class' => 'btn btn-primary']) }}
            </div>
            {!! Form::close() !!}
        </div>
	</div>
@endsection

@section('page-specific-scripts')
	<script type="text/javascript">
		$(document).ready(function($) {
			var options = '';
			$.ajax({
				type: "GET",
				dataType: 'json',
				url: '/storageData',
				data: {},
				success: function(data) {
					for (var i = 0; i < data.length; i++) {
						options = options + '<option value=' + data[i].storage_id + '>' + data[i].title + '</option>';
					}

					$('#storage_options').val(options);

					$('select.form-control[name="storage_id[]"]').find('option').remove();
					$('select.form-control[name="storage_id[]"]').append(options);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Error while processing services data range!');
				}
			});

			$('#card-items').on('change', 'select[name="storage_id[]"]', function(e){
				$.ajax({
					type: 'POST',
					dataType: 'json',
					data: {'storage_id' : $(this).val()},
					url: "<?php echo route('card.productOptions') ?>",
					success: function(data) {
						$(e.target).parent().next().children('select[name="product_id[]"]').first().html('');
						$(e.target).parent().next().children('select[name="product_id[]"]').first().html(data.options);
					}
				});
			});
		});
	</script>
@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}