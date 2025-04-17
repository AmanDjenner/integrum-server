<div class="modal" id="addUserDialog" role="dialog" aria-labelledby="addUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{[ Lang::get('content.add') ]}</h4>
            </div>
    {[ Form::model(NULL, ['method' => 'PATCH', 'route' => ['usercontrol.update', $integra->getId() /* BBBBBUGGGG */], 'id'=>'userPanel', 'class'=>'ajax']) ]}            
            <div class="modal-body" style="width: 80%; margin: 0 auto;">
	    <input type="hidden" value="{[$integra->getId()]}" name="integraId">
	    <input type="hidden" name="integraUserId">
        <input type="hidden" id="trans-userIdNew-placeholder" value="{[ Lang::get('content.integrum-user') ]}"></input>
        <input type="hidden" id="trans-integracode-placeholder" value="{[ Lang::get('content.user-integracode') ]} INTEGRA"></input>
            <div class="form-group">
                    <div class="input-group select2-bootstrap-prepend" id="userNew-integrum">
                    <span class="input-group-btn no-margin-xs">
                        <button type="button" class="no-margin-xs btn btn-default" style="height:40px;width:45px;padding:8px 6px"> 
                            <img class="logo icon-integrum" src="/img/logo_integrum_bw.svg" width="21" alt="INTEGRUM user"></span>
                        </button>							
                    </span>	
                    <select class="userIdNew" name="userId" id="newUser"  style="width:100%"></select>
                    </div>
            </div>
			<div class="form-group">
                        <div id="userNew-integra">
	<div class="col-md-6 nopadding pr-only-5">
                    	<div class="input-group frm-mr-ln">
						<span class="input-group-btn">
							<button type="button" class="no-margin-xs btn btn-default" style="height:40px;width:45px;"> 
								<i class="fa fa-lg fa-calculator icon-integra" style="float:left;color:#333;height:12.5px;margin-bottom:5px;margin-top:5px;margin-right:5px;"></i></span>
							</button>						
						</span>	
						<input class="form-control" type="text" placeholder="{[ Lang::get('content.user') ]}  INTEGRA" name="integraName" id="newUser-integra"></input>
						</div>
	</div>
	<div class="col-md-6 nopadding pull-right-md">
                <div class="frm-mr-ln input-group pwd"> 
                   	<input class="form-control" type="password" placeholder="{[ Lang::get('content.user-integracode') ]}  INTEGRA" name="integraCode" id="newUser-integraCode"></input>
                    <span class="input-group-btn">
                    <a href="#" id="changeToText" data-value='{"id":0,"span":"changeSpan","input":["newUser-integraCode"]}' class="btn btn-default changeToText" >
                            <span id="changeSpan" class="fa fa-eye"></span>
                        </a>
                </span>
                </div>
	</div>
						</div>
			</div>
                @include('integra/user/rights', ['newUser'=>true, 'insideModal'=>true, 'type'=>$type,'access'=>$access,'permProfileManage'=>$permProfileManage, 'profile'=>$profile])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{[Lang::get('content.cancel')]}</button>
                <button type="submit" class="btn btn-primary" id="confirmUserAdd" disabled="disabled">{[Lang::get('content.OK')]}</button>
            </div>
    {[ Form::close() ]}            
        </div>
    </div>
</div>
