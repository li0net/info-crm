<h1>Выберите категорию услуги</h1>
@foreach ($employees as $employee)
<a class="row employee-row" data-id="{{ $employee->employee_id }}" data-name="{{ $employee->name }}" href="#">
    <div class="col-sm-4">
        @if( $employee->avatar != null)
        <img src="/images/{{ $employee->avatar }}" />
        @else
        <img src="/images/no-master.png" alt="">
        @endif
    </div>
    <div class="col-sm-4">
        {{$employee->name}}
    </div>
    <div class="col-sm-4">
        {{$employee->email}}
    </div>
</a>
<hr>
@endforeach
