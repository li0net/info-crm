@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employees') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.routines') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.routines') }}</li>
    </ol>
</section>
<div class="container-fluid">

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-6">
			<div class="input-group input-group-addon-right ">
				<input name="search_term" type="text" placeholder="{{ trans('adminlte_lang::message.search_by_name_descr') }}" class="input form-control" value="" autocomplete="off">
				<span class="input-group-btn">
					 <button type="submit" class="btn btn-primary">
						<i class="fa fa-search"></i> {{ trans('adminlte_lang::message.search') }}
					</button>
				</span>
			</div>
		</div>
        <div class="col-sm-6 text-right">
            <span class="input-group pull-right">
                <a href="{{ route('card.create') }}" class="btn btn-primary pull-right">{{ trans('adminlte_lang::message.routine_create_new') }}</a>
            </span>
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
					<th>{{ trans('adminlte_lang::message.title') }}</th>
					<th>{{ trans('adminlte_lang::message.description') }}</th>
					<th></th>
					<th class="text-center">{{ trans('adminlte_lang::message.actions') }}</th>
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
											<div class="form-group table-form-group">
												<a href="#card-items-{{$card->card_id}}" data-toggle="collapse" class="btn btn-link link-blue btn-xs card-items-toggle">
												<span class="badge label-danger hidden">0</span>
												{{ trans('adminlte_lang::message.routine_structure') }}
												<i class="fa fa-caret-down"></i></a>
											</div>
										</div>
									</div>
									<div id="card-items-{{$card->card_id}}" class="collapse card-items">
										<div class="row">
											<div class="col-sm-4 small"><strong>{{ trans('adminlte_lang::message.stock') }}</strong></div>
											<div class="col-sm-4 small"><strong>{{ trans('adminlte_lang::message.title') }}</strong></div>
											<div class="col-sm-4 small"><strong>{{ trans('adminlte_lang::message.amount') }}</strong></div>
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
							<td class="text-center">
								@if ($user->hasAccessTo('card', 'edit', 0))
									<a href="{{ route('card.edit', $card->card_id) }}" id="card_edit" class="table-action-link"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('card', 'delete', 0))
									{!! Form::open(['route' => ['card.destroy', $card->card_id], 'id' => 'form'.$card->card_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$card->card_id}}')" class="table-action-link danger-action"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{!! $cards->render() !!}
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

			// $('select[name="services_cats_detailed[]"]').change(function(){
			// 	console.log('jopa');
			// });
		});
	</script>
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>