

@extends('integra.defaultintegra', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'permIntegraManage'=>$permIntegraManage, 'statusDesc' => $integra->getStatusDesc(), 'titleDetail'=>  Lang::get('content.panel') .' '. $integra->getName() .' - '. Lang::get('content.locks') ])

@section('contentintegra')

<div class="row">
    <!-- Tab panes -->
    <div class="container">
        <div class="well" style="min-width:520px;">
            <div>
                <div id="stickypos" style="margin-left: 0px; height: 65px; display: block; border-radius: 2px; left: 98.7px; width: 640.4px; top: 66px;">
                    <div id="div-box-action" class="sticky" style="margin-left:40px;height:65px;display:inline-block;background-color:buttonface;border-radius:2px;">
                        <div class="col-xs-2 col-xs-offset-5">
                            <div id="div-lock">
                                @if($permIntegraManage)
                                {[ Form::open(array('route' => 'control.action', 'method' => 'post', 'class'=>'ajax lock')) ]}
                                <input name="idIntegra" id="idIntegra" type="hidden" value="{[ $integra->getId() ]}">
                                <p id="lock-p"></p>
                                {[Form::hidden('action') ]}
                                <div class="btn-group">
                                    <button class="btn btn-group-icon disabled notchecked" disabled><i class="fa fa-door-open" style="font-size:21px;color:black;" ></i></button>
                                    <button type="submit" name="action" value="dooropen" class="btn btn-primary disabled notchecked lock" title="{[ Lang::get('content.dooropen') ]}" disabled><i class="fa fa-2x fa-play-circle" style="font-size:21px;color:black;"></i></button>
                                </div>
                                {[ Form::close() ]}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($integraLocks as $lock)
                <ul  class="structure" style="list-style-type: none;">
                    <li>
                        <div class="btn btn-default structure-control" data-name='lock' data-value='{[ $lock->id ]}' style="text-align: left;line-height: 2em;">
                            <div class="struct-item-icon "><i class="fa fa-door-open"></i> </div>
                            <i class='far fa-2x fa-square' id="lock-i-{[ $lock->id ]}"></i>
                            <span>{[ $lock->text ]}</span>
                        </div>
                    </li>
                </ul>
                @endforeach
            </div>
        </div>

    </div>

    @stop
    @section('javascripts')
    <script src="/js/integra-locks.36c0cc0d.js"></script>
    @stop
