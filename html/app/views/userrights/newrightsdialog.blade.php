<div class="modal" id="modalNewProfile" tabindex="-1" role="dialog" aria-labelledby="modalNewProfile" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{[ Lang::get('content.nameNewRole') ]}</h3>
            </div>
            <div class="modal-body" style="width: 70%; margin: 0 auto;">
                <div class = "col-xs-12 row" id = 'message'></div>
        {[ Form::label('input-profile', Lang::get('content.nameNewProfileLabel').' ',['class'=>'control-label']) ]}
        <div>
            {[ Form::text('input-profile',NULL,['class'=>'form-control frm-mr-ln', 'id'=>'input-profile']) ]}
            {[ $errors->first('forename') ]}
        </div>
            </div>
            <div class="modal-footer">
                <div style="float:right">
					<button type="button" class="btn btn-default" data-dismiss="modal">{[Lang::get('content.cancel')]}</button>
                    <button type="button" id="newProfileOK" class="btn btn-primary btn-ok" disabled data-toggle="tooltip" data-placement="top">{[ Lang::get('content.OK') ]}</button>
                </div>
            </div>
        </div>
    </div>
</div>