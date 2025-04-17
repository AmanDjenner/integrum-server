@extends('layouts.list',['customButtons' =>
	'<span id="event-export" style="display:inline;padding: 0px 12px;float:right;margin-right:8px;" class="btn btn-create-blank btn-create" data-toggle="tooltip" data-placement="bottom" title="'. Lang::get('content.list-getcsv') .'" ><i style="width: 25px;" class="fa fa-lg fa-upload"></i></span>
'])

@section('listcontent')
<input type="hidden" name="trans-date-picker-FormatSec" id="trans-date-picker-FormatSec" value="{[Lang::get('content.datePickerFormatSec')]}"></input>

<div class="row">

    <div class="col-sm-12" id="middle">

        <div class="row">
            <div class="col-sm-12 top-buffer">
                {[ Form::open( array(
							'route' => 'control.filter',
							'method' => 'post',
							'id' => 'form-filter-setting'
							) ) ]}
                <input type="hidden" name="hierarchytree" id="hierarchytree" value="8"/>
                <input type="hidden" name="ptoken" id="ptoken" value="{[ csrf_token() ]}" >
                <table class="table table-condensed table-hover tabela-wynik">
                    <thead class="filter">
                        <tr>
							<th></th>
                            <th></th>
                            <th>
                                {[ Form::text('integra','',['class'=>'form-control', 'placeholder'=> Lang::get('content.list-objectname'), 'id'=>"integra"]) ]}
                            </th>
                            <th>
                                {[ Form::text('ip','',['class'=>'form-control', 'placeholder'=>Lang::get('content.list-ipaddr'), 'id'=>"ip"]) ]}
                            </th>
                            <th style="max-width:45px;text-align: center;">
                                <a href="#1" data-toggle="tooltip" class="btn" data-placement="top" title="{[ Lang::get('content.alarm') ]}">
                                    <i class="fa fa-lg fa-bell"></i>
                                </a>
                            </th>
                            <th style="max-width:45px;text-align: center;">
                                <a href="#2" data-toggle="tooltip" class="btn" data-placement="top" title="{[ Lang::get('content.trouble') ]}">
                                    <i class="fa fa-lg fa-exclamation-triangle"></i>
                                </a>
                            </th>
                            <th style="max-width:45px;text-align: center;">
                                <a href="#3" data-toggle="tooltip" class="btn" data-placement="top" title="{[ Lang::get('content.armed') ]}">
                                    <i class="fa fa-lg fa-eye"></i>
                                </a>
                            </th>
                            <th style="max-width:45px;text-align: center;">
                                <a href="#4" data-toggle="tooltip" class="btn" data-placement="top" title="{[ Lang::get('content.service') ]}">
                                    <i class="fa fa-lg fa-wrench"></i>
                                </a>
                            </th>
                            <th style="max-width:45px;text-align: center;">
                                <a href="#5" data-toggle="tooltip" class="btn" data-placement="top" title="{[ Lang::get('content.noConnection') ]}">
                                    <i class="fa fa-lg fa-globe-africa"></i>
                                </a>
                            </th>
                            <th>
                                <input type="hidden" name="statusCode" id="statusCode" value="0"/>
                            </th>
                            <th style="min-width:146px;" class="actionColumn">{[ Lang::get('content.list-action') ]}
                                <button class="btn btn-filter" id='btnFilter' disabled='disabled' type="submit">
                                    <i class="fa fa-filter"></i>
                                </button>
								<button type="button" class="btn btn-filter form-control" id="btn-filter-clear">
									<span class="fa-stack filterButton">
										<i class="fa fa-stack-1x fa-filter filterButtonIco"></i>
										<span>
											<i class="fa fa-stack-1x fa-ban filterButtonIco2"></i>
										</span>
									</span>
								</button>
                            </th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody id='idSpinner'>
                        <tr >
                            <td colspan="12" style="text-align: center;">
                                <img src="/css/select2-spinner.gif" />
                            </td>
                        </tr>
                    </tbody>
                    <tbody id='integraTable'>
                        <tr>
                        </tr>
                    </tbody>
                </table>
                {[ Form::close() ]}
            </div>
        </div>
        <div class="row">
            {[ Form::open( array(
            'route' => 'control.filtercsv',
            'method' => 'post',
            'id' =>'form-csv'
            ) ) ]}
            <input type="hidden" name="data" id="integra-list-getcsv" data-value="" >
            {[ Form::close() ]}
        </div>
    </div>
</div>
<div class="row"><br /><br /></div>
@stop
@section('modalDialogs')
<div class="modal" id="controlDestroy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="width: 70%; margin: 0 auto;">
                <h3>{[ Lang::get('content.removePanel') ]} <b id="nameIntegra"> </b>?</h3>
            </div>
            <div class="modal-footer">
                {[ Form::open(array('id'=>'form-controlDestroy','route' => 'control.destroy', 'method' => 'DELETE','class'=>'ajax')) ]}
                <input name="idIntegra" id="idIntegra" type="hidden" value="0">
                <button type="button" class="btn btn-default" data-dismiss="modal">{[ Lang::get('content.cancel') ]}</button>
                <button type="submit" class="btn btn-danger btn-ok" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.remove') ]}" style="border:none;">{[ Lang::get('content.remove') ]}</button>
                {[ Form::close() ]}
            </div>
        </div>
    </div>
</div>
<div class="modal" id="controlArm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="width: 70%; margin: 0 auto;">
                <h3>{[ Lang::get('content.armPanel') ]} <b id="nameIntegra"> </b>?</h3>
            </div>
            <div class="modal-footer">
                {[ Form::open(array('id'=>'form-controlArm','route' => 'control.arm', 'method' => 'post','class'=>'ajax')) ]}
                <input name="idIntegra" id="idIntegra" type="hidden" value="0">
                <button type="button" class="btn btn-default" data-dismiss="modal">{[ Lang::get('content.cancel') ]}</button>
                <button type="submit" class="btn btn-danger btn-ok" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.arm') ]}" style="border:none;">{[ Lang::get('content.arm') ]}</button>
                {[ Form::close() ]}
            </div>
        </div>
    </div>
</div>
<div class="modal" id="controlDisarm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="width: 70%; margin: 0 auto;">
                <h3>{[ Lang::get('content.disarmPanel') ]} <b id="nameIntegra"> </b>?</h3>
            </div>
            <div class="modal-footer">
                {[ Form::open(array('id'=>'form-controlDisarm','route' => 'control.disarm', 'method' => 'post','class'=>'ajax')) ]}
                <input name="idIntegra" id="idIntegra" type="hidden" value="0">
                <button type="button" class="btn btn-default" data-dismiss="modal">{[ Lang::get('content.cancel') ]}</button>
                <button type="submit" class="btn btn-danger btn-ok" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.disarm') ]}" style="border:none;">{[ Lang::get('content.disarm') ]}</button>
                {[ Form::close() ]}
            </div>
        </div>
    </div>
</div>
@stop
@section('listjavascripts')
<script src="/js/integra-filter.7a8da0b2.js"></script>
@stop