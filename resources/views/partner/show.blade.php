@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $partner->title }}
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
		<div class="col-sm-6 col-sm-offset-3">
			<div class="well">
				{{ Form::label('title', trans('adminlte_lang::message.partner_name')) }}
				<p class="lead">{{ $partner->title }}</p>

				{{ Form::label('type', trans('adminlte_lang::message.partner_type')) }}
				<p class="lead">
					@if ($partner->type == "company")
						{{ trans('adminlte_lang::message.company') }}
					@elseif (($partner->type == "person"))
						{{ trans('adminlte_lang::message.person') }}
					@else
						{{ trans('adminlte_lang::message.self_employed') }}
					@endif
				</p>
			
				{{ Form::label('inn', trans('adminlte_lang::message.INN')) }}
				<p class="lead">{{ $partner->inn }}</p>

				{{ Form::label('kpp', trans('adminlte_lang::message.KPP')) }}
				<p class="lead">{{ $partner->kpp }}</p>

				{{ Form::label('contacts', trans('adminlte_lang::message.partner_contacts')) }}
				<p class="lead">{{ $partner->contacts }}</p>

				{{ Form::label('phone', trans('adminlte_lang::message.phone')) }}
				<p class="lead">{{ $partner->phone }}</p>

				{{ Form::label('email', trans('adminlte_lang::message.email')) }}
				<p class="lead">{{ $partner->email }}</p>

				{{ Form::label('address', trans('adminlte_lang::message.address')) }}
				<p class="lead">{{ $partner->address }}</p>
				
				{{ Form::label('description', trans('adminlte_lang::message.description')) }}
				<p class="lead">{{ $partner->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('partner', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('partner.edit', trans('adminlte_lang::message.edit'), [$partner->partner_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('partner', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['partner.destroy', $partner->partner_id], 'method' => 'DELETE']) !!}
								{{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger btn-block']) }}
							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
						{{ Html::linkRoute('partner.index', trans('adminlte_lang::message.partners').' »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 
																												'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection