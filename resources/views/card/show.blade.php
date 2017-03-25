@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ $card->title }}
@endsection

@section('main-content')
@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.routine_structure') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li><a href="{{ url('/card')}}">{{ trans('adminlte_lang::message.routings') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.routine_structure') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        <div class="col-sm-12">
            <dl class="dl-horizontal">
                <dt>{{ trans('adminlte_lang::message.title') }}</dt>
                <dd>{{ $card->title }}</dd>

                <dt>{{ trans('adminlte_lang::message.description') }}</dt>
                <dd>{{ $card->description }}</dd>
            </dl>
        </div>
        <div class="col-sm-12">
            @if ($user->hasAccessTo('card', 'edit', 0))
                {!! Html::linkRoute('card.edit', trans('adminlte_lang::message.edit'), [$card->card_id], ['class'=>'btn btn-primary pull-left']) !!}
            @endif
            @if ($user->hasAccessTo('card', 'delete', 0))
                {!! Form::open(['route' => ['card.destroy', $card->card_id], "method" => 'DELETE']) !!}
                    {{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger pull-left m-r']) }}
                {!! Form::close() !!}
            @endif
        </div>
    </div>
</div>
@endsection