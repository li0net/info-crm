@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employees') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.partners') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.partners') }}</li>
    </ol>
</section>
<div class="container-fluid">

    @include('partials.alerts')

    <div class="row">
        <div class="col-sm-12 m-t">
            <a href="{{ route('partner.create') }}" class="btn btn-primary pull-right">{{ trans('adminlte_lang::message.partner_create_new') }}</a>
            <a href="#" class="btn btn-info m-r pull-right">{{ trans('adminlte_lang::message.load_from_excel') }}</a>
            <a href="#" class="btn btn-info m-r pull-right">{{ trans('adminlte_lang::message.upload_into_excel') }}</a>
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
                <th>{{ trans('adminlte_lang::message.partner_name') }}</th>
                <th>{{ trans('adminlte_lang::message.partner_contacts') }}</th>
                {{-- <th>{{ trans('adminlte_lang::message.requisites') }}</th> --}}
                <th>{{ trans('adminlte_lang::message.address') }}</th>
                <th>{{ trans('adminlte_lang::message.balance') }}</th>
                <th class="text-center">{{ trans('adminlte_lang::message.actions') }}</th>
                </thead>
                <tbody>
                @foreach($partners as $partner)
                <tr>
                    <th class="text-center">{{ $partner->partner_id }}</th>
                    <td>
                        {{ $partner->title }}
                        <br>
                        <small>{{ $partner->description }}</small>
                    </td>
                    <td>
                        {{ $partner->contacts }}
                        <br>
                        <small>{{ $partner->phone }}</small>
                        <br>
                        <small>{{ $partner->email }}</small>
                    </td>
                    {{-- <td>
                        <small>{{ trans('adminlte_lang::message.INN') }} {{ $partner->inn }}</small>
                        <br>
                        <small>{{ trans('adminlte_lang::message.KPP') }} {{ $partner->kpp }}</small>
                    </td> --}}
                    <td>
                        {{ $partner->address }}
                    </td>
                    <td>
                        0-00 &#8381;
                    </td>
                    <td class="text-center" style="">
                        @if ($user->hasAccessTo('partner', 'edit', 0))
                        <a href="{{ route('partner.edit', $partner->partner_id) }}" id="partner_edit" class="table-action-link"><i class='fa fa-pencil'></i></a>
                        @endif
                        @if ($user->hasAccessTo('partner', 'delete', 0))
                        {!! Form::open(['route' => ['partner.destroy', $partner->partner_id], 'id' => 'form'.$partner->partner_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
                        <a href="javascript: submitform('#form{{$partner->partner_id}}')" class="table-action-link"><i class='fa fa-trash-o'></i></a>
                        {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {!! $partners->render(); !!}
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