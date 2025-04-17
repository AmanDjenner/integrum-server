<div class="{[$insideModal?'':'row ']} integraIsSelected" id="integraUserRights">
<div class="{[$insideModal?'': ((!$permProfileExcept)?'col-md-12':'col-md-6')]}">
<div class="form-group frm-mr-ln " id="objectIdPanel">
@if (isset($objectLabel) ? $objectLabel: false)
                <label for="objectId" class="control-label">{[ Lang::get('content.list-partition') ]}</label>
@endif	
		<select class="form-control frm-mr-ln pr-15" name="objectId" id="objectId">
			<option></option>
		</select>
</div>        
<div class="form-group">
@if (isset($objectLabel) ? $objectLabel: false)
     <label id="partitionListLabelOutside" for="partitionList" class="control-label">{[ Lang::get('content.list-zone') ]}</label>
@endif	
	<div style="    display: block;width: 100%;padding: 6px 10px;font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;margin-left:0px;max-height:25vh;overflow-y:auto;">
	<label id="partitionListLabel" for="partitionList" class="control-label-inline">{[ Lang::get('content.list-zone') ]}</label>
	<ul id="partitionList" class="checkbox" style="margin: 0; padding: 0; margin-left: 20px; list-style: none; "> 
	<li style="border: 1px transparent solid;display:inline-block;width:12em;"><label for="partitionList[0]">{[Lang::get('content.slct-no-partition')]}</label></li>
	</ul> 
	</div>
</div>
<div class="form-group">
	<input type="hidden" value='{[$type]}' id="user-types">
	<input type="hidden" value='{[$access]}' id="user-access">
	<input type="hidden" value='0' name="profileId" id="profile-id">
	<select class="form-control" id="input-profileList" >
	@foreach ($profile as $pro)
		<option data-utype="{[ $pro['t'] ]}" value="{[ $pro['id'] ]}">{[ $pro['name'] ]}</option>
	@endforeach
	</select>
</div>
@if ($permProfileExcept && !$insideModal)
<div class="form-group">
	<label for="userType" class="control-label">{[ Lang::get('content.typeUser') ]}</label>
	<div>
		{[ Form::select('userType', $typeDta, '0', ['class'=>'form-control', 'id'=>'userType']); ]}
	</div>
</div>
@else
    <input type="hidden" value="0" name="userType" id="userType">
@endif
<div class="form-group" id="userSchemaSection" {[ $insideModal?'style="height:40px;display:none;"' : 'style="display:none;"']}>
	<div class="col-md-12 nopadding frm-mr-ln">
	<div class="col-md-6 nopadding pr-only-md-15">
		{[ Form::number('userSchema',NULL,['class'=>'form-control', 'min'=>'1', 'max'=>'8', 'step'=>'1', 'id'=>'userSchema', 'placeholder'=>Lang::get('content.userSchema')]); ]}
	</div>
	<div class="col-md-6 nopadding pull-right-md">
		{[ Form::number('userSchemaCnt',NULL,['class'=>'form-control', 'min'=>'0', 'max'=>'254', 'step'=>'1', 'id'=>'userSchemaCnt', 'placeholder'=>Lang::get('content.userCnt')]); ]}
	</div>
	</div>
</div>
<div class="form-group" style="display:none" id="userCntSection">
	<label for="userCnt" class="control-label">{[ Lang::get('content.userCnt') ]}</label>
	<div>
		{[ Form::number('userCnt',NULL,['class'=>'form-control', 'min'=>'1', 'max'=>'255', 'step'=>'1', 'id'=>'userCnt']); ]}
	</div>
</div>   
@if (!$permProfileExcept || $insideModal)
<div class="form-group" id="profileRights">
	<div class='form-control' style='resize: vertical;overflow-y:auto;min-height:60px;height:32vh;' id="profileRightsDetails">
	<p id="profileRightsDetailsHas">
	</p>
	<p id="profileRightsDetailsDont" style="color:#CCC">
	</p>
	</div>
</div>
@else 
</div>
<div class="{[$insideModal?'':'col-md-6']}" style="{[($insideModal?'display:none':'')]}" id="profileRightsEditable">
	<div class="form-group">
	<label for="accessList" class="control-label">{[ Lang::get('content.permissions') ]}</label><div class="btn-group pull-right"><div id="check-all" class="btn btn-xs btn-default"><i class="far fa-check-square"></i></div><div id="check-invert" class="btn btn-xs btn-default"><i class="fa fa-check-square"></i></div><div id="check-none" class="btn btn-xs btn-default"><i class="far fa-square"></i></div></div>
    <div class="clearfix"></div>
	<div class="user-checkbox-rights form-control-border" style="{[($insideModal?'height: 22vh !important':'')]}">
		<div class="form-control-noheight" style="overflow:auto;"	 id="accessList">
		@foreach ($accessDta as $acc)
			<input type="checkbox" class="regular-checkbox" value="{[ $acc->id ]}" name="accessList[{[ $acc->id  ]}]" id="accessList[{[ $acc->id  ]}]" />
			<label for="accessList[{[  $acc->id ]}]"></label> <label class="label-checkbox">{[ $acc->name ]}</label>
		@endforeach
		</div>
	</div>
	</div>
@endif	
</div>
</div>
