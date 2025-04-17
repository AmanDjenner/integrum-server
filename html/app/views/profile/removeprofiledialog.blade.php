<div class="modal" id="confirmDeleteProfile" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                &nbsp;&nbsp;
            </div>
            <div class="modal-body" style="width: 70%; margin: 0 auto;">
				<h3 class="modal-title">{[ Lang::get('content.removePermissionsProfileDialog') ]}</h3>
            </div>
            <div class="modal-footer">
				<form name='profileDestroy' method='POST' action='/admin/profile/destroy'class='profile-destroy'>
				{[ Form::hidden('id',0) ]}
                <button type="button" class="btn btn-default" data-dismiss="modal">{[Lang::get('content.cancel')]}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="confirm">{[Lang::get('content.remove')]}</button>
				</form>
            </div>
        </div>
    </div>
</div>