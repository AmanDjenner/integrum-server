@extends('layouts.list', ['sideRegionVars'=>$sideRegionVars])

@section('listcontent')
<input type="hidden" name="trans-date-picker-FormatSec" id="trans-date-picker-FormatSec" value="{[Lang::get('content.datePickerFormatSec')]}"></input>
<div class="row">
    <div class="col-md-12" id="middle">
        {[ Form::open( array(
        'route' => 'users.filter',
        'method' => 'post',
        'id' => 'form-filter-setting'
        ) ) ]}
        <input type="hidden" name="hierarchyId" id="hierarchyId" value="hierarchyId"/>
        <input type="hidden" name="status" id="status" value=""/>
        <input type="hidden" value="{[Lang::get('content.select')]}" id="translate-select">
        <input type="hidden" value="{[Lang::get('content.list-zone')]}" id="translate-list-zone">
        <input type="hidden" value="{[Lang::get('content.partition')]}" id="translate-partition">
        

        <div class="row">
            <div class="col-md-12 top-buffer">
                <table class="table table-condensed table-hover tabela-wynik">
                    <thead class="filter">
                        <tr class="tabela-head">
                            <th style="max-width: 200px;">{[ Form::text('surname','',['class'=>'form-control', 'placeholder'=>Lang::get('content.list-fullname'), 'id'=>"surname"]) ]}</th>
                            <th style="max-width: 200px;">{[ Form::text('email','',['class'=>'form-control', 'placeholder'=>Lang::get('content.list-email'), 'id'=>"email"]) ]}</th>
                            <th style="max-width: 200px;">{[ Form::text('phone','',['class'=>'form-control', 'placeholder'=>Lang::get('content.list-phone'), 'id'=>"phone"]) ]}</th>
                            <th id="state-app" style="max-width:45px;text-align:center;"><span class="btn" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.list-state-app') ]}" ><i class="fa fa-lg fa-sign-in-alt"></i></span></th>
                            <th id="state-integra" style="max-width:45px;text-align:center;"><span class="btn" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.list-state-integra') ]}" ><i class="fa fa-lg fa-calculator"></i></span></th>
                            <th class="actionColumn" style="min-width:166px;max-width:166px;text-align:center;"><span class="hidden-xs hidden-sm hidden-md">{[Lang::get('content.list-action')]}</span><div class="clearfix visible-xs visible-md"></div>
                                <div class="btn-group" style="margin-left: 8px;">
                                    <button class="btn btn-filter form-control ml-10 no-margin-xs" id='btnFilter' type="submit"><i class="fa fa-filter"></i></button>
                                    <button class="btn btn-collapse dropdown-toggle" id='btnCollapse' type="button" data-toggle="collapse" data-target="#usersFilter" aria-haspopup="true" aria-expanded="false"><i class="fa fa-lg fa-caret-right"></i></button>
                                </div>
								<button type="button" class="btn btn-filter form-control" id="btn-filter-clear">
									<span class="fa-stack filterButton">
										<i class="fa fa-stack-1x fa-filter filterButtonIco"></i>
										<span>
											<i class="fa fa-stack-1x fa-ban filterButtonIco2"></i>
										</span>
									</span>
								</button>
								<div class="visible-xs visible-sm visible-md">{[Lang::get('content.list-action')]}</div>
                            </th>
                            <th id="state" style="max-width:65px;">
                                <input id="stateToggle" type="checkbox" data-toggle2="tooltip" data-onstyle="danger" data-placement="top" title="{[ Lang::get('content.list-state') ]}" data-on="<i class='fa fa-ban'></i>&nbsp;&nbsp;" data-off="&nbsp;&nbsp;<i class='fa fa-check'></i>" data-toggle="toggle" data-size="mini">
                            </th>
                        </tr>
                        <tr id="usersFilter" class="collapse"><th colspan="8">
                                <div class="row" style="margin-bottom:12px;">
                                    <div class="col-md-4">
                                        {[ Form::select('controlList',[],null,[
                                        'class'=>'form-control', 'multiple' => 'multiple', 'id'=>'controlList','data-placeholder'=>Lang::get('content.list-panel'),'style'=>'width:100%'
                                        ]); ]}
                                    </div>
                                    <div class="col-md-4 top-buffer">
                                        <select class="form-control" name="integraPartition" id="integraPartition" disabled>
                                            <option value="">{[Lang::get('content.list-partition')]}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 top-buffer">
                                        <select class="form-control" name="integraZone" id="integraZone" disabled>
                                            <option value=''>{[Lang::get('content.list-zone')]}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row top-buffer">
                                    <div class="col-md-4 top-buffer">
                                        <select class="form-control" name="access" id="access">
											<option value="">{[ Lang::get('content.permissions') ]}</option>
                                            @foreach ($access as $acc)
<option value="{[ $acc->id ]}">{[ $acc->name ]}</option>
											@endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-left">
                                    </div>
                                </div>
                            </th></tr>
                    </thead>
                    <tbody id='userTable'>
                    </tbody>
                </table>
            </div>
        </div>
        {[ Form::close() ]}
        <!--
                <div class="row">
                    <button type="button" class="btn btn-default pull-right mr-15"><i class="fa fa-file-alt"></i>&nbsp; {[Lang::get('content.list-getcsv')]}</button>
                </div>
        -->
    </div>
</div>
<div class="row"></div>
@stop
@section('modalDialogs')
<div class="modal" id="confirm-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                &nbsp;&nbsp;
            </div>
            <div class="modal-body" style="width: 70%; margin: 0 auto;">
                <h3>{[ Lang::get('content.removeConfirm') ]} <b id="deletUser"> </b>?</h3>
            </div>
            <div class="modal-footer">
            <input type="hidden" id="remove-from-panel-lnk"></input>
                <label class="pull-left" id="remove-from-panel" style="valign:middle;display:none"><input type="checkbox" value="" id="remove-from-panel-chk"> {[ Lang::get('content.removeUserFromPanelDialog') ]}</label>
                <button type="button" class="btn btn-default" data-dismiss="modal">{[ Lang::get('content.cancel') ]}</button>
                <a class="btn btn-danger btn-ok">{[ Lang::get('content.remove') ]}</a>
            </div>
        </div>
    </div>
</div>

@stop
@section('listjavascripts')
<script src="/js/user-filter.c7226e28.js"></script>
@stop