<h1>Выборите категории услуги</h1>
<h4>Онлайн-запись</h4>

@foreach ($categories as $category)
    <a class="row category-row" data-id="{{ $category->service_category_id }}" data-name="{{ $category->online_reservation_name }}" href="#">
        <div class="col-xs-11 name">
            {{$category->online_reservation_name}}
        </div>
        <div class="col-xs-1 text-right"> <i class="fa fa-chevron-right" aria-hidden="true"></i> </div>
    </a>
@endforeach