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
					<th>Описание</th>
					<th></th>
					<th></th>
					<th></th>
				</thead>
				<tbody>
					@foreach($cards as $card)
						<tr>
							<th class="text-center">{{ $card->card_id }}</th>
							<td>
								{{ $card->title }}
							</td>
							<td>
								{{ $card->description }}
							</td>
							<td>
								@if( null !== $card->card_items )
									<div class="row">
										<div class="col-sm-12 text-center">
											<div class="form-group">
												<a href="#card-items-{{$card->card_id}}" data-toggle="collapse" class="btn btn-link btn-xs card-items-toggle">
												<span class="badge label-danger hidden">0</span>
												Состав технологической карты
												<i class="fa fa-caret-down"></i></a>
											</div>
										</div>
									</div>
									<div id="card-items-{{$card->card_id}}" class="collapse card-items">
										<div class="row">
											<div class="col-sm-4 small"><strong>Наименование</strong></div>
											<div class="col-sm-4 small"><strong>Склад</strong></div>
											<div class="col-sm-4 small"><strong>Количество</strong></div>
										</div>
										<div class="row">
											<div class="col-sm-12"><hr></div>
										</div>
										
										<div class="form-group">
											@foreach($card->card_items as $card_item)
												<div class="row">
													<div class="col-sm-4 small">
														{{ $card_item[0] }}
													</div>
													<div class="col-sm-4 small">
														{{ $card_item[1] }}
													</div>
													<div class="col-sm-4 small">
														{{ $card_item[2] }}
													</div>
												</div>
											@endforeach
										</div>
									</div>
								@endif
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

@section('page-specific-scripts')
	<script type="text/javascript">
		$(document).ready(function($) {
			$('.card-items').on('shown.bs.collapse', function(e){
				$('a[href="#' + e.target.id + '"] .fa.fa-caret-down').toggleClass('fa-caret-down fa-caret-up');
			});

			$('.card-items').on('hidden.bs.collapse', function(e){
				$('a[href="#' + e.target.id + '"] .fa.fa-caret-up').toggleClass('fa-caret-up fa-caret-down');
			});

			$('.card-items').each(function() {
			  	var id = $(this).attr('id');

			  	$('a[href="#' + id + '"] .badge.label-danger').html($('#' + id + ' .form-group').children('.row').length);
			  	$('a[href="#' + id + '"] .badge.label-danger').removeClass('hidden');
			});

			$('select[name="services_cats_detailed[]"]').change(function(){
				console.log('jopa');
			});
		});
	</script>
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>