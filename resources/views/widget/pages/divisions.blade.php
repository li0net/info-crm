<h1>{{ trans('main.widget:division_head') }}</h1>
<h4>{{ trans('main.widget:online_registration') }}</h4>

@foreach ($organizations as $organization)
    <a class="row division-row" data-id="{{ $organization->organization_id }}" data-name="{{ $organization->name}}" data-address="{{ $organization->address}}" data-phone="{{ $organization->phone_1 }}" href="#">
        <div class="col-xs-5 col-md-5 text-left mob-hidden">
            <img src="{{$organization->getLogoUri()}}" class="img-thumbnail">
        </div>
        <div class="col-xxs-10 col-xs-6 col-sm-6">
            <div class="name">{{ $organization->name }}</div>
            <div class="description">{{ $organization->category }}</div>
        </div>
        {{--<div class="col-xs-3 col-sm-5 description"> {{ $organization->shortinfo }} </div>--}}
        <div class="col-xxs-2 col-xs-1 col-sm-1 text-right chevron-block"> <i class="fa fa-chevron-right" aria-hidden="true"></i> </div>
    </a>
@endforeach
