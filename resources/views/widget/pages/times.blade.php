<h1>{{ trans('main.widget:time_head') }}</h1>
<h4>{{ trans('main.widget:online_registration') }}</h4>

@for ($i = 0; $i < count($times); $i++)
    <a class="row time-row" data-id="{{$times[$i]}}" data-name="{{$times[$i]}}"  href="#">
        <div class="col-xs-11 col-xxs-10">
            {{$times[$i]}}
        </div>
        <div class="col-xs-1 text-right col-xxs-2"> <i class="fa fa-chevron-right" aria-hidden="true"></i> </div>
    </a>
@endfor
