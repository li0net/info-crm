@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    @lang('main.user:change_email_result_page_header')
@endsection

@section('content')
    <body class="hold-transition login-page">
    <div id="app">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ url('/home') }}"><b>Barcelona</b>Info</a>
            </div><!-- /.login-logo -->

            @if (!$isChanged)
                <div class="alert alert-danger">
                    {{ trans('main.user:email_change_confirmation_error') }}<br>
                </div>
            @endif

            <div class="login-box-body">
                <p class="login-box-msg">@lang('main.user:email_change_confirmation_success', ['home' => url('/home'), 'usercabinet' => url('/user/cabinet')])</p>

            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
    </div>

    </body>

@endsection
