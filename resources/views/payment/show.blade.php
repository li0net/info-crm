@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $payment->title }}
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
				{{ Form::label('date', trans('adminlte_lang::message.date_and_time')) }}
				<p class="lead">{{ $payment->date }}</p>

				{{ Form::label('item_id', trans('adminlte_lang::message.payment_item')) }}
				<p class="lead">{{ $item->title }}</p>

				{{ Form::label('account_id', trans('adminlte_lang::message.account')) }}
				<p class="lead">{{ $account->title }}</p>

				{{ Form::label('beneficiary_type', trans('adminlte_lang::message.beneficiary_type')) }}
				<p class="lead">
					@if ($payment->beneficiary_type == "partner")
						{{ trans('adminlte_lang::message.partner') }}
					@elseif (($payment->beneficiary_type == "client"))
						{{ trans('adminlte_lang::message.client') }}
					@else
						{{ trans('adminlte_lang::message.employee') }}
					@endif
				</p>

				{{ Form::label('beneficiary_title', trans('adminlte_lang::message.beneficiary_name')) }}
				<p class="lead">
					@if ($payment->beneficiary_type == "partner")
						{{ $payment->partner->title }}
					@elseif (($payment->beneficiary_type == "client"))
						{{ $payment->client->name }}
					@else
						{{ $payment->employee->name }}
					@endif
				</p>

				{{ Form::label('sum', trans('adminlte_lang::message.sum')) }}
				<p class="lead">{{ $payment->sum }}</p>

				{{ Form::label('description', trans('adminlte_lang::message.description')) }}
				<p class="lead">{{ $payment->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('payment', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('payment.edit', trans('adminlte_lang::message.edit'), [$payment->payment_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('payment', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['payment.destroy', $payment->payment_id], "method" => 'DELETE']) !!}
								{{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger btn-block']) }}
							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
						{{ Html::linkRoute('payment.index', trans('adminlte_lang::message.payments').' »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 
																												'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection