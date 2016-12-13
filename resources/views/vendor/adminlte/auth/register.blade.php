@extends('adminlte::layouts.auth')

@section('htmlheader_title')
	Register
@endsection

@section('content')

<body class="hold-transition register-page">
	<div id="app">
		<div class="register-box">
			<div class="register-logo">
				<a href="{{ url('/home') }}"><b>Barcelona</b>Info</a>
			</div>

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

			<div class="register-box-body">
				<p class="login-box-msg">{{ trans('adminlte_lang::message.registermember') }}</p>
				<form action="{{ url('/register') }}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group has-feedback">
						<input type="text" class="form-control" placeholder="{{ trans('adminlte_lang::message.orgname') }}" name="orgname" value="{{ old('orgname') }}"/>
						<span class="glyphicon glyphicon-briefcase form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="text" class="form-control" placeholder="{{ trans('adminlte_lang::message.fullname') }}" name="name" value="{{ old('name') }}"/>
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="phone" class="form-control" placeholder="{{ trans('adminlte_lang::message.phone') }}" name="phone" value="{{ old('phone') }}"/>
						<span class="glyphicon glyphicon-phone form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="email" class="form-control" placeholder="{{ trans('adminlte_lang::message.email') }}" name="email" value="{{ old('email') }}"/>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.retrypepassword') }}" name="password_confirmation"/>
						<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
					</div>
					
					<div class="row" style="padding-bottom: 15px">
						<div class="col-xs-12 ">
							<a href="#promoModal" role="button" data-toggle="modal">{{ trans('adminlte_lang::message.iknow') }}{{ strtolower(trans('adminlte_lang::message.promo')) }}</a>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-1">
							<label>
								<div class="checkbox_register icheck">
									<label>
										<input type="checkbox" name="terms">
									</label>
								</div>
							</label>
						</div><!-- /.col -->
						<div class="col-xs-10">
							<div class="form-group">
								<p class="login-box-subtitle">{{ trans('adminlte_lang::message.terms') }}
									<a href="#" type="button" data-toggle="modal" data-target="#termsModal">{{ trans('adminlte_lang::message.conditions') }}</a>
								</p>
							</div>
						</div><!-- /.col -->
					</div>
					<div class="row">
						<div class="col-xs-12">
							<button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::message.register') }}</button>
						</div>
					</div>
				</form>

				{{-- @include('adminlte::auth.partials.social_login') --}}
				<div class="text-center">
					<p class="login-box-subtitle" style="margin-top:15px">{{ trans('adminlte_lang::message.membership') }}</p>
					<a href="{{ url('/login') }}" class="text-center">{{ trans('adminlte_lang::message.login') }}</a>
				</div>

			</div><!-- /.form-box -->
		</div><!-- /.register-box -->
	</div>

	@include('adminlte::layouts.partials.scripts_auth')

	@include('adminlte::auth.terms')

	@include('adminlte::auth.promo')

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
