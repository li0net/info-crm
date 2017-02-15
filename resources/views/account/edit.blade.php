@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<h4>Информация о счете</h4>	
			<hr>	
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<div class="well">
				{{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
				{!! Form::model($account, ['route' => ['account.update', $account->account_id], 'method' => 'PUT']) !!}
					<div class="form-group">
						{{ Form::label('title', 'Название:', ['class' => 'form-spacing-top']) }}
						{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '70']) }}
					</div>

					<div class="form-group">
						{{ Form::label('type', "Тип счета: ", ['class' => 'form-spacing-top']) }}
						{{ Form::select('type', ['cash'=>'Наличный расчет', 'noncache'=>'Безналичный расчет'], 'cash', ['class' => 'form-control', 'required' => '']) }}
					</div>

					<div class="form-group">
						{{ Form::label('balance', "Начальный баланс: ", ['class' => 'form-spacing-top']) }}
						{{ Form::text('balance', null, ['class' => 'form-control']) }}
					</div>

					<div class="form-group">
						{{ Form::label('comment', "Комментарий: ", ['class' => 'form-spacing-top']) }}
						{{ Form::textarea('comment', null, ['class' => 'form-control']) }}
					</div>

					<hr>

					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<div class="row">
								<div class="col-sm-6">
									{!! Html::linkRoute('account.show', 'Отмена', [$account->account_id], ['class'=>'btn btn-danger btn-block']) !!}
								</div>
								<div class="col-sm-6">
									{{ Form::submit('Сохранить', ['class'=>'btn btn-success btn-block']) }}
								</div>
							</div>
						</div>
					</div>
				{!! Form::close() !!}	
			</div>
		</div>
	</div>

@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}