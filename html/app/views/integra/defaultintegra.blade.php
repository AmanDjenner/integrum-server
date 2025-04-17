@extends('layouts.default', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'titleDetail'=> $titleDetail ])
@section('content')
<?php
$state             = $integra->getIntegraState();
$diodeStatus       = array(1 => "", 2 => "outlined", 3 => "blink");
$diodeStatusOnline = array(0 => "yellow", 1 => "red", 2 => "red outlined", 3 => "green blink");
?>
<div class="row">
    <div class="content-header">
        <div class="top-buffer width-100">
            <h1 class="h1">{[ $integra->getName() ]} </h1>
			<div class="pull-right" style="margin-right:8px;">
                  {[$customButtons or '']}
                  @if($permGuardx)
                  <button type="button" class="btn btn-content-margin guardx" style="display:inline;float:right;margin-right:8px;" data-url="{[ route('control.guardx',["idIntegra"=>$integra->getId()]) ]}" data-toggle="tooltip" data-placement="bottom" title="{[ Lang::get('content.guardx') ]}" >
                    <img class="guardx-logo" src="/img/guardx.svg" alt="GUARDX">
                  </button>
                  @endif
            </div>
            @if($permIntegraManage)
            <!-- Start::Arm / Disarm-->
            @if(1==$state['online'])
            @if(2==$state['action'])
            {[ Form::open(array('route' => 'control.arm', 'method' => 'post','class'=>'ajax')) ]}
            <input name="idIntegra" id="idIntegra" type="hidden" value="{[ $integra->getId() ]}">
            <button type="submit" class="btn btn-content-margin" data-toggle="tooltip" data-placement="bottom" title="{[ Lang::get('content.arm') ]}">
                <i class="fa fa-lock fa-2x"></i>
            </button>
            {[ Form::close() ]}
            @elseif(1==$state['action'])
            {[ Form::open(array('route' => 'control.disarm', 'method' => 'post','class'=>'ajax')) ]}
            <input name="idIntegra" id="idIntegra" type="hidden" value="{[ $integra->getId() ]}">
            <button type="submit" class="btn btn-content-margin" data-toggle="tooltip" data-placement="bottom" title="{[ Lang::get('content.disarm') ]}" ><i class="fa fa-unlock fa-2x"></i></button>
            {[ Form::close() ]}
            @else
            {[ Form::open(array('route' => 'control.arm', 'method' => 'post','class'=>'ajax')) ]}
            <input name="idIntegra" id="idIntegra" type="hidden" value="{[ $integra->getId() ]}">
            <button type="submit" class="btn btn-content-margin" data-toggle="tooltip" data-placement="bottom" title="{[ Lang::get('content.arm') ]}"><i class="fa fa-lock fa-2x"></i></button>
            {[ Form::close() ]}

            {[ Form::open(array('route' => 'control.disarm', 'method' => 'post','class'=>'ajax')) ]}
            <input name="idIntegra" id="idIntegra" type="hidden" value="{[ $integra->getId() ]}">
            <button type="submit" class="btn btn-content-margin" data-toggle="tooltip" data-placement="bottom" title="{[ Lang::get('content.disarm') ]}" ><i class="fa fa-unlock fa-2x"></i></button>
            {[ Form::close() ]}
            @endif
            @if ($state['state'][0]->status==3||$state['state'][0]->status==1)
            {[ Form::open(array('route' => 'control.clearAlarm', 'method' => 'post','class'=>'ajax')) ]}
            <input name="idIntegra" id="idIntegra" type="hidden" value="{[ $integra->getId() ]}">
            <button type="submit" class="btn btn-content-margin fa fa-stack" data-toggle="tooltip" data-placement="bottom" title="{[ Lang::get('content.clearAlarm') ]}" >
                <i class="fa fa-bell fa-2x"></i>
                <span style="">
                    <i class="far fa-stack-1x fa-times-circle" style="color:darkgrey;left:10px;top:12px;font-size:20px;"></i>
                </span>
            </button>
            {[ Form::close() ]}
            @endif
            @if ($state['state'][1]->status==3||$state['state'][1]->status==1)
            {[ Form::open(array('route' => 'control.clearTrouble', 'method' => 'post','class'=>'ajax')) ]}
            <input name="idIntegra" id="idIntegra" type="hidden" value="{[ $integra->getId() ]}">
            <button type="submit" class="btn btn-content-margin fa fa-stack " data-toggle="tooltip" data-placement="bottom" title="{[ Lang::get('content.clearTrouble') ]}" >
                <i class="fa fa-exclamation-triangle fa-2x"></i>
                <span style="">
                    <i class="far fa-stack-1x fa-times-circle" style="color:darkgrey;left:10px;top:12px;font-size:20px;"></i>
                </span>
            </button>
            {[ Form::close() ]}
            @endif
            @endif
            @endif
            <!-- END::Arm / Disarm-->
        </div>
        <ol class="breadcrumb left">
            <li class="active"><b>{[ $hierarchyName]}</b></li>
        </ol>
		<span class="label label-default pull-right row" style="margin-top:0.5em;margin-right:0" onclick="window.location.reload();">{[date(Lang::get('content.dateServerFormatSec'))]} <i class="fa fa-redo"></i></span>
    </div>
    <div class="col-sm-12" id="middle">
        <div class="col-sm-12 top-buffer">
            <div class="col-sm-offset-3 col-sm-6">
                <table class="table table-condensed table-hover tabela-wynik">
                    <thead>
                        <tr>
                            <td><div style="text-align: center;"><i class="fa fa-lg fa-bell"></i></div></td>
                            <td><div style="text-align: center;"><i class="fa fa-lg fa-exclamation-triangle"></i></div></td>
                            <td><div style="text-align: center;"><i class="fa fa-lg fa-eye"></i></div></td>
                            <td><div style="text-align: center;"><i class="fa fa-lg fa-wrench"></i></div></td>
                            <td><div style="text-align: center;"><i class="fa fa-lg fa-globe-africa"></i></div></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a class="diodes" href='/event/#{"panel":{[$integra->getId()]},"source":[0,1]}'><div class="diode red {[ $diodeStatus[$state['state'][0]->status] ]}"></div></a></td>
                            <td><a class="diodes" href='/event/#{"panel":{[$integra->getId()]},"source":[5]}'><div class="diode yellow {[ $diodeStatus[$state['state'][1]->status] ]} "></div></a></td>
                            <td><a class="diodes" href='/event/#{"panel":{[$integra->getId()]},"source":[2]}'><div class="diode green {[ $diodeStatus[$state['state'][2]->status] ]}"></div></a></td>
                            <td><a class="diodes" href='/event/#{"panel":{[$integra->getId()]},"source":[7]}'><div class="diode green2 {[ $diodeStatus[$state['state'][3]->status] ]}"></div></a></td>
                            <td><a class="diodes" href='/event/#{"panel":{[$integra->getId()]},"source":[130]}'><div class="diode {[ $diodeStatusOnline[$state['state'][6]->status] ]}"></div></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-3"><div style="display:{[(($statusDesc!=null)&&($state['state'][6]->status!=2)) ?'block !important':'none']};" class="popover right static-popover" id="testPopover">
    <div class="arrow"></div>
    <div class="popover-content" style="background:white;">
        <p>{[$statusDesc]}</p>
    </div>
