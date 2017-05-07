<div class="info-header text-left">
    <a href="#" class="close-info">
        <i class="fa fa-arrow-left" aria-hidden="true"></i>
    </a>
    <span>{{ trans('main.widget:info') }}</span>
</div>

<div class="info-body container">
    <h1>{{ $organization->name }}</h1>
    <h4>{{ $organization->category }}</h4>

    <div class="info-body-block">
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <img src="{{$organization->getLogoUri()}}" class="img-thumbnail img-responsive">
                <br>
                <p>{{ $organization->shortinfo }}</p>
            </div>
            <div class="col-xs-12 col-sm-6">
                <h3>{{ trans('main.widget:contacts') }}</h3>
                <div class="row">
                    <div class="col-sm-4 col-xs-12 fat">{{ trans('main.widget:phone') }} #1</div>
                    <div class="col-sm-8 col-xs-12">{{ $organization->phone_1 }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-xs-12 fat">{{ trans('main.widget:phone') }} #2</div>
                    <div class="col-sm-8 col-xs-12">{{ $organization->phone_2 }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-xs-12 fat">{{ trans('main.widget:phone') }} #3</div>
                    <div class="col-sm-8 col-xs-12">{{ $organization->phone_3 }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-xs-12 fat">{{ trans('main.widget:address') }}</div>
                    <div class="col-sm-8 col-xs-12">{{ $organization->address }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-xs-12 fat">{{ trans('main.widget:work_hours') }}</div>
                    <div class="col-sm-8 col-xs-12">{{ $organization->work_hours }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

