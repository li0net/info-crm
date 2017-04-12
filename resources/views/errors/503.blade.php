@extends('adminlte::layouts.errors')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.servererror') }}
@endsection

@section('main-content')

<div class="error-page">
    <h2 class="headline text-purple">Be right back.</h2>
</div><!-- /.error-page -->
@endsection