@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.partner_information') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h4>{{ trans('adminlte_lang::message.partner_information') }}</h4>	
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
				{!! Form::model($partner, ['route' => ['partner.update', $partner->partner_id], 'method' => 'PUT']) !!}
					<div class="form-group">
						{{ Form::label('title', trans('adminlte_lang::message.partner_name'), ['class' => 'form-spacing-top']) }}
						{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
					</div>

					<div class="form-group">
						{{ Form::label('type', trans('adminlte_lang::message.partner_type'), ['class' => 'form-spacing-top']) }}
						{{ Form::select('type', ['company' 		=> trans('adminlte_lang::message.company'), 
												 'person' 		=> trans('adminlte_lang::message.person'), 
												 'selfemployed' => trans('adminlte_lang::message.self_employed')], 'company', ['class' => 'form-control', 'required' => '']) }}
					</div>

					<div class="form-group">
						{{ Form::label('inn', trans('adminlte_lang::message.INN'), ['class' => 'form-spacing-top']) }}
						{{ Form::text('inn', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '15']) }}
					</div>

					<div class="form-group">
						{{ Form::label('kpp', trans('adminlte_lang::message.KPP'), ['class' => 'form-spacing-top']) }}
						{{ Form::text('kpp', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '10']) }}
					</div>
					
					<div class="form-group">
						{{ Form::label('contacts', trans('adminlte_lang::message.partner_contacts'), ['class' => 'form-spacing-top']) }}
						{{ Form::text('contacts', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
					</div>

					<div class="form-group">
						{{ Form::label('phone', trans('adminlte_lang::message.phone'), ['class' => 'form-spacing-top']) }}
						{{ Form::text('phone', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '25']) }}
					</div>

					<div class="form-group">
						{{ Form::label('email', trans('adminlte_lang::message.email'), ['class' => 'form-spacing-top']) }}
						{{ Form::email('email', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '70']) }}
					</div>

					<div class="form-group">
						{{ Form::label('address', trans('adminlte_lang::message.address'), ['class' => 'form-spacing-top']) }}
						{{ Form::text('address', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '210']) }}
					</div>

					<div class="form-group">
						{{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'form-spacing-top']) }}
						{{ Form::textarea('description', null, ['class' => 'form-control']) }}
					</div>

					<hr>

					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<div class="row">
								<div class="col-sm-6">
									{!! Html::linkRoute('partner.show', trans('adminlte_lang::message.cancel'), [$partner->partner_id], 
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