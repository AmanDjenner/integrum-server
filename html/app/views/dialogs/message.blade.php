<div class="modal {[(isset($message) && !isset($messageDetail))?'in':'hide']}" id="modalMessage" tabindex="-1" role="dialog" aria-labelledby="modalMessage" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" style="min-height:100px">
	<div id="alert" class="alert alert-{[ isset($message) ? ( is_array($message ) && isset($message['alert'])?$message['alert']:'default'):'default']} col-xs-2" style="text-align:center"><i  id='icon' class="fa-2x fa {[ isset($message)? ((is_array($message ) && isset($message['icon']))?$message['icon']:'fa-info-circle'):'fa-info-circle']}"></i></div>
	<div class="col-xs-10" style="overflow-y:auto;max-height:80px;"> 
		<h3 style="margin-top:0" id='message'>{[ isset($message)? (is_array($message )?$message['message']:$message):'']}</h3>
	</div>
      </div>
      <div class="modal-footer">
 		<button type="button" id="messageOK" class="btn btn-default btn-primary" data-dismiss="modal">{[ Lang::get('content.OK') ]}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    <div class="modal {[ isset($messageDetail)?'in':'hide' ]}" id="modalMessageDetail" tabindex="-1" role="dialog" aria-labelledby="modalMessageDetail" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div id="alert" class="panel panel-{[ isset($message) ? ( is_array($message ) && isset($message['alert'])?$message['alert']:'default'):'default']}">
    <div class="panel-heading" role="tab">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
          <i  id='icon' class="fa {[ isset($message) ? ( is_array($message ) && isset($message['icon'])?$message['icon']:'fa-info-circle'):'fa-info-circle']}"></i>&nbsp;<span  id='message'>{[ isset($message) ? (is_array($message )?$message['message']:$message):'' ]}</span>
		<i style="float:right" class="fa fa-caret-right"></i>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseOne">
      <div class="panel-body" id="messageDetail">
	  {[$messageDetail or '']}
      </div>
    </div>
  </div>
</div>  
      </div>
      <div class="modal-footer">
 		<button type="button" id="messageOK" class="btn btn-default btn-primary" data-dismiss="modal">{[ Lang::get('content.OK') ]}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->