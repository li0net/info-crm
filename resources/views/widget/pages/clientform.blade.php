<h1>Оформление</h1>
<h4>Онлайн-запись</h4>

<form onsubmit="return false;" id ='requestForm'>
    <input type="hidden" name="time" value="{{ $data['time'] }}">
    <input type="hidden" name="date" value="{{ $data['date'] }}">
    <input type="hidden" name="employee_id" value="{{ $data['employeeId'] }}">
    <input type="hidden" name="organization_id" value="{{ $data['organizationId'] }}">
    <input type="hidden" name="service_id" value="{{ $data['serviceId'] }}">

    <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control" id="clientName" name="client_name" placeholder="Name">
            <div class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></div>
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control" id="clientPhone" name="client_phone" placeholder="+7 phone">
            <div class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></div>
        </div>

    </div>
    <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control" id="clientComment" name="client_comment" placeholder="Comment">
            <div class="input-group-addon"><i class="fa fa-comment" aria-hidden="true"></i></div>
        </div>
    </div>

    <div class="form-group disabled">
        <label for="remind">Remind me</label>
        <select name="client[remind]" id="clientRemind" class="form-control" disabled>
            <option value="1 hour">1 hour</option>
            <option value="2 hours">2 hours</option>
            <option value="1 day">1 day</option>
        </select>
    </div>

    <div class="form-group">
        <div class="col-sm-12 text-left">
            <div class="checkbox">
                <label>
                    <input type="checkbox"  id="agree" name="agree">
                    Нажимая кнопку "Записаться", Вы соглашаетесь с <a href="#">условиями пользовательского соглашения</a>
                </label>
            </div>
        </div>
    </div>
    <div class="col-sm-12 text-center">
        <button id="sendRequest" type="button" class="btn btn-default">Записаться</button>
    </div>
</form>


