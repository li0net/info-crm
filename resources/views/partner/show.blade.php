@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $partner->title }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.partner_information') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li><a href="{{ url('/partner')}}">{{ trans('adminlte_lang::message.partners') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.partner_information') }}</li>
    </ol>
</section>
<div class="container">
    <div class="row">
        @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            <strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
        </div>
        @endif
        <div class="col-sm-12">
            <dl class="dl-horizontal">
                <dt>{{  trans('adminlte_lang::message.partner_name') }}</dt>
                <dd>{{ $partner->title }}</dd>

                <dt>{{ trans('adminlte_lang::message.partner_type') }}</dt>
                <dd>
                    @if ($partner->type == "company")
                    {{ trans('adminlte_lang::message.company') }}
                    @elseif (($partner->type == "person"))
                    {{ trans('adminlte_lang::message.person') }}
                    @else
                    {{ trans('adminlte_lang::message.self_employed') }}
                    @endif
                </dd>

                <dt>{{ trans('adminlte_lang::message.INN') }}</dt>
                <dd>{{ $partner->inn }}</dd>

                <dt>{{ trans('adminlte_lang::message.KPP') }}</dt>
                <dd>{{ $partner->kpp }}</dd>

                <dt>{{ trans('adminlte_lang::message.partner_contacts') }}</dt>
                <dd>{{ $partner->contacts }}</dd>

                <dt>{{ trans('adminlte_lang::message.phone') }}</dt>
                <dd>{{ $partner->phone }}</dd>

                <dt>{{ trans('adminlte_lang::message.email') }}</dt>
                <dd>{{ $partner->email }}</dd>

                <dt>{{ trans('adminlte_lang::message.address') }}</dt>
                <dd>{{ $partner->address }}</dd>

                <dt>{{ trans('adminlte_lang::message.description') }}</dt>
                <dd>{{ $partner->description }}</dd>
            </dl>
        </div>
        <div class="m-t text-right">
            @if ($user->hasAccessTo('partner', 'edit', 0))
            {!! Html::linkRoute('partner.edit', trans('adminlte_lang::message.edit'), [$partner->partner_id], ['class'=>'btn btn-primary pull-right']) !!}
            @endif
            @if ($user->hasAccessTo('partner', 'delete', 0))
            {!! Form::open(['route' => ['partner.destroy', $partner->partner_id], 'method' => 'DELETE', 'class' => 'pull-right']) !!}
            {{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger m-r']) }}
            {!! Form::close() !!}
            @endif
        </div>
    </div>
</div>
@endsection