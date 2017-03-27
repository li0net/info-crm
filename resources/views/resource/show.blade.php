@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ $resource->name }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ $resource->name }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
        <li><a href="{{ url('/resource')}}">{{ trans('adminlte_lang::message.resources') }}</a></li>
        <li class="active">{{ $resource->name }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        <div class="col-sm-12">
            <dl class="dl-horizontal">
                <dt>{{ trans('adminlte_lang::message.resource_name') }}</dt>
                <dd>{{ $resource->name }}</dd>

                <dt>{{ trans('adminlte_lang::message.description') }}</dt>
                <dd>{{ $resource->description }}</dd>
            </dl>


                <div class="m-t text-left">
                    @if ($user->hasAccessTo('resource', 'delete', 0))
                    {!! Form::open(['route' => ['resource.destroy', $resource->resource_id],
                        "method" => 'DELETE', "class" => 'pull-left m-r']) !!}
                        {{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-info']) }}
                    {!! Form::close() !!}
                    @endif
                    @if ($user->hasAccessTo('resource', 'edit', 0))
                        {!! Html::linkRoute('resource.edit', trans('adminlte_lang::message.edit'),
                        [$resource->resource_id], ['class'=>'btn btn-primary pull-left']) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection