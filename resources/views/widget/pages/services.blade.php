<h1>Выберите услугу</h1>

@foreach ($services as $service)
    <a class="row service-row" data-id="{{ $service->service_id }}"  data-name="{{ $service->name }}" href="#">
        <div class="col-sm-4">
            {{$service->name}}
        </div>
        <div class="col-sm-4"> от {{$service->price_min}}</div>
        <div class="col-sm-4">длительность: {{$service->duration}}</div>
    </a>
    <hr>
@endforeach
