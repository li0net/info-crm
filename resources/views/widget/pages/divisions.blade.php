
    <h1>Выберите филиал</h1>
    @foreach ($organizations as $organization)
        <a class="row division-row" data-id="{{ $organization->organization_id }}" data-name="{{ $organization->name}}" data-address="{{ $organization->address}}" data-phone="{{ $organization->phone_1 }}" href="#">
            <div class="col-sm-2"> <img src="{{$organization->getLogoUri()}}"> </div>
            <div class="col-sm-4">
                {{ $organization->name }}<br>
                {{ $organization->category }}
            </div>
            <div class="col-sm-6"> {{ $organization->shortinfo }} </div>
        </a>
        <hr>
    @endforeach
