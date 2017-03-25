@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $employee->name }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.employee') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li><a href="{{ url('/employee') }}">{{ trans('adminlte_lang::message.employees') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.employee') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        <div class="col-sm-2 text-center">
            <div class="logo-block">
                <div v-if="!image">
                    @if( $employee->avatar_image_name != null)
                    <img src="/images/{{ $employee->avatar_image_name }}" />
                    @else
                    <img src="/images/no-master.png" alt="">
                    @endif
                </div>
                <div v-else>
                    <img :src="image" />
                </div>
            </div>
        </div>
        <div class="col-sm-10">
            <dl class="dl-horizontal text-block">
                <dt>{{trans('adminlte_lang::message.employee')}}</dt>
                <dd>#{{ $employee->employee_id }}</dd>

                <dt>{{trans('adminlte_lang::message.employee_name')}}</dt>
                <dd>{{ $employee->name }}</dd>

                <dt>Email:</dt>
                <dd>{{ $employee->email }}</dd>

                <dt>{{ trans('adminlte_lang::message.employee_phone') }}</dt>
                <dd>{{ $employee->phone }}</dd>

                <dt>{{ trans('adminlte_lang::message.employee_position') }}</dt>
                <dd>{{ $employee->position->title }}</dd>
            </dl>
        </div>
        <div class="col-sm-12">
            @if ($user->hasAccessTo('employee', 'delete', 0))
                {!! Form::open(['route' => ['employee.destroy', $employee->employee_id], "method" => 'DELETE', "class" => 'pull-left m-r']) !!}
                {{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger']) }}
                {!! Form::close() !!}
            @endif
            @if ($user->hasAccessTo('employee', 'edit', 0))
                {!! Html::linkRoute('employee.edit', trans('adminlte_lang::message.edit'), [$employee->employee_id], ['class'=>'btn btn-primary pull-left']) !!}
            @endif
        </div>
    </div>
</div>
@endsection