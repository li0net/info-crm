@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_edit') }}
@endsection

@section('main-content')
	<div class="row">
		{{-- {!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', "class" => "hidden", "id" => "form228"]) !!} --}}
			<div class="col-sm-8 col-sm-offset-2">
				<div class="well">
					<ul class="nav nav-tabs">
						<li class="active">
							<a data-toggle="tab" href="#menu1">Контакты</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#menu2">Описание</a>
						</li>
						<li class="">
							<a data-toggle="tab" href="#menu3">Фото</a>
						</li>
					</ul>
				
					<div class="tab-content">
						<div id="menu1" class="tab-pane fade in active">
							<div class="row">
								{!! Form::model($organization, ['route' => 'info.save', 'method' => 'PUT', 'id' => 'organization_form__info', 'files' => 'true']) !!}
									{!! Form::hidden('id', 'organization_form__info') !!}
									{!! Form::hidden('coordinates', '', ['id' => 'coordinates']) !!}
									<div class="col-sm-7 b-r">
										<div class="form-group">
											{{ Form::label('address', 'Адрес:', ['class' => 'ctrl-label']) }}
											{{ Form::text('address', null, ['id' => 'addr', 'class' => 'text-left form-control', 'placeholder' => 'Например, ул. Парковая д.14, 23']) }}
										</div>

										<div class="form-group">
											{{ Form::label('post_index', 'Почтовый индекс:', ['class' => 'ctrl-label']) }}
											{{ Form::text('post_index', null, ['class' => 'text-left form-control', 'placeholder' => 'Например, 153150']) }}
										</div>

										<div class="form-group">
											{{ Form::label('phone_1', "Телефон: ", ['class' => 'ctrl-label']) }}
											{{ Form::text('phone_1', null, ['class' => 'form-control', 'placeholder' => 'Формат: 7 495 682 1414']) }}
										</div>

										<div class="form-group">
											{{ Form::label('phone_2', "Телефон: ", ['class' => 'ctrl-label']) }}
											{{ Form::text('phone_2', null, ['class' => 'form-control', 'placeholder' => 'Формат: 7 495 682 1414']) }}
										</div>

										<div class="form-group">
											{{ Form::label('phone_3', "Телефон: ", ['class' => 'ctrl-label']) }}
											{{ Form::text('phone_3', null, ['class' => 'form-control', 'placeholder' => 'Формат: 7 495 682 1414']) }}
										</div>

										<div class="form-group">
											{{ Form::label('website', "Сайт: ", ['class' => 'ctrl-label']) }}
											{{ Form::text('website', null, ['class' => 'form-control', 'placeholder' => 'Например, www.my-company.com']) }}
										</div>

										<div class="form-group">
											{{ Form::label('work_hours', "Часы работы: ", ['class' => 'ctrl-label']) }}
											{{ Form::text('work_hours', null, ['class' => 'form-control', 'placeholder' => 'Например, пн.-вс.: 11:00-22:00']) }}
										</div>
									</div>

									<div class="col-sm-5 text-center">
										<div id='map' style='height:300px; margin-top: 15px; margin-bottom: 15px;' class='map-block'></div>
										<div class="alert alert-info">Перемещайте маркер, чтобы указать расположение на карте. Щелкните мышью по маркеру, чтобы установить адрес.</div>
									</div>
								{!! Form::close() !!}
							</div>
						</div>

						<div id="menu2" class="tab-pane fade">
							{!! Form::model($organization, ['route' => 'info.save', 'method' => 'PUT', "id" => "organization_form__description"]) !!}
								<div class="form-group">
									{{ Form::textarea('info', null, ['class' => 'form-control']) }}
								</div>
							{!! Form::close() !!}
						</div>
						
						<div id="menu3" class="tab-pane fade">
							{!! Form::model($organization, ['route' => 'info.save', 'method' => 'PUT', "id" => "organization_form__gallery"]) !!}
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
										{{ Form::button('Сохранить', ['class'=>'btn btn-success btn-block', 'id' => 'form_submit']) }}
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

@section('page-specific-scripts')
	<script type="text/javascript">
		$(document).ready(function($) {
			var myMap, coordinates;

			ymaps.ready(init);

			function init () {
				var myMap = new ymaps.Map("map", {
					center: [54.83, 37.11],
					zoom: 10
				});

				myMap.behaviors.enable('scrollZoom');

				// Метка, содержимое балуна которой загружается с помощью AJAX.
				placemark = new ymaps.Placemark([55.8, 37.72], {
					iconContent: "Укажите адрес",
					hintContent: "Перетащите метку и кликните, чтобы указать адрес"
				}, {
					draggable: "true",
					preset: "twirl#blueStretchyIcon",
					// Заставляем балун открываться даже если в нем нет содержимого.
					openEmptyBalloon: true
				});

				placemark.events.add('balloonopen', function (e) {
					placemark.properties.set('balloonContent', "Идет загрузка данных...");

					// Имитация задержки при загрузке данных (для демонстрации примера).
					setTimeout(function () {
						ymaps.geocode(placemark.geometry.getCoordinates(), {
							results: 1
						}).then(function (res) {
							var newContent = res.geoObjects.get(0) ?
									res.geoObjects.get(0).properties.get('name') :
									'Не удалось определить адрес.';

							// Задаем новое содержимое балуна в соответствующее свойство метки.
							placemark.properties.set('balloonContent', newContent);
							
							$('#addr').val(newContent);
							coordinates = placemark.geometry.getCoordinates();
							$('#coordinates').val(coordinates.join());
						});
					}, 500);
				});

				myMap.geoObjects.add(placemark);
			}

			$('#form_submit').on('click', function() {
				var activeTab = $('ul.nav.nav-tabs li.active a').attr('href');

				if(activeTab == '#menu1') {
					$('#organization_form__info').submit();
				}

				if(activeTab == '#menu2') {
					$('#organization_form__description').submit();
				}
				
				if(activeTab == '#menu3') {
					$('#employee_form__gallery').submit();
				}
			});
		});
	</script>
@endsection