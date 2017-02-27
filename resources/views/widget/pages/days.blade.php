<h1>Выбор даты</h1>
<h4>Онлайн-запись</h4>

@foreach ($days as $day)
    <a class="row day-row" data-id="{{$day}}" data-name="{{$day}}" href="#">
        <div class="col-sm-11">
            {{$day}}
        </div>
        <div class="col-sm-1 text-right"> <i class="fa fa-chevron-right" aria-hidden="true"></i> </div>
    </a>
@endforeach
