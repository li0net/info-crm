@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h4>Информация о технологической карте</h4>	
			{{-- <ex1></ex1> --}}
			<hr>	
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<div class="well">
				{{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
				{!! Form::model($card, ['route' => ['card.update', $card->card_id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
					{{ Form::hidden('storage_options', null, ['id' => 'storage_options']) }}
					<div class="row">
						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('title', 'Наименование:', ['class' => 'form-spacing-top']) }}
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
								&nbsp;&nbsp;Состав технологической карты&nbsp;&nbsp;
								<i class="fa fa-caret-down"></i></a>
							</div>
						</div>

						<div id="card-items" class="form-group collapse">
							<div class="row">
								<div class="col-sm-2"></div>
								<div class="col-sm-8">
									<div class="col-sm-5">Наименование</div>
									<div class="col-sm-5">Склад</div>
									<div class="col-sm-2">Количество</div>
								</div>
								<div class="col-sm-2"></div>
							</div>
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
									<hr>
								</div>
							</div>
							@foreach( $card_items as $card_item )
								<div class="wrap-it">
									<div class="col-sm-2"></div>							
									<div class="col-sm-8" style="padding:0">
										<div class="col-sm-5">
											{{ Form::text('product_id[]', $card_item[0], ['class' => 'form-control', 'maxlength' => '110']) }}
										</div>
										<div class="col-sm-5">
											{{ Form::select('storage_id[]', $storages, $card_item[1], ['class' => 'form-control', 'maxlength' => '110']) }}
										</div>
										<div class="col-sm-2">
											{{ Form::text('amount[]', $card_item[2], ['class' => 'form-control', 'maxlength' => '110']) }}
										</div>
									</div>
									<div class="col-sm-2" style="margin-bottom: 15px;">
										<input type="button" id="add-card-item" class="btn btn-danger" value="Удалить">
									</div>
								</div>
							@endforeach
							<div class="wrap-it">
								<div class="col-sm-2"></div>							
								<div class="col-sm-8" style="padding:0">
									<div class="col-sm-5">
										{{ Form::text('product_id[]', null, ['class' => 'form-control', 'maxlength' => '110']) }}
									</div>
									<div class="col-sm-5">
										{{ Form::select('storage_id[]', $storages, '0', ['class' => 'form-control', 'maxlength' => '110']) }}
									</div>
									<div class="col-sm-2">
										{{ Form::text('amount[]', null, ['class' => 'form-control', 'maxlength' => '110']) }}
									</div>
								</div>
								<div class="col-sm-2" style="margin-bottom: 15px;">
									<input type="button" id="add-card-item" class="btn btn-info" value="Добавить">
								</div>
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('description', 'Описание:', ['class' => 'form-spacing-top col-sm-2 control-label']) }}
							<div class="col-sm-9">
								{{ Form::textarea('description', null, ['class' => 'form-control']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>
					</div>
					
					<hr>

					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<div class="row">
								<div class="col-md-6">
									{!! Html::linkRoute('card.show', 'Отмена', [$card->card_id], ['class'=>'btn btn-danger btn-block']) !!}
								</div>
								<div class="col-md-6">
									{{ Form::submit('Сохранить', ['class'=>'btn btn-success btn-block']) }}
								</div>
							</div>
						</div>
					</div>
				{!! Form::close() !!}	
			</div>
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
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Error while processing services data range!');
				}
			});
		});
	</script>
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}