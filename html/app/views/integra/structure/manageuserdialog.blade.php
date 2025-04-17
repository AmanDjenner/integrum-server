<div class="modal" id="manageUserControl" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{[ Lang::get('content.edit') ]}</h4>
            </div>
            <input type="hidden" id="trans-userIdNew-placeholder" value="{[ Lang::get('content.user') ]} INTEGRUM"></input>
            {[ Form::model(NULL, ['method' => 'PATCH', 'route' => ['usercontrol.update', $integra->getId() /* BBBBBUGGGG */], 'id'=>'userPanel', 'class'=>'ajax']) ]}            
                <div class="modal-body" style="width: 80%; margin: 0 auto;overflow-y:visible;">
                    <input type="hidden" value="{[$integra->getId()]}" name="integraId" id="integraId">
                    <input type="hidden" name="integraUserId" id="integraUserId">
                    <input type="hidden" id="integraUserIdx">
                    <div class="form-group" id="dialog-message">
                    </div>
                    <div class="form-group">
                            <div class="col-md-6 nopadding pr-only-5">
                                <div class="input-group frm-mr-ln">
                                    <span class="input-group-btn">
                                        <button type="button" class="no-margin-xs btn btn-default" style="height:40px;width:45px;" id="btn-integra-user-icon"> 
                                            <i class="fa fa-lg fa-calculator icon-integra" style="float:left;color:#333;height:12.5px;margin-bottom:5px;margin-top:5px;margin-right:5px;"></i>
                                        </button>
                                    </span>	
                                    <input name="integraName" class="form-control" readonly type="text" placeholder="{[ Lang::get('content.user') ]}  INTEGRA" id="newUser-integra" maxlength="16"></input>
                                </div>
                            </div>
                            <div class="col-md-6 nopadding pull-right-md">
                                <div class="frm-mr-ln input-group pwd"> 
                                    <input name="integraCode" class="form-control" readonly type="password" placeholder="{[ Lang::get('content.user-integracode') ]}  INTEGRA" id="user-integraCode" maxlength="8"></input>
                                    <span class="input-group-btn">
                                    <a href="#" id="changeToText" data-value='{"id":0,"span":"changeSpan","input":["user-integraCode"]}' class="btn btn-default changeToText" >
                                        <span id="changeSpan" class="fa fa-eye"></span>
                                    </a>
                                </span>
                                </div>
                            </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group select2-bootstrap-prepend">
                            <span class="input-group-btn">
                                <button id="icon-integrum-user" type="button" class="no-margin-xs btn btn-default" style="height:40px;width:45px;padding:8px 6px"> 
                                    <img class="logo icon-integrum" src="/img/logo_integrum_bw.svg" width="21" alt="INTEGRUM user"></span>
                                </button>
                            </span>	
                            <input type="hidden" id="newUserDisabledId" name="userId"></input>
                            <select class="userIdNew" name="userId" id="newUser" style="width:100%"></select>
                            <span class="input-group-btn">
                                <a id="gotoIntegrumUser" style="float:left;display:none" class="btn btn-default" href="" title="{[Lang::get('content.edit')]}"><i class="fa fa-lg fa-share"></i></a>
                            </span>	
                        </div>
                    </div>
                    @include('integra/user/rights', ['newUser'=>false, 'insideModal'=>true, 'type'=>$type,'access'=>$access,'permProfileManage'=>$permProfileManage, 'profile'=>$profile])
                </div>
                <div class="modal-footer">
                    <a id="confirmUnbindButton" style="float:left;display:none" data-toggle="modal" data-target="#confirmUnbind" class="btn btn-default" href="#" title="{[Lang::get('content.user-remove')]}">
                        <i class="fa fa-lg fa-unlink"></i>
                    </a>
                    <div style="float:left;display:none;" id="bindIntegrum">
                        <button id="integrum-add" type="button" class="btn btn-default" title="{[Lang::get('content.user-connect-create')]}"> 
                            <i class="fa fa-lg fa-plus"></i>
                        </button>
                        <button id="integrum-bind" type="button" class="btn btn-default {[$permUserSel?'':' disabled']}" title="{[Lang::get('content.user-connect-bind')]}">
                            <i class="fa fa-lg fa-link"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-default" id="confirmUserCancel">{[Lang::get('content.cancel')]}</button>
                    <button type="submit" class="btn btn-primary" id="confirmUserEdit">{[Lang::get('content.OK')]}</button>
                </div>
            {[ Form::close() ]}            
        </div>
    </div>
</div>
<div class="modal" id="confirmUnbind" role="dialog" aria-labelledby="confirmUnbindLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Delete Parmanently</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure about this ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{[Lang::get('content.cancel')]}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="confirm">{[Lang::get('content.remove')]}</button>
            </div>
        </div>
    </div>
</div>
