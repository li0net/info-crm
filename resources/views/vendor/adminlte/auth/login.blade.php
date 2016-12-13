@extends('adminlte::layouts.auth')

@section('htmlheader_title')
	Вход
@endsection

@section('content')
<body class="hold-transition login-page">
	<div id="app">
		<div class="login-box">
			<div class="login-logo">
				<a href="{{ url('/home') }}"><b>Barcelona</b>Info</a>
			</div><!-- /.login-logo -->

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
				<p class="login-box-msg"> {{ trans('adminlte_lang::message.siginsession') }} </p>
				<form action="{{ url('/login') }}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group has-feedback">
						<input type="email" class="form-control" placeholder="{{ trans('adminlte_lang::message.email') }} {{ trans('adminlte_lang::message.or') }} {{ strtolower(trans('adminlte_lang::message.phone')) }}" name="email"/>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="row">
						{{-- <div class="col-xs-8">
							<div class="checkbox icheck">
								<label>
									<input type="checkbox" name="remember"> {{ trans('adminlte_lang::message.remember') }}
								</label>
							</div>
						</div> --}}
						<div class="col-xs-12">
							<button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::message.buttonsign') }}</button>
						</div><!-- /.col -->
					</div>
				</form>

				{{-- @include('adminlte::auth.partials.social_login') --}}
				
				<div class="row">
					<div class="col-xs-12 text-center" style="padding-top: 15px">
						<a href="{{ url('/password/reset') }}">{{ trans('adminlte_lang::message.forgotpassword') }}</a><br>
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
