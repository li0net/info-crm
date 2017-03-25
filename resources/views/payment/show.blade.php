@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $payment->title }}
@endsection

@section('main-content')
    <section class="content-header">
        <h1>{{ trans('adminlte_lang::message.payment_create_new') }}</h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
            <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
            <li><a href="{{ url('/payment')}}">{{ trans('adminlte_lang::message.payments') }}</a></li>
            <li class="active">{{ trans('adminlte_lang::message.payment_create_new') }}</li>
        </ol>
    </section>
    <div class="container">

        @include('partials.alerts')
        <div class="row">
            <div class="col-sm-12">
                <dl class="dl-horizontal">
                    <dt>{{ trans('adminlte_lang::message.date_and_time') }}</dt>
                    <dd>{{ $payment->date }}</dd>

                    <dt>{{ trans('adminlte_lang::message.payment_item') }}</dt>
                    <dd>{{ $item->title }}</dd>

                    <dt>{{ trans('adminlte_lang::message.account') }}</dt>
                    <dd>{{ $account->title }}</dd>

                    <dt>{{ trans('adminlte_lang::message.beneficiary_type') }}</dt>
                    <dd class="lead">
                        @if ($payment->beneficiary_type == "partner")
                        {{ trans('adminlte_lang::message.partner') }}
                        @elseif (($payment->beneficiary_type == "client"))
                        {{ trans('adminlte_lang::message.client') }}
                        @else
                        {{ trans('adminlte_lang::message.employee') }}
                        @endif
                    </dd>

                    <dt>{{ trans('adminlte_lang::message.beneficiary_name') }}</dt>
                    <dd class="lead">
                        @if ($payment->beneficiary_type == "partner")
                        {{ $payment->partner->title }}
                        @elseif (($payment->beneficiary_type == "client"))
                        {{ $payment->client->name }}
                        @else
                        {{ $payment->employee->name }}
                        @endif
                    </dd>

                    <dt>{{ trans('adminlte_lang::message.sum') }}</dt>
                    <dd class="lead">{{ $payment->sum }}</dd>

                    <dt>{{ trans('adminlte_lang::message.description') }}</dt>
                    <dd class="lead">{{ $payment->description }}</dd>
                </dl>

                <div class="col-sm-12 text-left">
                    @if ($user->hasAccessTo('payment', 'edit', 0))
                        {!! Html::linkRoute('payment.edit', trans('adminlte_lang::message.edit'), [$payment->payment_id], ['class'=>'btn btn-primary']) !!}
                    @endif
                    @if ($user->hasAccessTo('payment', 'delete', 0))
                        {!! Form::open(['route' => ['payment.destroy', $payment->payment_id], "class"=> 'pull-left m-r', "method" => 'DELETE']) !!}
                        {{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger']) }}
                        {!! Form::close() !!}
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection