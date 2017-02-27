<h1>Выбор услуги</h1>
<h4>Онлайн-запись</h4>

@foreach ($services as $service)
    <a class="row service-row" data-id="{{ $service->service_id }}"  data-name="{{ $service->name }}" href="#">
        <div class="col-sm-5">
            <div class="name">{{$service->name}}</div>
            <div class="description">от {{$service->price_min}}</div>
        </div>
        <div class="col-sm-6 description">длительность: {{$service->duration}}</div>
        <div class="col-sm-1 text-right"> <i class="fa fa-chevron-right" aria-hidden="true"></i> </div>
    </a>
@endforeach
