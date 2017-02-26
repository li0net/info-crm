<h1>Выбор времени</h1>
<h4>Онлайн-запись</h4>

@for ($i = 0; $i < count($times); $i++)
    <a class="row time-row" data-id="{{ $i }}" data-name="{{$times[$i]->work_start}} - {{$times[$i]->work_end}}"  href="#">
        <div class="col-sm-11">
            {{$times[$i]->work_start}} - {{$times[$i]->work_end}}
        </div>
        <div class="col-sm-1"> <i class="fa fa-chevron-right" aria-hidden="true"></i> </div>
    </a>
@endfor
