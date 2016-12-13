@extends('adminlte::layouts.auth')

@section('htmlheader_title')
	Password recovery
@endsection

@section('content')

<body class="login-page">
	<div id="app">

		<div class="login-box">
		<div class="login-logo">
			<a href="{{ url('/home') }}"><b>Barcelona</b>Info</a>
		</div><!-- /.login-logo -->

		@if (session('status'))
			<div class="alert alert-success">
				{{ session('status') }}
			</div>
		@endif

		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<strong>Ой!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<div class="login-box-body">
			<p class="login-box-msg">{{ trans('adminlte_lang::message.passwordreset') }}</p>
			<p class="login-box-subtitle text-center">Введите номер телефона или email, на который необходимо выслать новый пароль</p>
			<form action="{{ url('/password/email') }}" method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group has-feedback">
					<input type="email" class="form-control" placeholder="Email или номер телефона" name="email" value="{{ old('email') }}"/>
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>

				<div class="row">
					<div class="col-xs-12">
						<button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::message.sendpassword') }}</button>
					</div><!-- /.col -->
				</div>
			</form>
			<div class="row">
				<div class="col-xs-12 text-center">
					<p class="login-box-subtitle" style="padding-top:15px">Восстановили пароль?</p>
				</div>
				<div class="col-xs-12 text-center">
					<a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a><br>
				</div>
				<div class="col-xs-12 text-center">
					<a href="{{ url('/register') }}" class="text-center">{{ trans('adminlte_lang::message.registermember') }}</a>
				</div>
			</div>	
		</div><!-- /.login-box-body -->

	</div><!-- /.login-box -->
	</div>

	@include('adminlte::layouts.partials.scripts_auth')

	<script>
		$(function () {
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
				increaseArea: '20%' // optional
			});
		});
	</script>
</body>

@endsection
