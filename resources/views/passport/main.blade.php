@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{$header}}
@endsection

@section('main-content')
    <div class="row">
        {!!$passportVueComponent!!}
</div>
@endsection