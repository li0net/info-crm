<h1>Выберите день</h1>

@foreach ($days as $day)
    <a class="row day-row" data-id="{{$day}}" data-name="{{$day}}" href="#">
        <div class="col-sm-4">
            {{$day}}
        </div>
    </a>
    <hr>
@endforeach
