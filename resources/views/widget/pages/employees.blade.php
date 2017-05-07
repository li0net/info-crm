<h1>{{ trans('main.widget:employee_head') }}</h1>
<h4>{{ trans('main.widget:online_registration') }}</h4>

@foreach ($employees as $employee)
    <a class="row employee-row" data-id="{{ $employee->employee_id }}" data-name="{{ $employee->name }}" href="#">
        <div class="col-xs-2 col-xxs-2">
            @if( $employee->avatar != null)
               <img src="/images/{{ $employee->avatar }}"  class="img-thumbnail">
            @else
              <img src="/img/crm/avatar/avatar100.jpg" alt=""  class="img-thumbnail">
            @endif
        </div>
        <div class="col-xs-4 col-xxs-8">
            <div class="name">{{$employee->name}}</div>
                <div class="description">{{$employee->position_name}}
            </div>
        </div>
        <div class="col-xs-5 description mob-hidden">
            <div class="description">{{$employee->description}}</div>
        </div>
        <div class="col-xs-1 col-xxs-2 text-right chevron-block"> <i class="fa fa-chevron-right" aria-hidden="true"></i> </div>
    </a>
@endforeach
