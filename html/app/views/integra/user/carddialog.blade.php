<div style="display:none" id="modalAccessControlCardList" data-cardList='{[ $cardList ]}'></div>
<div class="modal" id="modalAccessControl" tabindex="-1" role="dialog" aria-labelledby="modalAccessControl" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div id="activeDiode" class="diode green outlined" style="float:right"></div>
                <h3>{[ Lang::get('content.cardHeader') ]}</h3>
            </div>
            <div class="modal-body" style="width: 70%; margin: 0 auto;">
                <div class = "col-xs-12 row" id = 'message'></div>
                <input name="cardState" id="cardState" type="hidden" value="">
                <input name="cardTimer" id="cardTimer" type="hidden" value="">
                <input name="initialCardNumer" id="initialCardNumer" type="hidden" value="">


                <label for="accessControllers">{[ Lang::get('content.reader') ]}:</label>
                <select class="form-control" name="accessControllers" id="accessControllers" >
                    <option></option>
                </select>
                <br>
                <label for="cardNumer">{[ Lang::get('content.cardNumber') ]}:</label>
				<div class="input-group">
                <input name="cardNumer" id="cardNumer" type="text" value="" spellcheck=false maxlength="10" readonly class="form-control">
				<span class="input-group-btn">
                    <button type="button" id="remove" class="btn" data-toggle="modal" data-target="#confirmDeleteCard" >
                        <i class="fa fa-lg fa-times"></i>
                    </button>
				</span>
				</div>
                <input name="prevCardNumer" id="prevCardNumer" type="text" value="" readonly style="border:none;background:rgba(0,0,0,0)">
            </div>
            <div class="modal-footer">
                <input name="trans-input-local" id="trans-input-local" type="hidden" value="{[ Lang::get('content.cardlocal') ]}">
                <input name="idIntegra" id="idIntegra" type="hidden" >
                <input name="userIdx" id="userIdx" type="hidden" >
                <input name="userName" id="userName" type="hidden" >
                <div style="float:right">
                    <button type="button" class="btn btn-default" id="accessControlCancel" >{[ Lang::get('content.cancel') ]}</button>
                    <button type="button" id="accessControlDoRead" class="btn btn-default btn-ok" data-toggle="tooltip" data-placement="top">{[ Lang::get('content.cardRead') ]}</button>
                    <button type="button" id="accessControlOK" class="btn btn-primary btn-ok" data-toggle="tooltip" data-placement="top">{[ Lang::get('content.save') ]}</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="confirmDeleteCard" role="dialog" aria-labelledby="confirmDeleteCardLabel" aria-hidden="true">
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
