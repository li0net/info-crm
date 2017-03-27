@extends('adminlte::layouts.app')

@section('htmlheader_title')
	<p>Информация о складской операции # {{ $transaction->id }}</p>
@endsection

@section('main-content')

    <section class="content-header">
        <h1>{{ trans('adminlte_lang::message.operation')}}</h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
            <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
            <li><a href="{{ url('/storagetransaction')}}">{{ trans('adminlte_lang::message.operations') }}</a></li>
            <li class="active">{{ trans('adminlte_lang::message.operation')}}</li>
        </ol>
    </section>

    <div class="container">

        @include('partials.alerts')

    <div class="row">
		<div class="col-sm-12">
            <dl class="dl-horizontal">
                <dd>{{ "Дата и время проведения операции: " }}</dd>
                <dt class="lead">{{ $transaction->date }}</dt>

                <dd>{{ "Тип операции: " }}</dd>
                <dt class="lead">
                    @if ($transaction->type == "income")
                    Приход
                    @elseif ($transaction->type == "expenses")
                    Расход
                    @elseif ($transaction->type == "discharge")
                    Списание
                    @else
                    Перемещение
                    @endif
                </dt>

                <dd>{{ "Описание: " }}</dd>
                <dt class="lead">{{ $transaction->description }}</dt>
            </dl>


            <div class="m-t pull-left">
                @if ($user->hasAccessTo('storageTransaction', 'delete', 0))
                    {!! Form::open(['route' => ['storagetransaction.destroy', $transaction->id], "class" => 'pull-left m-r', "method" => 'DELETE']) !!}
                        {{ Form::submit('Удалить', ['class'=>'btn btn-danger']) }}
                    {!! Form::close() !!}
                @endif
                @if ($user->hasAccessTo('storageTransaction', 'edit', 0))
                    {!! Html::linkRoute('storagetransaction.edit', 'Редактировать', [$transaction->id], ['class'=>'btn btn-primary pull-left']) !!}
                @endif
			</div>
		</div>
	</div>
@endsection