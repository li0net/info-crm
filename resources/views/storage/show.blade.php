@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $storage->title }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ $storage->title }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li class="active">{{ $storage->title }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-12">
            <dl class="dl-horizontal">
                <dt>{{ trans('adminlte_lang::message.storage_title') }}</dt>
                <dd>{{ $storage->title }}</dd>

                <dt>{{ trans('adminlte_lang::message.storage_type') }} </dt>
                <dd>
                    @if( $storage->type == 0 )
                    {{ trans('adminlte_lang::message.writeoff_supplies') }}
                    @else
                    {{ trans('adminlte_lang::message.sale_goods') }}
                    @endif
                </dd>

                <dt>{{ trans('adminlte_lang::message.description') }}</dt>
                <dd>{{ $storage->description }}</dd>
            </dl>
        </div>
        <div class="col-sm-12">
            @if ($user->hasAccessTo('storage', 'edit', 0))
                {!! Html::linkRoute('storage.edit', trans('adminlte_lang::message.edit'), [$storage->storage_id], ['class'=>'btn btn-primary pull-right']) !!}
            @endif
            @if ($user->hasAccessTo('storage', 'delete', 0))
                {!! Form::open(['route' => ['storage.destroy', $storage->storage_id], "method" => 'DELETE', "class" => 'pull-right m-r']) !!}
                    {{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger ']) }}
                {!! Form::close() !!}
            @endif
        </div>
	</div>
@endsection