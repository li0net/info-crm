@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employees') }}
@endsection

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
		
		<div class="alert alert-success" role="alert">
			<strong>{{ trans('adminlte_lang::message.partner_create_new') }}</strong> {{ Session::get('success') }}
		</div>

		@endif
	</div>

	<div class="row">
		<div class="col-sm-4">
			<h4>{{ trans('adminlte_lang::message.partners') }}</h4>
		</div>	

		<div class="col-sm-8">
			<a href="{{ route('partner.create') }}" class="btn btn-primary pull-right">{{ trans('adminlte_lang::message.partner_create_new') }}</a>
			<a href="#" class="btn btn-default m-r pull-right">{{ trans('adminlte_lang::message.load_from_excel') }}</a>
			<a href="#" class="btn btn-default m-r pull-right">{{ trans('adminlte_lang::message.upload_into_excel') }}</a>
		</div>

		<div class="col-sm-12">
			<hr>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table">
				<thead>
					<th class="text-center">#</th>
					<th>{{ trans('adminlte_lang::message.partner_name') }}</th>
					<th>{{ trans('adminlte_lang::message.partner_contacts') }}</th>
					{{-- <th>{{ trans('adminlte_lang::message.requisites') }}</th> --}}
					<th>{{ trans('adminlte_lang::message.address') }}</th>
					<th>{{ trans('adminlte_lang::message.balance') }}</th>
					<th></th>
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
							<td class="text-right" style="min-width: 100px;">
								@if ($user->hasAccessTo('partner', 'edit', 0))
									<a href="{{ route('partner.edit', $partner->partner_id) }}" id="partner_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('partner', 'delete', 0))
									{!! Form::open(['route' => ['partner.destroy', $partner->partner_id], 'id' => 'form'.$partner->partner_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$partner->partner_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
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
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>