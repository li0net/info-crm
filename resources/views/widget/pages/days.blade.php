<h1>{{ trans('main.widget:day_head') }}</h1>
<h4>{{ trans('main.widget:online_registration') }}</h4>

@foreach ($days as $day)
    <a class="row day-row" data-id="{{$day}}" data-name="{{$day}}" href="#">
        <div class="col-xs-11 col-xxs-10">
            {{$day}}
        </div>
        <div class="col-xs-1 col-xxs-2 text-right"> <i class="fa fa-chevron-right" aria-hidden="true"></i> </div>
    </a>
@endforeach
