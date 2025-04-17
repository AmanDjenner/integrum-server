@extends('layouts.default',['titleDetail' => Lang::get('content.event-settings') ])
@section('content')
<div class="row">
<input name="rodo-newname" id="rodo-newname" type="hidden" value="{[  Lang::get('content.event-settings-rodo-newname') ]}">
<input name="rodo-newname-qry" id="rodo-newname-qry" type="hidden" value="{[  Lang::get('messages.rodoNewname-message') ]}">
<input name="rodo-delete-qry" id="rodo-delete-qry" type="hidden" value="{[  Lang::get('messages.rodoDelete-message') ]}">
<input name="trans-save-error" id="trans-save-error" type="hidden" value="{[  Lang::get('messages.ErrorDatabase-message') ]}">
<input name="trans-save-ok" id="trans-save-ok" type="hidden" value="{[  Lang::get('messages.updateEthm-message') ]}">
    
    <div class="col-sm-12 top-buffer content-header"><div class="top-buffer width-100" style="margin-left: 32px;">
            <h1 class="user-h1">{[ Lang::get('content.event-settings') ]} </h1>
        </div>
    </div>
    <div class="col-sm-12" id="middle">
        <div class="col-sm-12 top-buffer">
            <div class="tabs" role="tabpanel">
                <!-- Nav tabs -->
                <ul role="tablist">
                @if ($permEventArchive)
                    <li role="presentation" class="active"><a href="#ev-1" aria-controls="ev-1" role="tab" data-toggle="tab">{[ Lang::get('content.event-settings-archive') ]}</a></li>
                    <li role="presentation" ><a href="#ev-2" aria-controls="ev-2" role="tab" data-toggle="tab">{[ Lang::get('content.event-settings-rodo') ]}</a></li>
                @endif
                </ul>
            </div>
            <!-- Tab panes -->
            <div class="tab-content">
                <div id="ev-1" class="tab-pane fade in active">
                    <form id="form-archive" method="POST" action="{[ route('settings.update', 'archive_days_old')]}" class="form-horizontal">
                    <input name="_token" id="_token-1" type="hidden" value="{[ csrf_token() ]}">
                    <div class="form-group">
                        <br/>
                        <label for="value_" class="col-md-2 control-label">{[Lang::get('content.event-archive-days-old')]}:</label>
                        <div class="col-md-1">
                            <input name="value_" value="{[$days]}" class="form-control frm-mr-ln" id="value_"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 text-right">
                                <a href="#" class="btn btn-default btn-icon pull-left" data-toggle="modal" id="btnArchive" data-target="#controlArchive" title="{[ Lang::get('content.event-settings-do-archive') ]}"><i class="fa fa-lg fa-archive"></i></a>
                                <button type="submit" title="{[ Lang::get('content.save') ]}" class="btn btn-icon btn-warning" ><i class="fa fa-lg fa-download"></i></button>
                        </div>
                    </div>
                    </form>
                </div>
                <div id="ev-2" class="tab-pane fade">
                    <form id="form-rodo" method="POST" action="{[ route('settings.gdpr')]}">
                    <input name="_token" id="_token-2" type="hidden" value="{[ csrf_token() ]}">
                    <div class="form-group row">
                        <br/>
                        <label for="controlList" class="col-md-2 control-label">{[Lang::get('content.panel')]}</label>
                        <div class="col-md-3">
                            <select name="controlList" class="form-control" id="controlList" style="width:100%"></select>
                        </div>
                    </div>
                    <div class="form-group row">                    
                        <label for="eventUsers" class="col-md-2 control-label">{[Lang::get('content.user')]}</label>
                        <div class="col-md-3">
                        <select class="form-control" name="eventUsers" id="eventUsers" style="width:100%">
                            @foreach($eventUsers as $user)
                            <option value="{[$user->id]}">{[$user->name]}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 form-check-label" for="renameDelete2">
                        {[Lang::get('content.remove')]}
                        </label>
                        <div class="col-md-3">
                        <input class="form-check-input" type="radio" name="renameDelete" id="renameDelete2" value="delete" checked>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 form-check-label" for="renameDelete1">
                            {[Lang::get('content.event-settings-rodo-rename')]}
                        </label>
                        <div class="col-md-3">
                           <input class="form-check-input" type="radio" name="renameDelete" id="renameDelete1" value="rename">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 form-check-label" for="renameDelete1">
                            {[Lang::get('content.event-settings-rodo-newname')]}
                        </label>
                        <div class="col-md-3">
						   <div class="input-group">
                        <input name="new-name" value="" class="form-control frm-mr-ln" id="newName" disabled/>
						   <span class="input-group-btn"><button title="{[ Lang::get('content.generate') ]}" class="btn btn-default" type="button" id="rand"><i class="fa fa-random"></i></button></span>
						   </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-2 text-right">
                            <button type="button" data-toggle="modal" id="btnEventForgetRodo" data-target="#confirm-delete" title="{[ Lang::get('content.save') ]}" class="btn btn-icon btn-primary pull-right" disabled>
                            <i class="fa fa-lg fa-download"></i>
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
</div>	
@stop
@section('modalDialogs')
<div class="modal" id="controlArchive" tabindex="-1" role="dialog" aria-labelledby="controlArchive" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="width: 70%; margin: 0 auto;">
                <h3>{[ Lang::get('content.event-settings-archive') ]}?</h3>
            </div>
            <div class="modal-footer">
                {[ Form::open(array('route' => 'event.doarchive', 'method' => 'post', 'id' => 'form-doarchive')) ]}
                <button type="button" class="btn btn-default" data-dismiss="modal">{[ Lang::get('content.cancel') ]}</button>
                <button class="btn btn-primary btn-ok">{[ Lang::get('content.event-settings-do-archive') ]}</button>
                {[ Form::close() ]}
            </div>
        </div>
    </div>
</div>
<div class="modal" id="confirm-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <b><h3 id="deletUser"> </h3></b>
            </div>
            <div class="modal-body" style="width: 70%; margin: 0 auto;">
                <h4 id="deleteMessage"></h4>
                <h4 id="newMessage"></h4><b><h4 id="newUser"> </h4></b>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{[ Lang::get('content.cancel') ]}</button>
                <a class="btn btn-danger btn-ok">{[ Lang::get('content.OK') ]}</a>
            </div>
        </div>
    </div>
</div>
@stop
@section('javascripts')
<script src="/js/event-manage.d24df6f5.js"></script>
@stop