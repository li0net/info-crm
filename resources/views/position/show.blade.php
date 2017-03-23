@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $position->title }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ $position->title }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
        <li><a href="{{ url('/position')}}">{{ trans('adminlte_lang::message.positions') }}</a></li>
        <li class="active">{{ $position->title }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-12">
            <dl class="dl-horizontal">
                <dt>{{  trans('adminlte_lang::message.position_name') }}</dt>
                <dd>{{ $position->title }}</dd>

                <dt>{{ trans('adminlte_lang::message.description') }}</dt>
                <dd>{{ $position->description }}</dd>
            </dl>
        </div>
        <div class="m-t text-right">
            @if ($user->hasAccessTo('employee', 'edit', 0))
                {!! Html::linkRoute('position.edit', trans('adminlte_lang::message.edit'),
                                [$position->position_id],
                                ['class'=>'btn btn-primary pull-right'])
                !!}
            @endif
            @if ($user->hasAccessTo('position', 'delete', 0))
                {!! Form::open(['route' => ['position.destroy', $position->position_id],
                                "method" => 'DELETE']) !!}
                    {{ Form::submit(trans('adminlte_lang::message.delete'),
                                ['class'=>'btn btn-danger pull-right m-r']) }}
                {!! Form::close() !!}
            @endif
        </div>
    </div>
</div>
@endsection