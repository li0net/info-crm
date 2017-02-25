@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $storage->title }}
@endsection

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
		
		<div class="alert alert-success" role="alert">
			<strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
		</div>

		@endif
	</div>
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="well">
				{{ Form::label('title', trans('adminlte_lang::message.storage_title')) }}
				<p class="lead">{{ $storage->title }}</p>

				{{ Form::label('type', trans('adminlte_lang::message.storage_type')) }}
				<p class="lead">
					@if( $storage->type == 0 )
						{{ trans('adminlte_lang::message.writeoff_supplies') }}
					@else
						{{ trans('adminlte_lang::message.sale_goods') }}
					@endif
				</p>

				{{ Form::label('description', trans('adminlte_lang::message.description')) }}
				<p class="lead">{{ $storage->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('storage', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('storage.edit', trans('adminlte_lang::message.edit'), [$storage->storage_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('storage', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['storage.destroy', $storage->storage_id], "method" => 'DELETE']) !!}
								{{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger btn-block']) }}
							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
							{{ Html::linkRoute('storage.index', trans('adminlte_lang::message.storages').' »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 
																													'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection