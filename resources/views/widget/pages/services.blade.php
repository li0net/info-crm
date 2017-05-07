<h1>{{ trans('main.widget:service_head') }}</h1>
<h4>{{ trans('main.widget:online_registration') }}</h4>
@foreach ($services as $service)
    <a class="row service-row" data-id="{{ $service->service_id }}"  data-name="{{ $service->name }}" href="#">
        <div class="col-xs-5 col-xxs-10">
            <div class="name">{{$service->name}}</div>
            <div class="description">от {{$service->price_min}}</div>
        </div>
        <div class="mob-hidden col-xs-6 description">{{ trans('main.widget:duration') }}: {{$service->duration}}</div>
        <div class="col-xxs-2 col-xs-1 text-right chevron-block"> <i class="fa fa-chevron-right" aria-hidden="true"></i> </div>
    </a>
@endforeach
