@extends('integra.defaultintegra', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'permIntegraManage'=>$permIntegraManage, 'statusDesc' => $integra->getStatusDesc(), 'titleDetail'=>  Lang::get('content.panel') .' '. $integra->getName() .' - '. Lang::get('content.general')  ])

@section('contentintegra')
<!-- Tab panes -->
@if ($permIntegraEdit)
<div class="tab-content">
    {[ Form::model($integra->getDataForm(), ['method' => 'PATCH', 'route' => ['control.update', $integra->getId()], 'files' => true, 'class'=>'form-horizontal' ]) ]}
    <input type="text" style="display:none">
    <input type="password" style="display:none">
    <div class="form-group"><br />
        {[ Form::label('online',Lang::get('content.integra-online'),['class'=>'control-label col-md-3'])]}
        <div class="col-md-1">
            {[ Form::checkbox('active', 1, null, ['name'=>'active', 'data-toggle'=>'toggle', 'data-on'=>'<i class="fa fa-check"></i>', 'data-off'=>'<i class="fa fa-ban"></i>']) ]}
        </div>
            {[ Form::label('version',ucfirst(Lang::get('content.version')),['class'=>'control-label col-md-1'])]}
        <div class="col-md-4">
            {[ Form::text('version', $integra->getType()." ".$integra->getVersion(),['class'=>'form-control frm-mr-ln', 'readonly'=>'true', 'id'=>'integraVersion']) ]}
        </div>
    </div>
    <div class="form-group"><br />
        {[ Form::label('name', Lang::get('content.integra-name'),['class'=>'control-label col-md-3']) ]}
        <div class="col-md-6">
            {[ Form::text('name',NULL,['class'=>'form-control frm-mr-ln']) ]}
        </div>
        {[ $errors->first('name') ]}
    </div>

    <div class="form-group">
        {[ Form::label('ethm', Lang::get('content.integra-ethm'),['class'=>'control-label col-md-3']) ]}
        <div class="col-md-6">
            <div class="input-group">
                @if (Config::get('parameters.EthmNewServer', false))
                {[ Form::select('ethm', $ethm,NULL,['class'=>'form-control frm-mr-ln', 'id'=>'idEthm']) ]}
                @else
                {[ Form::text('ethmTxt', $ethm,['class'=>'form-control frm-mr-ln', 'disabled'=>'true', 'id'=>'idEthmTxt']) ]}
                {[ Form::hidden('ethm',$integra->getIntegraEthmId(), array('id'=>'idEthm')) ]}
                @endif
                <span class="input-group-btn">
                    <a href=
                       @if($integra->getIntegraEthmId())
                        "/ethm/{[ $integra->getIntegraEthmId() ]}/edit"
                        @else
                        "#"
                        @endif
                        class="btn"><i class="fa fa-lg fa-edit"></i></a>
                </span>
            </div>
            {[ $errors->first('ethm') ]}
        </div>
    </div>

    <div class="form-group">
		{[ Form::label('serviceCode', Lang::get('content.integra-serviceCode'),['class'=>'control-label col-md-3']) ]}
        <div class="col-md-6">
            <div class="input-group">
                {[ Form::input('password', 'serviceCode', $integra->getServiceCode(), ['class'=>'form-control', 'maxlength'=>'8', 'id'=>'serviceCode']) ]}
                <span class="input-group-btn">
                    <a href="#" id="changeToText" data-linked="1" data-value='{"id":0,"span":"changeSpan","input":["intergrid","guardid","dloadid","serviceCode"]}' class="btn changeToText" ><span id="changeSpan" class="changeToText-icon fa fa-eye"></span></a>
                </span>
            </div>
            {[ $errors->first('serviceCode') ]}
        </div>
    </div>

    <div class="form-group hidden-xs hidden-sm">
        <div class="col-md-3">

        </div>
        <div class="col-md-2">
            {[ Lang::get('content.integra') ]}
        </div>
        <div class="col-md-2">
            {[ ucfirst(Lang::get('content.dloadX')) ]}
        </div>
        <div class="col-md-2">
            {[ ucfirst(Lang::get('content.guardX')) ]}
        </div>
    </div>
    <div class="form-group">
		{[ Form::label('Identyfikator', Lang::get('content.integra-id'),['class'=>'control-label col-md-3']) ]}
        <div class="col-md-2">
			<div class='control-label visible-xs visible-sm' style='text-align:left;'>{[ ucfirst(Lang::get('content.integra')) ]}</div>
            {[ Form::input('password', 'intergrid', $integra->getInterGrid(), ['class'=>'form-control', 'maxlength'=>'10', 'id'=>'intergrid']) ]}
            {[ $errors->first('intergrid') ]}
        </div>
        <div class="col-md-2">
			<div class='control-label visible-xs visible-sm' style='text-align:left;'>{[ ucfirst(Lang::get('content.dloadX')) ]}</div>
            {[ Form::input('password', 'dloadid', $integra->getDloadId(), ['class'=>'form-control', 'maxlength'=>'10', 'id'=>'dloadid']) ]}
            {[ $errors->first('dloadid') ]}
        </div>
        <div class="col-md-2">
            <div class="input-group">
				<div class='control-label visible-xs visible-sm' style='text-align:left;'>{[ ucfirst(Lang::get('content.guardX')) ]}</div>
                {[ Form::input('password', 'guardid', $integra->getGuardId(), ['class'=>'form-control frm-mr-ln', 'maxlength'=>'10', 'id'=>'guardid']) ]}
                {[ $errors->first('guardid') ]}
                <span class="input-group-btn">
                    <a href="#" id="changeToText" data-linked="1" data-value='{"id":0,"span":"changeSpanID","input":["intergrid","guardid","dloadid","serviceCode"]}' class="btn changeToText" ><span id="changeSpanID" class="changeToText-icon fa fa-eye"></span></a>
                </span>
            </div>
        </div>
    </div>

    <div class="form-group">
		{[ Form::label('Identyfikator', Lang::get('content.object-region'),['class'=>'control-label col-md-3']) ]}
        <div class="col-md-6">
            <div class="input-group">
                <input readonly class="form-control" id="message-tree" value="{[ $hierarchyName]}"/>
                <input type="hidden" name="idGroup" id="hierarchyId" value="{[ $integra->getIdGroup() ]}"/>
                <span class="input-group-btn">
                    <a href="#" class="btn" id="locationOpen"><span class="fa fa-lg fa-edit"></span></a>
                </span>
            </div>
            {[ $errors->first('idGroup') ]}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-3 col-md-6 text-right">
            <button type="submit" title="{[ Lang::get('content.integra-save') ]}" class="btn btn-icon btn-warning" ><i class="fa fa-lg fa-download"></i></button>
        </div>
    </div>
    {[ Form::close() ]}
</div>
@stop
@endif
@section('javascripts')
<script src="/js/integra-edit.8afaf470.js"></script>
@stop