<div class="row">
    <div class="col-sm-12">
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                <strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-error" role="alert">
                <strong>@lang('main.general_error'):</strong> {{ Session::get('error') }}
            </div>
        @endif
    </div>
</div>