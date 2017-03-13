@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $partner->title }}
@endsection

@section('main-content')
    <section class="content-header">
        <h1>{{ trans('adminlte_lang::message.partner_information') }}</h1>
        <!--<ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Advanced Elements</li>
        </ol>-->
    </section>
	<div class="row m-t">
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
        <div class="col-sm-12 m-t">
            <div class="col-sm-6">
            {{ Html::linkRoute('partner.index', trans('adminlte_lang::message.partners').' »', [], ['class' => 'btn btn-info']) }}
            @if ($user->hasAccessTo('partner', 'edit', 0))
                {!! Html::linkRoute('partner.edit', trans('adminlte_lang::message.edit'), [$partner->partner_id], ['class'=>'btn btn-primary']) !!}
            @endif
            </div>
            @if ($user->hasAccessTo('partner', 'delete', 0))
                <div class="col-sm-6 text-right">
                    {!! Form::open(['route' => ['partner.destroy', $partner->partner_id], 'method' => 'DELETE']) !!}
                        {{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-info']) }}
                    {!! Form::close() !!}
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-sm-12">

            </div>
        </div>
	</div>
@endsection