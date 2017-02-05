@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employees') }}
@endsection

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
		
		<div class="alert alert-success" role="alert">
			<strong>Успешно:</strong> {{ Session::get('success') }}
		</div>

		@endif
	</div>

	<div class="row">
		<div class="col-sm-7">
			<h4>Все технологические карты</h4>
		</div>	

		<div class="col-sm-5">
			<a href="{{ route('card.create') }}" class="btn btn-primary pull-right">Новая технологическая карта</a>
		</div>

		<div class="col-sm-12">
			<div class="input-group">
				<input name="search_term" type="text" placeholder="Поиск (по названию, описанию)" class="input form-control" value="" autocomplete="off">
				<span class="input-group-btn">
					 <button type="submit" class="btn btn btn-success">
						<i class="fa fa-search"></i> Найти
					</button>
				</span>
			</div>
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
					<th>Наименование</th>
					<th>Расходники</th>
					<th>Количество</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($cards as $card)
						<tr>
							<th class="text-center">{{ $card->card_id }}</th>
							<td>
								{{ $card->title }}
								<br>
								<small>{{ $card->description }}</small>
							</td>
							<td>
								{{-- {{ $card->card_items }} --}}
							</td>
							<td>
								{{-- {{ $card->card_items }} --}}
							</td>
							<td class="text-right">
								@if ($user->hasAccessTo('card', 'edit', 0))
									<a href="{{ route('card.edit', $card->card_id) }}" id="card_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('card', 'delete', 0))
									{!! Form::open(['route' => ['card.destroy', $card->card_id], 'id' => 'form'.$card->card_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$card->card_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
					{!! $cards->render(); !!} 
			</div>
		</div>
	</div>		
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>