</div></div>
        </div>
        <div class="col-sm-12 top-buffer">
            <div class="tabs" role="tabpanel">
                <!-- Nav tabs -->
                <ul role="tablist">
                    @if($permIntegraEdit)
                    <li role="presentation" class="{[ Request::is( 'control*/edit') ? 'active' : '' ]}">
                        <a href="/control/{[ $integra->getId() ]}/edit/">{[ Lang::get('content.general') ]}</a>
                    </li>
                    @endif
                    @if($permUserIntegraSelect)
                    <li role="presentation" class="{[ Request::is( 'control/integrauser/*') ? 'active' : '' ]}">
                        <a href="/control/integrauser/{[ $integra->getId() ]}">{[ Lang::get('content.users') ]}</a>
                    </li>
                    @endif
                    <li role="presentation" class="{[ Request::is( 'control/structure/*') ? 'active' : '' ]}">
                        <a href="/control/structure/{[ $integra->getId() ]}">{[ Lang::get('content.structure') ]}</a>
                    </li>
                    <li role="presentation" class="{[ Request::is( 'control/outputs/*') ? 'active' : '' ]}">
                        <a href="/control/outputs/{[ $integra->getId() ]}">{[ Lang::get('content.outputs') ]}</a>
                    </li>
                    <li role="presentation" class="{[ Request::is( 'control/locks/*') ? 'active' : '' ]}">
                        <a href="/control/locks/{[ $integra->getId() ]}">{[ Lang::get('content.locks') ]}</a>
                    </li>
                    @if(Config::get('parameters.controlWithEvents', false) && $permIntegraEvents)
                    <li role="presentation" class="{[ Request::is( 'control/*/events') ? 'active' : '' ]}">
                        <a href="/control/{[ $integra->getId() ]}/events">{[ Lang::get('content.events') ]}</a>
                    </li>
					@endif
                    @if(Config::get('parameters_structraport.controlStructureReport', false) && $permIntegraReport)
                    <li role = "presentation" class = "{[ Request::is( 'control/controlStructureReport/*') ? 'active' : '' ]}">
                        <a href = "/control/controlStructureReport/{[ $integra->getId() ]}">
                            {[Lang::get('content.controlStructureReport')]}
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            @yield('contentintegra')
        </div>
    </div>
</div>
@stop
