@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $card->title }}
@endsection

@section('main-content')

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="well">
				{{ Form::label('title', trans('adminlte_lang::message.title')) }}
				<p class="lead">{{ $card->title }}</p>

				{{ Form::label('description', trans('adminlte_lang::message.description')) }}
				<p class="lead">{{ $card->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('card', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('card.edit', trans('adminlte_lang::message.edit'), [$card->card_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('card', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['card.destroy', $card->card_id], "method" => 'DELETE']) !!}

							{{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
							{{ Html::linkRoute('card.index', trans('adminlte_lang::message.routines').' »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection