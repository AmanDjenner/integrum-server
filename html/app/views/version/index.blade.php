@extends('layouts.default', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'titleDetail' => Lang::get('content.status')])
@section('content')
<div class="row">
    <div class="content-header"><div class="top-buffer col-sm-12">
            <h1 class="info-h1">{[ Lang::get('content.status') ]}</h1>
        </div>
    </div>
    <div class="col-sm-12" id="middle">
        <div class="col-sm-12 top-buffer">
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="info-1">
                    <div class="row">
                        <div class="col-sm-3 hidden-xs" style="text-align: right">
                            <label for="status" class="control-label" style='padding-top: 0px;'>{[ Lang::get('content.system-components') ]}</</label>
                        </div>
                        <div class="col-sm-3 visible-xs">
                            <label for="status" class="control-label" style='padding-top: 0px;'>{[ Lang::get('content.system-components') ]}</</label>
                        </div>
                        <div class="col-md-6">
                            <ul class="nav nav-pills">
                                <li role="presentation ">
                                    <button id="diode-web" class="btn mr-15 green outlined" type="button" style="width:54px;height:60px" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{[ $webver['name'] . ' ' . $webver['version'] . $webver['message'] ]}">
                                        <span class="system-status-icon fa-stack">
                                            <i class="fa fa-2x fa-stack-1x fa-server"></i>
                                            <span class="system-status-icon-detail" style="display:block">
                                                <i class="fa fa-stack-1x fa-globe-africa"></i>
                                            </span>
                                        </span>
                                    </button> </li><li role="presentation">
                                    <button id="diode-appserv" class="btn mr-15 yellow" type="button" style="width:54px;height:60px" data-toggle="tooltip" data-placement="bottom" title="" data-package="INTEGRUM AppServer" data-original-title="INTEGRUM AppServer ?">
                                        <span class="system-status-icon fa-stack">
                                            <i class="fa fa-2x fa-stack-1x fa-server"></i>
                                            <span class="system-status-icon-detail" style="display:block">
                                                <i class="fa fa-stack-1x fa-cog"></i>
                                            </span>
                                        </span>
                                </li><li role="presentation">
                                    <button id="diode-serv" class="btn mr-15 yellow" type="button" style="width:54px;height:60px" data-toggle="tooltip" data-placement="bottom" title="" data-package="INTEGRUM Server" data-original-title="INTEGRUM Server ?">
                                        <span class="system-status-icon fa-stack">
                                            <i class="fa fa-2x fa-stack-1x fa-server"></i>
                                            <span class="system-status-icon-detail" style="display:block;font-size:20px">
                                                <i class="fa fa-stack-1x fa-calculator"></i>
                                            </span>
                                        </span>
                                </li><li role="presentation">
                                    <button id="diode-db" class="btn mr-15 yellow" type="button" style="width:54px;height:60px" data-toggle="tooltip" data-placement="bottom" title="" data-package="INTEGRUM DB" data-original-title="INTEGRUM DB ?">
                                        <span class="system-status-icon fa-stack">
                                            <i class="fa fa-2x fa-stack-1x fa-server"></i>
                                            <span class="system-status-icon-detail" style="display:block;font-size:20px">
                                                <i class="fa fa-stack-1x fa-database"></i>
                                            </span>
                                        </span>
                                </li></ul>
                        </div>
                    </div>
                    <div class="row margin-35">
                        <div class="col-sm-3 hidden-xs" style="text-align: right">
                            <label for="licenseOwner" class="control-label" style='padding-top: 0px;'>{[ Lang::get('content.license-owner') ]}</label>
                        </div>
                        <div class="col-sm-3 visible-xs">
                            <label for="licenseOwner" class="control-label" style='padding-top: 0px;'>{[ Lang::get('content.license-owner') ]}</label>
                        </div>
                        <div class="col-sm-6">
                            {[ Form::textarea('licenseOwner',NULL,['size' => '50x4','class'=>'form-control', 'readOnly'=>'readOnly', 'id'=>'licenseOwner']) ]}
                        </div>
                    </div>
					@if($permLicenseManage)
                    <div class="row margin-35">
                        <div class="col-sm-3 hidden-xs" style="text-align: right">
                            <label for="licenserequest" class="control-label" style='padding-top: 0px;'>{[ Lang::get('content.systems') ]}</label>
                        </div>
                        <div class="col-sm-3 visible-xs">
                            <label for="licenserequest" class="control-label" style='padding-top: 0px;'>{[ Lang::get('content.systems') ]}</label>
                        </div>
                        <div class="col-md-6">
                            <button disabled id="licenserequestOk" class="btn btn-success btn-icon" style="opacity:1">
                                {[ Lang::get('content.systems-licensed') ]} <span class="badge">{[$licensescount->licensed]}</span>
                            </button>
                            <button disabled id="licenserequestReady" class="btn btn-warning btn-icon" style="opacity:1">
                                {[ Lang::get('content.systems-no-license') ]} <span class="badge">{[$licensescount->ready]}</span>
                            </button>
                            @if ($licensescount->notready>0)
                            <button disabled id="licenserequestNotReady" class="btn btn-danger btn-icon" style="opacity:1">
                                {[ Lang::get('content.systems-not-supported') ]} <span class="badge">{[$licensescount->notready]}</span>
                            </button>
                            @endif
                            <a id="licenseDetails" class="btn btn-default btn-icon" href='/ethm'>
								{[Lang::get('content.details') ]} <span class="badge badge-default" class=""><i class="fa fa-list"></i></span>
							</a>							
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row margin-10">
                        <div class="col-sm-3 hidden-xs" style="text-align: right">
                            <label for="licenserequest" class="control-label" style='padding-top: 0px;'>{[Lang::get('content.lic-req') ]}</label>
                        </div>
                        <div class="col-sm-3 visible-xs" >
                            <label for="licenserequest" class="control-label" style='padding-top: 0px;'>{[Lang::get('content.lic-req') ]}</label>
                        </div>
                        <div class="col-md-6">
                            <a id="licenserequest" class="btn btn-default btn-icon" href='/status/licenserequest'>{[Lang::get('content.generate-lic-req') ]}</a>
                        </div>
                    </div>

                    <div class="row margin-35">
                        <div class="col-sm-3 hidden-xs" style="text-align: right">
                            <label for="licenserequest" class="control-label" style='padding-top: 0px;'>{[Lang::get('content.lic') ]}</label>
                        </div>
                        <div class="col-sm-3 visible-xs">
                            <label for="licenserequest" class="control-label" style='padding-top: 0px;'>{[Lang::get('content.lic') ]}</label>
                        </div>
                        <div class="col-md-6">
                            {[Form::open(array('route' => 'licenseupload','method'=>'POST', 'files'=>true)) ]}
                            {[Form::file("licfile")]}
                            <p class="errors">{[$errors->first('licfile')]}</p>
                            @if($force>0)
                            {[Form::checkbox('force','1') ]} {[Lang::get('content.forcelicense')]}<br/>
                            @endif
                            {[Form::submit(Lang::get('content.license-upload-btn'), array('class' =>'margin-10 btn btn-default btn-icon'))]}
                            {[Form::close()]}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop
    @section('javascripts')
    <script src="/js/info.e148ef23.js"></script>
    @stop