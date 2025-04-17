<?php
if ($user->login) {
    $login = $user->login;
} else {
    $login = $user->email;
}
?>
{[ Form::model($user->attributes(), ['class'=>'form-horizontal', 'method' => 'PATCH', 'route' => ['userapp.update', $user->id]]) ]}
<div class="col-sm-10 col-md-11 col-lg-8 margin-35">
    <div class="form-group">
        <label for="input-login" class="col-sm-2 col-md-offset-1 control-label">{[ Lang::get('content.login') ]}</label>
        <div class="col-sm-10 col-md-7">
            {[ Form::text('login',$login,['class'=>'form-control frm-mr-ln', 'id'=>'input-login', 'maxlength'=>'45']) ]}
            @if($errors->first('login'))
            <div class="alert alert-warning" role="alert">{[ $errors->first('login') ]}</div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="input-haslo" class="col-sm-2 col-md-offset-1 control-label">{[ Lang::get('content.login-pass') ]}</label>
        <div class="col-sm-10 col-md-7">
            <div class="input-group">
            {[ Form::password('password',['placeholder'=>$user->password, 'maxlength'=>'255', 'class'=>'form-control required frm-mr-ln', 'id'=>'input-haslo']) ]}
                <span class="input-group-btn">
                    <a href="#" id="changeToText" data-value='{"id":0,"span":"changeSpanAppl","input":["input-haslo"]}' class="btn changeToText" ><span id="changeSpanAppl" class="fa fa-eye"></span></a>
                </span>
        </div>
            @if($errors->first('password'))
            <div class="alert alert-warning" role="alert">{[ $errors->first('password') ]}</div>
            @endif
        </div>
    </div>
<?php $accessRightIdx = 0; ?>
@if ($user->accessRights)
@foreach($user->accessRights as $accessRight)
	@include('users/app/partials/accessRight', ['rol'=>$accessRight->roles, 'reg'=>$accessRight->regions, 'accessRightIdx'=>$accessRightIdx++])
@endforeach
@endif
@if ($permUserAppManage && $user->id!=Session::get('idUser')) 
	@include('users/app/partials/accessRight', ['rol'=>[], 'reg'=>[], 'accessRightIdx'=>$accessRightIdx])
@endif
@if ($permUserAppManage || $user->id==Session::get('idUser'))
    <div class="form-group">
        <div class="col-sm-10 col-md-7 col-sm-offset-2 col-md-offset-3 text-right">
            <button type="submit" title="{[ Lang::get('content.user-save') ]}" class="btn btn-icon btn-warning" id="appUserSubmit" ><i class="fa fa-lg fa-download"></i></button>
        </div>
    </div>
@endif
</div>
{[ Form::close() ]}
<input type="hidden" name="rights-group-count" id="rights-group-count" value="{[ $accessRightIdx ]}"></input>
@if ($permUserAppManage)
@section('usermodalDialogs')    
<div class="modal" id="confirm-deleteAppUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                &nbsp;&nbsp;
            </div>
            <div class="modal-body" style="width: 70%; margin: 0 auto;">
                <h3>{[ Lang::get('content.removeAppAccesssConfirm') ]}</h3>
            </div>
            <div class="modal-footer">
{[ Form::model($user->attributes(), ['class'=>'form-horizontal', 'method' => 'PATCH', 'route' => ['userapp.update', $user->id]]) ]}
<input type="hidden" name="login" id="remove-login"></input>
<input type="hidden" name="password" id="remove-password"></input>
<input type="hidden" name="roles[]" id="remove-roles"></input>
<input type="hidden" name="idAccessGroup" id="remove-idAccessGroup"></input>
                <button type="button" class="btn btn-default" data-dismiss="modal">{[ Lang::get('content.cancel') ]}</button>
				{[ Form::submit(Lang::get('content.remove'),['class'=>'btn btn-danger pull-right', 'id'=>'appUserSubmitDialog']) ]}
{[ Form::close() ]}
            </div>
        </div>
    </div>
</div>
@stop
@endif
{[ Form::close() ]}

