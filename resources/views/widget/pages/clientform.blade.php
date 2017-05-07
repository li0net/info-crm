<h1>{{ trans('main.widget:form_head') }}</h1>
<h4>{{ trans('main.widget:online_registration') }}</h4>

<form onsubmit="return false;" id ='requestForm'>
    <input type="hidden" name="time" value="{{ $data['time'] }}">
    <input type="hidden" name="date" value="{{ $data['date'] }}">
    <input type="hidden" name="employee_id" value="{{ $data['employeeId'] }}">
    <input type="hidden" name="organization_id" value="{{ $data['organizationId'] }}">
    <input type="hidden" name="service_id" value="{{ $data['serviceId'] }}">
    <div class="form-message"></div>
    <div class="form-group">
        <div class="input-group name-box">
            <input type="text" class="form-control" id="clientName" name="client_name" placeholder="{{ trans('main.widget:name') }}" required>
            <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>
        </div>
    </div>
    <div class="form-group">
        <div class="input-group phone-box">
            <input type="text" class="form-control" id="clientPhone" name="client_phone" placeholder="{{ trans('main.widget:7_phone') }}" required>
            <div class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></div>
        </div>

    </div>
    <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control" id="clientComment" name="client_comment" placeholder="{{ trans('main.widget:comment') }}">
            <div class="input-group-addon"><i class="fa fa-comment" aria-hidden="true"></i></div>
        </div>
    </div>

    <div class="form-group disabled">
        <label for="remind">{{ trans('main.widget:remind_me') }}</label>
        <select name="client[remind]" id="clientRemind" class="form-control" disabled>
            <option value="1 hour">1 {{ trans('main.widget:hour') }}</option>
            <option value="2 hours">2 {{ trans('main.widget:hours') }}</option>
            <option value="1 day">1 {{ trans('main.widget:day') }}</option>
        </select>
    </div>

    <div class="form-group">
        <div class="col-xs-12 text-left agree-box">
            <div class="checkbox">
                <label>
                    <input type="checkbox"  id="agree" name="agree">
                    {{ trans('main.widget:i_agree') }} <a href="#" data-toggle="modal" data-target="#myModal-{{ App::getLocale() }}">{{ trans('main.widget:terms_conditions') }}</a>
                </label>
            </div>
        </div>
    </div>
    <div class="col-xs-12 text-center">
        <button id="sendRequest" type="button" class="btn btn-default">{{ trans('main.widget:send') }}</button>
    </div>
</form>