<h1>{{ trans('main.widget:division_head') }}</h1>
<h4>{{ trans('main.widget:online_registration') }}</h4>

@foreach ($organizations as $organization)
    <a class="row division-row" data-id="{{ $organization->organization_id }}" data-name="{{ $organization->name}}" data-address="{{ $organization->address}}" data-phone="{{ $organization->phone_1 }}" href="#">
        <div class="col-xs-2 text-left">
            <img src="{{$organization->getLogoUri()}}" class="img-thumbnail">
        </div>
        <div class="col-xs-4">
            <div class="name">{{ $organization->name }}</div>
            <div class="description">{{ $organization->category }}</div>
        </div>
        <div class="col-xs-5 description"> {{ $organization->shortinfo }} </div>
        <div class="col-xs-1 text-right chevron-block"> <i class="fa fa-chevron-right" aria-hidden="true"></i> </div>
    </a>
@endforeach
