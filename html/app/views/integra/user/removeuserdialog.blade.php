<div class="modal" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                &nbsp;&nbsp;
            </div>
            <div class="modal-body" style="width: 70%; margin: 0 auto;">
				<h3 class="modal-title">Delete Parmanently</h3>
            </div>
            <div class="modal-footer">
				<?=
				Form::open(array(
					'name'   => 'integraUserDestroy',
					'method' => 'POST',
					'action' => 'IntegraUserController@destroy',
					'class'  => 'user-destroy'
				));
				?>
                {[ Form::hidden('idIntegra',$idIntegra) ]}
				{[ Form::hidden('id',0) ]}
                <button type="button" class="btn btn-default" data-dismiss="modal">{[Lang::get('content.cancel')]}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="confirm">{[Lang::get('content.remove')]}</button>
				{[ Form::close() ]}
            </div>
        </div>
    </div>
</div>