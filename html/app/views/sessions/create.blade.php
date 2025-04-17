@extends('layouts.sessions')

@section('content')
<?php
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
?>
<div class="login-vertical-align">


    <div class="loginbox">
        <div id="legend"><img class="logo" alt="Integrum" src="/img/logo_integrum_color.svg" width="180" style="padding-bottom:20px; margin-right: 40px;" /></div>
        <br />
        @if(!empty($messageLogin))
        <div class="alert alert-danger">{[ $messageLogin ]}</div><br />
        @endif
        {[ Form::open(['route' => 'sessions.store','class'=>'form']) ]}
        <input name="ipAddress" type="hidden" value="{[ $ip ]}">
        <div>
            {[ Form::text('login','',[
            'class'=>'form-control','id'=>'login',
            'placeholder'=>Lang::get('content.login')
            ]) ]}
        </div>
        <br />
        <div>
            {[ Form::password('password',[
            'class'=>'form-control',
            'placeholder'=>Lang::get('content.login-pass')
            ]) ]}
        </div><br />
        <div>
@if (isset($licenseOwner) && ((property_exists($licenseOwner, "err") && $licenseOwner->err<1)||!property_exists($licenseOwner, "err"))) 
{[ Form::submit(Lang::get('content.login-btn'),['class'=>'btn btn-primary btn-box form-control']) ]}
@endif
</div>
        {[ Form::close() ]}
        <div class="alert {[ $licenseOwner->alert or '' ]} margin-35" {[ isset($licenseOwner) ? '' : 'style="display:none"' ]} title="Właściciel licencji"><b>{[ $licenseOwner->message or '' ]}</b> </div>
    </div>
</div>
<script type="text/javascript">
document.getElementById('login').focus();
</script>
@if($message)
@if(!is_array($message))
<div class="alert alert-danger">{[ $message ]}</div><br />
@else
<div class="alert {[ $message['alert']=='alert-success'?'alert-warning':$message['alert'] ]}">{[ $message['message'] ]}</div><br />
@endif
@endif
@stop