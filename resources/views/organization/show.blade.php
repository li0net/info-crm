@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.org_info') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.information') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
        <li><a href="{{ url('/organization/info/edit')}}">{{ trans('adminlte_lang::message.information') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.org_info') }}</li>
    </ol>
</section>

<div class="container">
    <div class="row">
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                <strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
            </div>
        @endif
    </div>
    <div class="row">
        {{-- {!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', "class" => "hidden", "id" => "form228"]) !!} --}}
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#menu1">{{ trans('adminlte_lang::message.contacts') }}</a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#menu2">{{ trans('adminlte_lang::message.description') }}</a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#menu3">@lang('main.organization:logo_label')</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="menu1" class="tab-pane fade in active">
                        <dl class="dl-horizontal">
                            <dt>{{ trans('adminlte_lang::message.address') }}</dt>
                            <dd>{{ $organization->address }}</dd>

                            <dt>{{ trans('adminlte_lang::message.zip_code') }}</dt>
                            <dd>{{ $organization->post_index }}</dd>

                            <dt>{{ trans('adminlte_lang::message.phone') }}</dt>
                            <dd>{{ $organization->phone_1 }}</dd>

                            <dt>{{ trans('adminlte_lang::message.phone') }}</dt>
                            <dd>{{ $organization->phone_2 }}</dd>

                            <dt>{{ trans('adminlte_lang::message.phone') }}</dt>
                            <dd>{{ $organization->phone_3 }}</dd>

                            <dt>{{ trans('adminlte_lang::message.site') }}</dt>
                            <dd>{{ $organization->website }}</dd>

                            <dt>{{ trans('adminlte_lang::message.opening_hours') }}</dt>
                            <dd>{{ $organization->work_hours }}</dd>
                        </dl>
                    </div>

                    <div id="menu2" class="tab-pane fade">
                        <dl class="dl-horizontal">
                            <dt>{{ trans('adminlte_lang::message.description') }}</dt>
                            <dd>{!! $organization->info !!}</dd>
                        </dl>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                        <div class="logo-block text-center">
                            <img src="{{$organization->getLogoUri()}}" >
                        </div>
                    </div>
                </div>
            </div>
        {{-- {!! Form::close() !!} --}}
    </div>
@stop