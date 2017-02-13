<p>
    @lang('main.user:email_change_confirmation_email_text', ['url' => url('/'), 'email' => $user->new_email])
    <a href="{{url('/')}}/user/confirmEmailChange/{{$user->user_id}}/{{$user->confirmation_code}}">{{url('/')}}/user/confirmEmailChange/{{$user->user_id}}/{{$user->confirmation_code}}</a>
</p>
<p>@lang('main.user:email_change_confirmation_email_ignore')</p>