@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $account->title }}
@endsection

@section('main-content')
    <section class="content-header">
        <h1>@lang('adminlte_lang::message.account_information')</h1>
        <!--<ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Advanced Elements</li>
        </ol>-->
    </section>
	<div class="row m-t">
		@if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                <strong>Успешно:</strong> {{ Session::get('success') }}
            </div>
		@endif
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
        @if ($user->hasAccessTo('account', 'edit', 0))
            <div class="col-sm-6">
                {{ Html::linkRoute('account.index', trans('adminlte_lang::message.accounts').' »', [], ['class' => 'btn btn-info']) }}
                {!! Html::linkRoute('account.edit', trans('adminlte_lang::message.edit'), [$account->account_id], ['class'=>'btn btn-info']) !!}
            </div>
        @endif
        @if ($user->hasAccessTo('account', 'delete', 0))
            <div class="col-sm-6 text-right">
                {!! Form::open(['route' => ['account.destroy', $account->account_id], "method" => 'DELETE']) !!}
                    {{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-primary']) }}
                {!! Form::close() !!}
            </div>
        @endif
	</div>
@endsection