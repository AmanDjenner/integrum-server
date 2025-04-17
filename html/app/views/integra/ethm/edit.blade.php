@extends('layouts.default', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'titleDetail' => $ethm->getName()])

@section('content')
<div class="row">
    <div class="content-header"><div class="top-buffer width-100">
            <h1 class="user-h1">{[ $ethm->getName() ]}</h1>
        </div>
        <ol class="breadcrumb left">
            <li class="active"><b>{[ $hierarchyName]}</b></li>
        </ol>
    </div>
    <div class="col-sm-12" id="middle">
        <div class="col-sm-12 top-buffer">
            <div role="tabpanel">
                <!-- Nav tabs -->
                <!-- Tab panes -->
                <div class="ethm-content">
                    {[ Form::model($ethm->getData(), ['method' => 'PATCH', 'route' => ['ethm.update', $ethm->getId()], 'files' => true, 'class'=>'form-horizontal' ]) ]}
                        <input type="text" style="display:none">
                        <input type="password" style="display:none">
                        @if (($ethm->getState()->deviceType==0 &&  doubleval($ethm->getState()->version)>=200)
                            ||($ethm->getState()->deviceType==1 &&  doubleval($ethm->getState()->version)>=100))
                        <div class="row">
                            {[ Form::label('macORimei', Lang::get('content.macORimei'),['class'=>'control-label col-md-3']) ]}
                            <div class="col-md-6">
                                {[ Form::text('macORimei',NULL,['class'=>'form-control frm-mr-ln', '']) ]}
                                {[ $errors->first('macORimei') ]}
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            {[ Form::label('address', Lang::get('content.addressip'),['class'=>'control-label col-md-3']) ]}
                            <div class="col-md-6">
                                {[ Form::text('address',NULL,['class'=>'form-control frm-mr-ln', '']) ]}
                                {[ $errors->first('address') ]}
                            </div>
                        </div>
                        <div class="row">
                                {[ Form::label('version', ucfirst(Lang::get('content.version')).Lang::get('content.addressmac'),['class'=>'control-label col-md-3']) ]}
                            <div class="col-md-3">
                                {[ Form::text('version',$ethm->getState()->version/100 ." ". $ethm->getState()->versionDate,['class'=>'form-control frm-mr-ln', 'readonly']) ]}
                            </div>
                            <div class="col-md-3">
                                {[ Form::text('versionMAC',$ethm->getState()->mac,['class'=>'form-control', 'readonly']) ]}
                            </div>
                        </div>
                        <div class="row hidden-xs hidden-sm">
                            <div class="col-md-3 col-md-offset-3">{[ ucfirst(Lang::get('content.guardX')) ]}
                            </div>
                            <div class="col-md-3">{[ ucfirst(Lang::get('content.dloadX')) ]}
                            </div>
                        </div>
                        <div class="row">
							{[ Form::label('guardPort', Lang::get('content.port'),['class'=>'control-label col-md-3']) ]}
                            <div class="col-md-3">
								<div class='control-label visible-xs visible-sm' style='text-align:left;'>{[ ucfirst(Lang::get('content.guardX')) ]}</div>
                                {[ Form::text('guardPort',NULL,['class'=>'form-control frm-mr-ln', 'min'=>'1', 'step'=>'1', '']) ]}
                                {[ $errors->first('guardPort') ]}
                            </div>
                            <div class="col-md-3">
								<div class='control-label visible-xs visible-sm' style='text-align:left;'>{[ ucfirst(Lang::get('content.dloadX')) ]}</div>
                                {[ Form::text('dloadPort',NULL,['class'=>'form-control frm-mr-ln', 'min'=>'1', 'step'=>'1', '']) ]}
                                {[ $errors->first('dloadPort') ]}
                            </div>
                        </div>
                        <div class="row">
							{[ Form::label('guardkey', Lang::get('content.key'),['class'=>'control-label col-md-3']) ]}
                            <div class="col-md-3">
								<div class='control-label visible-xs visible-sm' style='text-align:left;'>{[ ucfirst(Lang::get('content.guardX')) ]}</div>
                                {[ Form::input('password','guardkey',$ethm->getGuardKey(),['class'=>'form-control frm-mr-ln', 'maxlength'=>'12', 'id'=>'guardkey']) ]}
                            </div>
                            <div class="col-md-3">
								<div class='control-label visible-xs visible-sm' style='text-align:left;'>{[ ucfirst(Lang::get('content.dloadX')) ]}</div>
                                <div class="input-group">
                                    {[ Form::input('password','dloadkey',$ethm->getDloadKey(),['class'=>'form-control frm-mr-ln', 'maxlength'=>'12', 'id'=>'dloadkey']) ]}
                                    <span class="input-group-btn">
                                        <a href="#" id="changeToText" data-value='{"id":0,"span":"changeSpan","input":["guardkey","dloadkey"]}' class="btn changeToText" ><span id="changeSpan" class="fa fa-eye"></span></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
							{[ Form::label('name', ucfirst(Lang::get('content.nameEthm')),['class'=>'control-label col-md-3']) ]}
                            <div class="col-md-6">
                                {[ Form::text('name',NULL,['class'=>'form-control frm-mr-ln']) ]}
                            </div>
                        </div>
                        <div class="row">
							{[ Form::label('number', ucfirst(Lang::get('content.evidenceNumber')),['class'=>'control-label col-md-3']) ]}
                            <div class="col-md-6">
                                {[ Form::text('number',NULL,['class'=>'form-control frm-mr-ln']) ]}
                            </div>
                        </div>
                        <div class="row" id='devIdGroup'>
							{[ Form::label('idGroup', Lang::get('content.idGroup').': ',['class'=>'control-label col-md-3']) ]}
                            <div class="col-md-6">
                                <input readonly class="form-control" name="idGroupName" id="idGroupName" />
                                <input type="hidden" name="idGroup" id="idGroup" value="{[ $ethm->getIdGroup() ]}"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 text-right">
				@if(isset($ethm->getData()['idIntegra']))
                                <a id="backButton2" class="btn btn-icon btn-default btn-sm margin-10 mr-15"  href="/control/{[$ethm->getData()['idIntegra'] ]}/edit" title="{[Lang::get('content.panel')]}"><i class="fa fa-lg fa-calculator"></i></a>
				@endif
				@if($permIntegraEdit)
				<button type="submit" title="{[ Lang::get('content.save') ]}" class="btn btn-icon btn-warning  btn-sm margin-10"><i class="fa fa-lg fa-download"></i></button>
                @endif
                            </div>
                        </div>
                </div>
                {[ Form::close() ]}
            </div>

        </div>
    </div>
</div>
@stop
@section('javascripts')
<script src="/js/integraethm-edit.56b70430.js"></script>
@stop
