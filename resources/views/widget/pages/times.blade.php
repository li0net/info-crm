<h1>Выберите время</h1>
@foreach ($times as $time)
    <a class="row time-row" data-id="{{ $time }}" data-name="{{ $time }}"  href="#">
        <div class="col-sm-10">
            {{$time}}
        </div>
    </a>
    <hr>
@endforeach
