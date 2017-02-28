<div class="info-header text-left">
    <a href="#" class="close-info">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
    </a>
    <span>Информация о {{ $organization->name }} </span>
</div>

<div class="info-body container">
    <h1>{{ $organization->name }}</h1>
    <h4>{{ $organization->category }}</h4>

    <div class="info-body-block">
        <div class="row">
            <div class="col-xs-6">
                <p>
                    <img src="{{$organization->getLogoUri()}}" class="img-thumbnail">
                </p>
                <p>{{ $organization->shortinfo }}</p>
            </div>
            <div class="col-xs-6">
                <h3>Контакты</h3>
                <div class="row">
                    <div class="col-xs-4">Телефон</div>
                    <div class="col-xs-8">{{ $organization->phone_1 }}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4">Телефон</div>
                    <div class="col-xs-8">{{ $organization->phone_2 }}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4">Телефон</div>
                    <div class="col-xs-8">{{ $organization->phone_3 }}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4">Адрес</div>
                    <div class="col-xs-8">{{ $organization->address }}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4">Часы работы</div>
                    <div class="col-xs-8">{{ $organization->work_hours }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

