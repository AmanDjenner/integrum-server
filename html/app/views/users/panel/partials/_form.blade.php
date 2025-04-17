{[ Form::hidden('integra-def-name-original',$user->attributes()["integraDefName"],['id'=>'integra-def-name-original']) ]}
{[ Form::hidden('trans-remove-confirm', Lang::get('content.removeUserFromPanelConfirm'),['id'=>'trans-remove-confirm']) ]}
{[ Form::hidden('trans-withoutassignedusers-on', Lang::get('content.withoutassignedusers-off'), ['id'=>'trans-withoutassignedusers-on'])]}
{[ Form::hidden('trans-withoutassignedusers-off', Lang::get('content.withoutassignedusers-on'), ['id'=>'trans-withoutassignedusers-off'])]} 
{[ Form::hidden('trans-cardheader', Lang::get('content.cardHeader'), ['id'=>'trans-cardheader'])]} 
{[ Form::hidden('transSlctNoPartition', Lang::get('content.slct-no-partition'), ['id'=>'trans-slct-no-partition'])]} 
<input type="hidden" value="{[ Lang::get('content.list-zone') ]}" id="translate-select-partition-label">
<input type="hidden" value="{[ Lang::get('content.typeUser') ]}" id="translate-user-type">
<input type="hidden" value="{[ Lang::get('content.permissions') ]}" id="translate-user-rights">
{[ Form::model($user->attributes(), ['class'=>'form-inline', 'method' => 'PATCH', 'route' => ['users.update', $user->id], 'files' => true ]) ]}
<div id="scrollHere" class="col-md-offset-2 col-lg-offset-3 margin-10" style="height:51px">
    {[ Form::hidden('tab','user-3') ]}
    @include('users/partials/_formhidden')
    <div class="form-group" >
	   <div class="pr-only-md-15">
        <label for="input-integraDefName" class="control-label-inline">{[Lang::get('content.name')]}</label>
      {[ Form::text('integraDefName',NULL,['class'=>'form-control no-margin-xs', 'maxlength'=>'16', 'id'=>'integra-def-name-nogroup']) ]}
		<div class="input-group" id="integra-def-name-group" style="display:none">
      {[ Form::text('integraDefName',NULL,['class'=>'form-control frm-mr-ln no-margin-xs', 'maxlength'=>'16', 'id'=>'integra-def-name']) ]}
      <div class="input-group-addon integraUserName-label"></div>
        {[ $errors->first('integraDefName') ]}
    </div>
    </div>
    </div>
    <div class="form-group">
        {[ Form::label('input-code2', Lang::get('content.user-integracode'),['class'=>'control-label-inline']) ]}
        <div class="input-group">
            {[ Form::password('code',['placeholder'=>isset($user)?$user->code:'', 'class'=>'form-control no-margin-xs', 'maxlength'=>'8', 'id'=>'input-code2']) ]}
            <span class="input-group-btn">
                <a href="#" id="changeToText" data-value='{"id":0,"span":"changeSpan","input":["input-code2"]}' class="btn changeToText" ><span id="changeSpan" class="fa fa-eye"></span></a>
            </span> 
        </div>
        @if($errors->first('code'))
        <div class="alert alert-warning" role="alert">{[ $errors->first('code') ]}</div>
        @endif
    </div>
    @if ($permUserEdit)
    <button type="submit" title="{[Lang::get('content.save')]}" class="btn btn-icon btn-default btn-xs-only-block btn-sm-only-block mb-sm-only-15 mb-xs-only-15" id="integra-def-name-submit"><i class="fa fa-lg fa-download"></i></button>
    @endif
</div>
{[Form::close()]}
<div>
    <div class="row visible-md visible-lg" ><hr style="margin-top:10px;font-size:3px;margin-bottom:10px;height:2px" /></div>
</div>
<div id="panels-div" class="mt-xs-only-15 mt-sm-only-15" 
@if ($hidePanels)
	style="display:none"
