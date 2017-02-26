<h1>Выбор исполнителя</h1>
<h4>Онлайн-запись</h4>

@foreach ($employees as $employee)
    <a class="row employee-row" data-id="{{ $employee->employee_id }}" data-name="{{ $employee->name }}" href="#">
        <div class="col-sm-1">
            @if( $employee->avatar != null)
               <img src="/images/{{ $employee->avatar }}"  class="img-thumbnail">
            @else
              <img src="/images/no-master.png" alt=""  class="img-thumbnail">
            @endif
        </div>
        <div class="col-sm-4">
            <div class="name">{{$employee->name}}</div>
            <div class="description">{{$employee->position_name}}</div>

        </div>
        <div class="col-sm-6 description">
            <div class="description">{{$employee->description}}</div>
        </div>
        <div class="col-sm-1"> <i class="fa fa-chevron-right" aria-hidden="true"></i> </div>
    </a>
@endforeach
