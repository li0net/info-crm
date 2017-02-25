<h1>Выберите день</h1>

@foreach ($days as $day)
    <a class="row day-row" data-id="{{$day['day']}}" data-name="{{$day['day']}}" href="#">
        <div class="col-sm-4">
            {{$day['day']}}
        </div>
        <div class="col-sm-4">
            {{$day['is_available']}}
        </div>
        <div class="col-sm-4">
            {{$day['is_nonworking']}}
        </div>
    </a>
    <hr>
@endforeach
