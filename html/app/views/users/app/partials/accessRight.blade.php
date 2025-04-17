<div style="background-color:#{[($accessRightIdx%2==0)?'eee':'ccc']}">
    <div class="form-group">
        <label for="input-rola{[ $accessRightIdx]}" class="col-sm-2 col-md-offset-1 control-label">{[ Lang::get('content.login-role') ]}</label>
        <div class="col-sm-10 col-md-7">
	@if (!$permUserAppManage || $user->id==Session::get('idUser'))
			{[ Form::select('role-select' . $accessRightIdx, $approles, $rol, ['multiple' => 'multiple', 'class'=>'form-control frm-mr-ln required', 'id'=>'input-role-select' . $accessRightIdx,'disabled'=>'disabled','style'=>'margin-bottom:10px;width:100%;']) ]}
			{[ Form::hidden('roles' . $accessRightIdx .'[]', $rol==NULL?"":implode(",", $rol))]}
            @if($errors->first('roles' . $accessRightIdx))
            <div class="alert alert-warning" role="alert">{[ $errors->first('roles' . $accessRightIdx) ]}</div>
            @endif
	@else 
            {[ Form::select('roles' . $accessRightIdx .'[]', $approles, $rol, ['multiple' => 'multiple', 'class'=>'form-control frm-mr-ln required', 'id'=>'input-role' . $accessRightIdx,'style'=>'width:100%;']) ]}
            @if($errors->first('roles' . $accessRightIdx))
            <div class="alert alert-warning" role="alert">{[ $errors->first('roles' . $accessRightIdx) ]}</div>
            @endif
	@endif 
        </div>
    </div>
    <div class="form-group">
        <label for="input-idAccessGroup{[ $accessRightIdx]}" class="col-sm-2 col-md-offset-1 control-label">{[ Lang::get('content.idAccessGroup') ]}</label>
        <div class="col-sm-10 col-md-7">
	@if (!$permUserAppManage || $user->id==Session::get('idUser'))
			{[ Form::select('region-select' . $accessRightIdx, $regions, $reg, ['multiple' => 'multiple', 'class'=>'form-control frm-mr-ln required', 'id'=>'input-region-select' . $accessRightIdx,'disabled'=>'disabled','style'=>'margin-bottom:10px;width:100%;']) ]}
			{[ Form::hidden('regions' . $accessRightIdx .'[]', $reg==NULL?"":implode(",", $reg))]}
            @if($errors->first('regions' . $accessRightIdx))
            <div class="alert alert-warning" role="alert">{[ $errors->first('regions' . $accessRightIdx) ]}</div>
            @endif
	@else 
            {[ Form::select('regions' . $accessRightIdx .'[]', $regions, $reg, ['multiple' => 'multiple', 'class'=>'form-control frm-mr-ln required', 'id'=>'input-region' . $accessRightIdx,'style'=>'width:100%;']) ]}
            @if($errors->first('regions' . $accessRightIdx))
            <div class="alert alert-warning" role="alert">{[ $errors->first('regions' . $accessRightIdx) ]}</div>
            @endif
	@endif 
        </div>
    </div>
</div>
