@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.storages') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.storages')}}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.storages')}}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        <div class="col-sm-12 text-right">
            <a href="#" class="btn btn-info">{{ trans('adminlte_lang::message.move_goods') }}</a>
            <a href="{{ route('storage.create') }}" class="btn btn-primary">{{ trans('adminlte_lang::message.new_storage') }}</a>
        </div>
        <div class="col-sm-12">
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-hover table-condensed">
                <thead>
                <th class="text-center">#</th>
                <th>{{ trans('adminlte_lang::message.storage_title') }}</th>
                <th>{{ trans('adminlte_lang::message.number_of_units') }}</th>
                <th class="text-center">{{ trans('adminlte_lang::message.actions') }}</th>
                </thead>
                <tbody>
                @foreach($storages as $storage)
                <tr>
                    <th class="text-center">{{ $storage->storage_id }}</th>
                    <td>
                        {{ $storage->title }}
                        <br>
                        <small>{{ $storage->description }}</small>
                    </td>
                    <td>
                        {{ count($storage->products) }} товар(ов)
                    </td>
                    <td class="text-center">
                        @if ($user->hasAccessTo('storage', 'edit', 0))
                        <a href="{{ route('storage.edit', $storage->storage_id) }}" id="storage_edit" class="table-action-link"><i class='fa fa-pencil'></i></a>
                        @endif
                        @if ($user->hasAccessTo('storage', 'delete', 0))
                        {!! Form::open(['route' => ['storage.destroy', $storage->storage_id], 'id' => 'form'.$storage->storage_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
                        <a href="javascript: submitform('#form{{$storage->storage_id}}')" class="table-action-link"><i class='fa fa-trash-o'></i></a>
                        {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {!! $storages->render(); !!}
            </div>
        </div>
    </div>
</div>
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>