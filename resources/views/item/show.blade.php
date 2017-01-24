@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $item->title }}
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
		<div class="col-md-6 col-md-offset-3">
			<div class="well">
				{{ Form::label('title', "Наименование: ") }}
				<p class="lead">{{ $item->title }}</p>

				{{ Form::label('type', "Тип статьи: ") }}
				<p class="lead">
					@php
						switch ($item->type) {
							case 'income':
								echo 'Доходы'; break;
							case 'exp_oncost':
								echo 'Расходы', ' ', 'на', ' ', 'себестоимость'; break;
							case 'sales_exp':
								echo 'Коммерческие', ' ', 'расходы'; break;
							case 'staff_exp':
								echo 'Расходы', ' ', 'на', ' ', 'персонал'; break;
							case 'admin_exp':
								echo 'Административно-хозяйственные', ' ', 'расходы'; break;
							case 'taxes':
								echo 'Налоги', ' ', 'и', ' ', 'сборы'; break;
							default:
								echo 'Прочие'; break;
						}
					@endphp
				</p>
				
				{{ Form::label('description', "Описание: ") }}
				<p class="lead">{{ $item->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('item', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('item.edit', 'Редактировать', [$item->item_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('item', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['item.destroy', $item->item_id], "method" => 'DELETE']) !!}

							{{ Form::submit('Удалить', ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-md-12">
							{{ Html::linkRoute('item.index', 'Все статьи »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>

			</div>
		</div>
	</div>
@endsection