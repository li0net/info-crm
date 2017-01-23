@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h1>Информация о статье доходов-расходов</h1>	
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
				{!! Form::open(['route' => 'item.store']) !!}
					<div class="form-group">
						{{ Form::label('title', 'Наименование:', ['class' => 'form-spacing-top']) }}
						{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
					</div>

					<div class="form-group">
						{{ Form::label('type', "Тип: ", ['class' => 'form-spacing-top']) }}
						{{ Form::select('type', ['income'=>'Доходы', 'exp_oncost'=>'Расходы на себестоимость', 'sales_exp'=>'Коммерческие расходы', 'staff_exp'=>'Расходы на персонал', 'admin_exp'=>'Административно-хозяйственные расходы', 'taxes'=>'Налоги и сборы', 'others'=>'Прочие'], 'income', ['class' => 'form-control', 'required' => '']) }}
					</div>

					<div class="form-group">
						{{ Form::label('description', "Описание: ", ['class' => 'form-spacing-top']) }}
						{{ Form::textarea('description', null, ['class' => 'form-control']) }}
					</div>

					{{	Form::submit('Создать новую статью', ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top:20px;']) }}
				{!! Form::close() !!}	
			</div>
		</div>
	</div>

@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}