@endif
>
    {[ Form::model($user->attributes(), ['method' => 'PATCH', 'route' => ['usercontrol.update', $user->id], 'id'=>'userPanel', 'class'=>'ajax']) ]}
    <input type="hidden" name="userId" id="userId" value="{[ $user->id ]}"/>
    <input type="hidden" name="permUserIntegraEditable" id="permUserIntegraEditable" value="{[ $permUserIntegraCreate||$permUserIntegraEdit||$permUserIntegraRemove ]}"/>
    <div class="row col-sm-10 col-md-12">
        <div class="col-md-3 {[(!$permProfileExcept)?'col-md-offset-2':'']}">
            <div class="form-group">
                <label for="integraId" class="control-label">{[ Lang::get('content.panels') ]}</label>
				{[ Form::checkbox('withoutassignedusers', 1, null, ['id'=>'withoutassignedusers', 'name'=>'withoutassignedusers', 'data-width'=>'40px', 'data-title'=>Lang::get('content.withChildren')]) ]}
                <select multiple class="form-control frm-mr-ln user-panel-integra-list" name="integraId" id="integraId" style="margin-top:5px;">
                    <option></option>
                </select>
            </div>

			<div class="form-group">
			@if ($permUserIntegraRemove)
			<button id="btnRemoveUser" disabled class="btn btn-xs btn-default user-usun " type="button" title="{[Lang::get('content.removeUserFromPanel')]}" data-toggle="modal" data-id="0" data-target="#confirmDelete" data-title="{[ Lang::get('content.removeUserFromPanelConfirm')]}">
					<span class="fa-stack cardButton">
						<i class="fa fa-lg fa-stack-1x fa-user"></i>
						<span class="int-user-delete-overlay">
							<i class="fa fa-stack-1x fa-times"></i>
						</span>
					</span>
			</button>
			@else
				&nbsp;
			@endif
				<button type="button" id="integraUsersLinkBtn" class="btn btn-xs btn-default pull-right ml-10 " title="{[ Lang::get('content.linktopanelusers') ]}" disabled>
					<span class="fa-stack cardButton">
						<i class="fa fa-lg fa-stack-1x fa-user"></i>
						<span class="int-user-overlay">
							<i class="fa fa-stack-1x fa-calculator"></i>
						</span>
					</span>
				</button>
				<button type="button" id="cardReaderLink" class="btn btn-xs btn-default pull-right" data-idintegra="" data-useridx="" data-username="" data-toggle="modal" data-target="#modalAccessControl" disabled>
					<span class="fa-stack cardButton">
						<i class="fa fa-rotate-315 fa-stack-1x fa-credit-card"></i>

						<span class="cardAdd" style="display:none">
							<i class="fa fa-stack-1x fa-plus"></i>
						</span>
					</span>
				</button>
            </div>
            <div class="clearfix visible-lg visible-md"></div>
        </div>
            <div class="row {[ (($permProfileExcept)?'col-md-9':'col-md-6')]}" style="display:none;" id="integraUserRightsParent">
		@include('integra/user/rights', ['newUser'=>false, 'insideModal'=>false, 'objectLabel'=>true, 'type'=>$type,'access'=>$access,'permProfileManage'=>$permProfileManage, 'profile'=>$profile])
			<div class="form-group text-right">
			@if ($permUserIntegraCreate||$permUserIntegraEdit)
			<button type="submit" class="btn btn-icon btn-warning" id="btn-user-panel" title="{[Lang::get('content.savePanel')]}">
                                    <span class="fa-stack cardButton"style="color:#fff">
                                        <i class="fa fa-lg fa-stack-1x fa-download"></i>

                                        <span class="save-user-overlay" style="color:#f5d5d5;font-size:13px;">
                                            <i class="fa fa-stack-1x fa-calculator"></i>
                                        </span>
                                    </span>
        </button>
			@else 
				&nbsp;
			@endif
            </div>
            </div>
    </div>
    {[ Form::close() ]}
</div>
<div id="log"></div>
