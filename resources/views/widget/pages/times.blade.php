<h1>Выберите время</h1>

@for ($i = 0; $i < count($times); $i++)
    <a class="row time-row" data-id="{{ $i }}" data-name="{{ $i }}"  href="#">
        <div class="col-sm-10">
            {{$times[$i]->work_start}} - {{$times[$i]->work_end}}
        </div>
    </a>
    <hr>
@endfor
