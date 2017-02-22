@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $account->title }}
@endsection

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
		
		<div class="alert alert-success" role="alert">
			<strong>Успешно:</strong> {{ Session::get('success') }}
		</div>

		@endif
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="well">
				{{ Form::label('title', trans('adminlte_lang::message.account_name')) }}
				<p class="lead">{{ $account->title }}</p>

				{{ Form::label('type', trans('adminlte_lang::message.account_type')) }}
				<p class="lead">
					@if ($account->type == "cash")
						{{ trans('adminlte_lang::message.cash') }}
					@else
						{{ trans('adminlte_lang::message.non-cash') }}
					@endif
				</p>
			
				<dl class="dl-horizontal">
					<label>{{ trans('adminlte_lang::message.balance') }}</label>
					<p class="lead">{{ $account->balance }}</p>
				</dl>

				{{ Form::label('comment', trans('adminlte_lang::message.description')) }}
				<p class="lead">{{ $account->comment }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('account', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('account.edit', trans('adminlte_lang::message.edit'), [$account->account_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('account', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['account.destroy', $account->account_id], "method" => 'DELETE']) !!}

							{{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
							{{ Html::linkRoute('account.index', trans('adminlte_lang::message.accounts').' »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection