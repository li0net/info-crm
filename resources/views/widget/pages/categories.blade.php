<h1>{{ trans('main.widget:category_head') }}</h1>
<h4>{{ trans('main.widget:online_registration') }}</h4>

@foreach ($categories as $category)
    <a class="row category-row" data-id="{{ $category->service_category_id }}" data-name="{{ $category->online_reservation_name }}" href="#">
        <div class="col-xs-11 col-xxs-10 name">
            {{$category->online_reservation_name}}
        </div>
        <div class="col-xs-1 col-xxs-2 text-right"> <i class="fa fa-chevron-right" aria-hidden="true"></i> </div>
    </a>
@endforeach