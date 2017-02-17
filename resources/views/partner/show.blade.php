@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $partner->title }}
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
		<div class="col-sm-6 col-sm-offset-3">
			<div class="well">
				{{ Form::label('title', "Наименование: ") }}
				<p class="lead">{{ $partner->title }}</p>

				{{ Form::label('type', "Тип счета: ") }}
				<p class="lead">
					@if ($partner->type == "company")
						Юридическое лицо
					@elseif (($partner->type == "person"))
						Физическое лицо
					@else
						Индивидуальный предприниматель
					@endif
				</p>
			
				{{ Form::label('inn', "ИНН: ") }}
				<p class="lead">{{ $partner->inn }}</p>

				{{ Form::label('kpp', "КПП: ") }}
				<p class="lead">{{ $partner->kpp }}</p>

				{{ Form::label('contacts', "Контактное лицо: ") }}
				<p class="lead">{{ $partner->contacts }}</p>

				{{ Form::label('phone', "Номер телефона: ") }}
				<p class="lead">{{ $partner->phone }}</p>

				{{ Form::label('email', "e-mail: ") }}
				<p class="lead">{{ $partner->email }}</p>

				{{ Form::label('address', "Адрес: ") }}
				<p class="lead">{{ $partner->address }}</p>
				
				{{ Form::label('description', "Описание: ") }}
				<p class="lead">{{ $partner->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('partner', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('partner.edit', 'Редактировать', [$partner->partner_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('partner', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['partner.destroy', $partner->partner_id], "method" => 'DELETE']) !!}

							{{ Form::submit('Удалить', ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
						{{ Html::linkRoute('partner.index', 'Все контрагенты »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection