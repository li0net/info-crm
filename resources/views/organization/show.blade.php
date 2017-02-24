@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.org_info') }}
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
		{{-- {!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', "class" => "hidden", "id" => "form228"]) !!} --}}
			<div class="col-sm-8 col-sm-offset-2">
				<div class="well">
					<ul class="nav nav-tabs">
						<li class="active">
							<a data-toggle="tab" href="#menu1">{{ trans('adminlte_lang::message.contacts') }}</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#menu2">{{ trans('adminlte_lang::message.description') }}</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#menu3">{{ trans('adminlte_lang::message.photo') }}</a>
						</li>
					</ul>
				
					<div class="tab-content">
						<div id="menu1" class="tab-pane fade in active">
							<div class="row">
								{!! Form::open([null, 'method' => 'POST', 'id' => 'organization_form__info']) !!}
									{!! Form::hidden('id', 'organization_form__info') !!}
									{!! Form::hidden('coordinates', null, ['id' => 'coordinates']) !!}
									<div class="col-sm-10">
										<div class="form-group">
											{{ Form::label('address', trans('adminlte_lang::message.address'), ['class' => 'ctrl-label']) }}
											<p>{{ $organization->address }}</p>
										</div>

										<div class="form-group">
											{{ Form::label('post_index', trans('adminlte_lang::message.zip_code'), ['class' => 'ctrl-label']) }}
											<p>{{ $organization->post_index }}</p>
										</div>

										<div class="form-group">
											{{ Form::label('phone_1', trans('adminlte_lang::message.phone'), ['class' => 'ctrl-label']) }}
											<p>{{ $organization->phone_1 }}</p>
										</div>

										<div class="form-group">
											{{ Form::label('phone_2', trans('adminlte_lang::message.phone'), ['class' => 'ctrl-label']) }}
											<p>{{ $organization->phone_2 }}</p>
										</div>

										<div class="form-group">
											{{ Form::label('phone_3', trans('adminlte_lang::message.phone'), ['class' => 'ctrl-label']) }}
											<p>{{ $organization->phone_3 }}</p>
										</div>

										<div class="form-group">
											{{ Form::label('website', trans('adminlte_lang::message.site'), ['class' => 'ctrl-label']) }}
											<p>{{ $organization->website }}</p>
										</div>

										<div class="form-group">
											{{ Form::label('work_hours', trans('adminlte_lang::message.opening_hours'), ['class' => 'ctrl-label']) }}
											<p>{{ $organization->work_hours }}</p>
										</div>
									</div>
								{!! Form::close() !!}
							</div>
						</div>

						<div id="menu2" class="tab-pane fade">
							{!! Form::open([null, 'method' => 'POST', "id" => "organization_form__description"]) !!}
								<div class="form-group">
									<p>{{ $organization->info }}</p>
								</div>
							{!! Form::close() !!}
						</div>
						
						<div id="menu3" class="tab-pane fade">
							{!! Form::open([null, 'method' => 'POST', "id" => "organization_form__gallery"]) !!}
								<div class="logo-block">
									<img src="/images/no-master.png" alt="">
								</div>
							{!! Form::close() !!}
						</div>

						<hr>
						
						<div class="row">
							<div class="col-sm-4 col-sm-offset-4">
								<div class="row">
									<div class="col-sm-12">
										{{ Html::linkRoute('organization.edit', 
										trans('adminlte_lang::message.basic_settings').' »', [], 
																					['class' => 'btn btn-default btn-block btn-h1-spacing',
																					 'style' => 'margin-top:15px']) }}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		{{-- {!! Form::close() !!} --}}
	</div>
@stop