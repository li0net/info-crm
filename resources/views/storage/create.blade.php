@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.storage_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h4>{{ trans('adminlte_lang::message.new_storage') }}</h4>	
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
		</div>
	</div>
		{{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
		{!! Form::open(['route' => 'storage.store']) !!}
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="well">
						<div class="form-group">
							{{ Form::label('title', trans('adminlte_lang::message.storage_title')) }}
							{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
						</div>

						<div class="form-group">
							{{ Form::label('type', trans('adminlte_lang::message.storage_type')) }}
							<label style="width: 100%">
								{{ Form::radio('type', 1, true, ['style' => 'margin-right: 10px']) }}
									{{ trans('adminlte_lang::message.writeoff_supplies') }} 
							</label>
							<label>
								{{ Form::radio('type', 2, false, ['style' => 'margin-right: 10px']) }}
									{{ trans('adminlte_lang::message.sale_goods') }}
							</label>
						</div>

						<div class="form-group">
							{{ Form::label('description', trans('adminlte_lang::message.description')) }}
							{{ Form::textarea('description', null, ['class' => 'form-control']) }}
						</div>
					
						<hr>

						<div class="row">
							<div class="col-sm-6 col-sm-offset-3">
								{{	Form::submit(trans('adminlte_lang::message.storage_create_new'), ['class' => 'btn btn-success btn-block']) }}
							</div>
						</div>
					</div>
				</div>
			</div>
		{!! Form::close() !!}	
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}