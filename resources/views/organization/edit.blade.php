@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.org_info') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.information') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.information') }}</li>
    </ol>
</section>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            {{-- {!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT', "class" => "hidden", "id" => "form228"]) !!} --}}
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#menu1"><i class="fa fa-phone" aria-hidden="true"></i>{{ trans('adminlte_lang::message.contacts') }}</a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#menu2"><i class="fa fa-id-card-o" aria-hidden="true"></i>{{ trans('adminlte_lang::message.description') }}</a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#menu3"><i class="fa fa-picture-o" aria-hidden="true"></i>{{ trans('adminlte_lang::message.photo') }}</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="menu1" class="tab-pane fade in active">
                    <div class="row">
                        {!! Form::model($organization, ['route' => 'info.save', 'method' => 'PUT', 'id' => 'organization_form__info', 'files' => 'true']) !!}
                        {!! Form::hidden('id', 'organization_form__info') !!}
                        {!! Form::hidden('coordinates', null, ['id' => 'coordinates']) !!}
                        <div class="col-sm-7 b-r">
                            <div class="form-group">
                                {{ Form::label('address', trans('adminlte_lang::message.address'), ['class' => 'ctrl-label']) }}
                                {{ Form::text('address', null, ['id' => 'addr',
                                'class' => 'text-left form-control',
                                'placeholder' => trans('adminlte_lang::message.address_example')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('post_index', trans('adminlte_lang::message.zip_code'), ['class' => 'ctrl-label']) }}
                                {{ Form::text('post_index', null, ['class' => 'text-left form-control',
                                'placeholder' => trans('adminlte_lang::message.zip_example')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('phone_1', trans('adminlte_lang::message.phone'), ['class' => 'ctrl-label']) }}
                                {{ Form::text('phone_1', null, ['class' => 'form-control',
                                'placeholder' => trans('adminlte_lang::message.phone_format')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('phone_2', trans('adminlte_lang::message.phone'), ['class' => 'ctrl-label']) }}
                                {{ Form::text('phone_2', null, ['class' => 'form-control',
                                'placeholder' => trans('adminlte_lang::message.phone_format')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('phone_3', trans('adminlte_lang::message.phone'), ['class' => 'ctrl-label']) }}
                                {{ Form::text('phone_3', null, ['class' => 'form-control',
                                'placeholder' => trans('adminlte_lang::message.phone_format')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('website', trans('adminlte_lang::message.site'), ['class' => 'ctrl-label']) }}
                                {{ Form::text('website', null, ['class' => 'form-control',
                                'placeholder' => trans('adminlte_lang::message.site_example')]) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('work_hours', trans('adminlte_lang::message.opening_hours'), ['class' => 'ctrl-label']) }}
                                {{ Form::text('work_hours', null, ['class' => 'form-control',
                                'placeholder' => trans('adminlte_lang::message.hours_example')]) }}
                            </div>
                        </div>

                        <div class="col-sm-5 text-center">
                            <div id='map' style='height:300px; margin-top: 15px; margin-bottom: 15px;' class='map-block'></div>
                            <div class="alert-info">{{ trans('adminlte_lang::message.map_instruction') }}</div>
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
                                {{ Form::button(trans('adminlte_lang::message.save'), ['class'=>'btn btn-success btn-block', 'id' => 'form_submit']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- {!! Form::close() !!} --}}
        </div>
    </div>
</div>

@stop

@section('page-specific-scripts')
	<script type="text/javascript">
		$(document).ready(function($) {
			var myMap, coordinates, myCenter = $('#coordinates').val().split(',');
			
			ymaps.ready(function () {
				myMap = new ymaps.Map('map', {
					center: (myCenter == '' || myCenter == null) ? [55.87, 37.66] : myCenter,
					zoom: 10
				});

				// ymaps.geolocation.get({
				// 	provider: 'yandex', 
				// 	autoReverseGeocode: true
				// }).then(function (result) {
				// 	var $container = $('#map'),
				// 		bounds = res.geoObjects.get(0).properties.get('boundedBy'),
				// 		mapState = ymaps.util.bounds.getCenterAndZoom(
				// 			bounds,
				// 			[$container.width(), $container.height()]
				// 		),
				// 		myMap = new ymaps.Map('map', mapState);
				// }, 
				// function (e) {
				// 	myMap = new ymaps.Map('map', {
				// 		center: myCenter,
				// 		zoom: 10
				// 	});
				// });

				myMap.behaviors.enable('scrollZoom');

				// Метка, содержимое балуна которой загружается с помощью AJAX.
				placemark = new ymaps.Placemark((myCenter == '' || myCenter == null) ? [55.87, 37.66] : myCenter, {
					iconContent: <?php echo "'".trans('adminlte_lang::message.specify_the_address')."'" ?>,
					hintContent: <?php echo "'".trans('adminlte_lang::message.drag_label')."'" ?>
				}, {
					draggable: "true",
					preset: "twirl#blueStretchyIcon",
					// Заставляем балун открываться даже если в нем нет содержимого.
					openEmptyBalloon: true
				});

				placemark.events.add('balloonopen', function (e) {
					placemark.properties.set('balloonContent', <?php echo "'".trans('adminlte_lang::message.loading')."'" ?>);

					// Имитация задержки при загрузке данных (для демонстрации примера).
					setTimeout(function () {
						ymaps.geocode(placemark.geometry.getCoordinates(), {
							results: 1
						}).then(function (res) {
							var newContent = res.geoObjects.get(0) ?
									res.geoObjects.get(0).properties.get('name') :
									<?php echo "'".trans('adminlte_lang::message.unable_to_locate')."'" ?>;

							// Задаем новое содержимое балуна в соответствующее свойство метки.
							placemark.properties.set('balloonContent', newContent);
							
							$('#addr').val(newContent);
							coordinates = placemark.geometry.getCoordinates();
							$('#coordinates').val(coordinates.join());
						});
					}, 500);
				});

				myMap.geoObjects.add(placemark);
			});

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

<script src="//api-maps.yandex.ru/2.0/?load=package.standard&lang=ru-RU" type="text/javascript"></script>