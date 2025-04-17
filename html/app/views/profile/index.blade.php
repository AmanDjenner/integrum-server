@extends('layouts.default',['titleDetail'=>Lang::get('content.profiles')])

@section('content')
<input type="hidden" value="{[ csrf_token() ]}" name="_token">
<div class="col-lg-12 top-buffer content-header"><div class="top-buffer width-100" style="margin-left: 32px;">
    <h1 class="user-h1">{[Lang::get('content.profiles')]}</h1>
    <a href="#" id="addLink" class="btn-create"><i class="fa fa-lg fa-plus"></i></a>
        </div>
</div>
    <div class="col-lg-12" id="middle">
    <div class="row col-lg-offset-3 col-lg-6">
            <div class="col-lg-6">
                <label for="input-rola" class="control-label">{[Lang::get('content.nameNewProfileLabel')]}</label>
				<select size="25" class="form-control profile-list" name="input-profileList" id="input-profileList" style="width:100%">
				@foreach ($profile as $pro)
					<option value="{[ $pro['id'] ]}">{[ $pro['name'] ]}</option>
				@endforeach
				</select>
            </div>
            <div class="col-lg-6">
                <label for="userType" class="control-label">{[ Lang::get('content.typeUser') ]}</label>
                <div>
                    {[ Form::select('userType', $type, '0', ['class'=>'form-control frm-mr-ln', 'id'=>'userType','disabled'=>'disabled']); ]}
                </div>
                <label for="accessList" class="control-label">{[ Lang::get('content.permissions') ]}</label><div class="btn-group pull-right"><button id="check-all" class="btn btn-xs btn-default" disabled><i class="far fa-lg fa-check-square"></i></button><button id="check-invert" class="btn btn-xs btn-default" disabled><i class="fa fa-lg fa-check-square"></i></button><button id="check-none" class="btn btn-xs btn-default" disabled><i class="far fa-lg fa-square"></i></button></div>
				<div class="clearfix"></div>
                <div class="profile-rights">
                    <div class="form-control-noheight frm-mr-ln user-checkbox" id="accessList">
                    @foreach ($access as $acc)
<input type="checkbox" class="regular-checkbox" value="{[ $acc->id ]}" name="accessList[{[ $acc->id  ]}]" id="accessList[{[ $acc->id  ]}]" disabled />
<label for="accessList[{[  $acc->id ]}]"></label> <label class="label-checkbox">{[ $acc->name ]}</label>
					@endforeach
                    </div>
                </div>
            </div>
    </div>
    <div class="row col-lg-offset-3 col-lg-6">
        <div class="">
            <div class="form-group">
				<div class="col-xs-6">
				    <div>
					<button type="button" class="btn btn-default btn-icon pull-right" id="btn-editcancel" style="display:none" title="{[ Lang::get('content.cancel') ]}">
                    <i class="fa fa-lg fa-ban"></i>
					</button>
				    </div>
				    <div>
					<button disabled type="button" class="btn btn-default btn-icon pull-right" id="btn-profileremove" title="{[ Lang::get('content.remove') ]}" data-toggle="modal" data-id="0" data-target="#confirmDeleteProfile">
						<i class="fa fa-lg fa-times red-txt"></i>
					</button>
				    </div>
				</div>
				<div class="col-xs-6">
					<button type="button" class="btn btn-warning btn-icon" id="btn-profile" title="{[ Lang::get('content.save') ]}">
						<i class="fa fa-lg fa-download"></i>
					</button>
				</div>
            </div>
        </div>
    </div>
</div>
@stop
@section('modalDialogs')
@include('profile/newprofiledialog')
@include('profile/removeprofiledialog')
@stop
@section('javascripts')
<script src="/js/profile-edit.6c0b19d1.js"></script>
@stop