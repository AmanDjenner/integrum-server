

@extends('integra.defaultintegra', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'permIntegraManage'=>$permIntegraManage, 'statusDesc' => $integra->getStatusDesc(), 'titleDetail'=>  Lang::get('content.panel') .' '. $integra->getName() .' - '. Lang::get('content.outputs') ])

@section('contentintegra')

<div class="row">
    <!-- Tab panes -->
    <div class="container">
        <div class="well" style="min-width:520px;">
            <div>
                <div id="stickypos" style="margin-left: 0px; height: 65px; display: block; border-radius: 2px; left: 98.7px; width: 640.4px; top: 66px;">
                    <div id="div-box-action" class="sticky" style="margin-left:40px;height:65px;display:inline-block;background-color:buttonface;border-radius:2px;">
                        <div class="col-xs-2 col-xs-offset-5">
                            <div id="div-output">
                                @if($permIntegraManage)
                                {[ Form::open(array('route' => 'control.action', 'method' => 'post', 'class'=>'ajax output')) ]}
                                <input name="idIntegra" id="idIntegra" type="hidden" value="{[ $integra->getId() ]}">
                                <p id="output-p"></p>
                                {[Form::hidden('action') ]}
                                <div class="btn-group">
                                    <button class="btn btn-group-icon disabled notchecked" disabled><img src="/img/img-outputs.svg" alt="outputs" height="23" width="24" ></button>
                                    <button type="submit" name="action" value="switch" class="btn btn-primary disabled notchecked output" title="{[ Lang::get('content.outputswitch') ]}" disabled><i class="fa fa-2x fa-play-circle" style="font-size:21px;color:black;"></i></button>
                                </div>
                                {[ Form::close() ]}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                    @foreach ($integraOutputs as $grp)
                <ul style="list-style-type: none;">
                    <li>
                        <div class="btn btn-default structure-control" data-name='outputgrp' data-value='{[ $grp->id ]}' style="text-align: left;line-height: 2em;">
                            <span>{[ $grp->text ]} </span>
                        </div>
                    </li>
                    @foreach ($grp->outputList as $output)
                            <ul  class="structure" style="list-style-type: none;">
                        <li>
                            <div class="btn btn-default structure-control" data-name='output' data-value='{[ $output->id ]}' style="text-align: left;line-height: 2em;">
                                <div class="struct-item-icon struct-output-icon"> </div>
                                <i class='fa-2x far {[($output->hasActions) ? "fa-square"  : ""; ]}' id="output-i-{[ $output->id ]}">{[($output->hasActions) ? ""  : "&nbsp;&nbsp;&nbsp;" ]}</i>
                                <span>{[ $output->text ]}</span>
                                <span class='output-state output-state-active {[($output->active) ? ""  : "hidden"; ]} ' title="{[ Lang::get('content.outputActive') ]}"  ></span>
                            </div>
                        </li>
                    </ul>
                    @endforeach
                </ul>
                    @endforeach
            </div>
        </div>

    </div>

    @stop
    @section('javascripts')
    <script src="/js/integra-outputs.33e97517.js"></script>
    @stop
