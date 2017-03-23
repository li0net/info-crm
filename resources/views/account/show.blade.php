@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $account->title }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.account_information') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li><a href="/account">{{ trans('adminlte_lang::message.accounts') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.account_information') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        <div class="col-sm-12">
            <dl class="dl-horizontal">
                <dt>
                    {{ trans('adminlte_lang::message.account_name') }}
                </dt>
                <dd>
                    {{ $account->title }}
                </dd>

                <dt>
                    {{ trans('adminlte_lang::message.account_type') }}
                </dt>
                <dd>
                    @if ($account->type == "cash")
                    {{ trans('adminlte_lang::message.cash') }}
                    @else
                    {{ trans('adminlte_lang::message.non-cash') }}
                    @endif
                </dd>
                <dt>
                    {{ trans('adminlte_lang::message.balance') }}
                </dt>
                <dd>
                    {{ $account->balance }}
                </dd>
                <dt>
                    {{ trans('adminlte_lang::message.description') }}
                </dt>
                <dd>
                    {{ $account->comment }}
                </dd>
            </dl>
        </div>
        <div class="col-sm-12 text-right">
            @if ($user->hasAccessTo('account', 'edit', 0))
                {!! Html::linkRoute('account.edit', trans('adminlte_lang::message.edit'), [$account->account_id], ['class'=>'btn btn-primary pull-right']) !!}
            @endif
            @if ($user->hasAccessTo('account', 'delete', 0))
            {!! Form::open(['route' => ['account.destroy', $account->account_id], 'class'=>'pull-right m-r', "method" => 'DELETE']) !!}
            {{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger']) }}
            {!! Form::close() !!}
            @endif
        </div>
    </div>
</div>

@endsection