@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $storage->title }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
			<div class="alert alert-success" role="alert">
				<strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
			</div>
		@endif
	</div>
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h4>{{ trans('adminlte_lang::message.information_about_storage') }}</h4>	
			<hr>
			{{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
			{!! Form::model($storage, ['route' => ['storage.update', $storage->storage_id], 'method' => 'PUT']) !!}
				<div class="well">
					<div class="form-group">
						{{ Form::label('title', trans('adminlte_lang::message.storage_title')) }}
						{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
					</div>

					<div class="form-group">
						{{ Form::label('type', trans('adminlte_lang::message.storage_type')) }}
						<label style="width: 100%">
							{{ Form::radio('type', 1, $storage->type ? true : false, ['style' => 'margin-right: 10px']) }}
								{{ trans('adminlte_lang::message.writeoff_supplies') }}
						</label>
						<label>
							{{ Form::radio('type', 2, $storage->type ? true : false, ['style' => 'margin-right: 10px']) }}
								{{ trans('adminlte_lang::message.sale_goods') }}
						</label>
					</div>

					<div class="form-group">
						{{ Form::label('description', trans('adminlte_lang::message.description')) }}
						{{ Form::textarea('description', null, ['class' => 'form-control', 'cols' => 'auto', 'rows' => 'auto']) }}
					</div>
					
					<hr>

					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<div class="row">
								<div class="col-sm-6">
									{!! Html::linkRoute('storage.show', trans('adminlte_lang::message.cancel'), [$storage->storage_id], 
																												['class'=>'btn btn-danger btn-block']) !!}
								</div>
								<div class="col-sm-6">
									{{ Form::submit(trans('adminlte_lang::message.save'), ['class'=>'btn btn-success btn-block']) }}
								</div>
							</div>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>	
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}