<h1>Выбор филиала</h1>
<h4>Онлайн-запись</h4>

@foreach ($organizations as $organization)
    <a class="row division-row" data-id="{{ $organization->organization_id }}" data-name="{{ $organization->name}}" data-address="{{ $organization->address}}" data-phone="{{ $organization->phone_1 }}" href="#">
        <div class="col-sm-1">
            <img src="{{$organization->getLogoUri()}}" class="img-thumbnail">
        </div>
        <div class="col-sm-4">
            <div class="name">{{ $organization->name }}</div>
            <div class="description">{{ $organization->category }}</div>
        </div>
        <div class="col-sm-6 description"> {{ $organization->shortinfo }} </div>
        <div class="col-sm-1"> <i class="fa fa-chevron-right" aria-hidden="true"></i> </div>
    </a>
@endforeach
