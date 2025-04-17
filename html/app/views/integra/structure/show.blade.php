@extends('integra.defaultintegra', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'permIntegraManage'=>$permIntegraManage, 'statusDesc' => $integra->getStatusDesc(), 'titleDetail'=>  Lang::get('content.panel') .' '. $integra->getName() .' - '. Lang::get('content.structure') ])

@section('contentintegra')

<div class="row">
    <!-- Tab panes -->
    <div class="container">
        <div class="well" style="min-width:520px;">
            <div >
                <div id="stickypos" style="margin-left: 0px; height: 65px; display: block; border-radius: 2px; left: 98.7px; width: 640.4px; top: 66px;">
                    <div id="div-box-action" class="sticky" style="margin-left:40px;height:65px;display:inline-block;background-color:buttonface;border-radius:2px;">
                        <div class="col-xs-6">
                            <div id="div-partition" style="float:right">
                                @if($permIntegraManage)
                                {[ Form::open(array('route' => 'control.action', 'method' => 'post', 'class'=>'ajax partition')) ]}
                                <input name="idIntegra" id="idIntegra" type="hidden" value="{[ $integra->getId() ]}">
                                <p id="partition-p"></p>
                                {[Form::hidden('action') ]}
                                <div class="btn-group">
                                    <button class="btn btn-group-icon disabled notchecked" disabled><img src="/img/img-partitions.svg" alt="partitions" height="23" width="24"></button>
                                    <button type="submit" class="btn btn-primary disabled notchecked partition" name="action" value="armPartition" id="armPartition" title="{[ Lang::get('content.arm') ]}" disabled><i class="fa fa-2x fa-lock" style="font-size:21px;color:black;"></i></button>
                                    <button type="submit" class="btn btn-primary disabled notchecked partition" name="action" value="disarmPartition" id="disarmPartition" title="{[ Lang::get('content.disarm') ]}" disabled><i class="fa fa-2x fa-unlock" style="font-size:21px;color:black;"></i></button>
                                </div>
                                {[ Form::close() ]}
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-6" >
                            <div id="div-zone">
                                @if($permIntegraManage)
                                {[ Form::open(array('route' => 'control.action', 'method' => 'post', 'class'=>'ajax zone')) ]}
                                <input name="idIntegra" id="idIntegra" type="hidden" value="{[ $integra->getId() ]}">
                                <p id="zone-p"></p>
                                {[Form::hidden('action') ]}
                                <div class="btn-group">
                                    <button class="btn btn-group-icon disabled notchecked" disabled><img src="/img/img-zones.svg" alt="zones" height="23" width="24" ></button>
                                    <button type="submit" name="action" value="unbyPassZone" class="btn btn-primary disabled notchecked zone" title="{[ Lang::get('content.unbyPass') ]}" disabled><i class="fa fa-2x fa-check-circle" style="font-size:21px;color:black;"></i></button>
                                    <button type="submit" name="action" value="byPassZone" class="btn btn-primary disabled notchecked zone" title="{[ Lang::get('content.byPass') ]}" disabled><i class="fa fa-2x fa-minus-circle" style="font-size:21px;color:black;"></i> </button>
                                    <button type="submit" name="action" value="byPassTempZone" class="btn btn-primary disabled notchecked zone" title="{[ Lang::get('content.byPassTemp') ]}" disabled><i class="fa fa-2x fa-clock" style="font-size:21px;color:black;"></i></button>
                                </div>
                                {[ Form::close() ]}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($integraStructureWithZonesTree as $object)
                <ul class="structure" style="list-style-type: none;">
                    <li><button class="btn btn-block" disable="disable">{[ $object->text ]}</button></li>
                    @foreach ($object->partitionList as $partition)
                    <ul style="list-style-type: none;">
                        <li>
                            <div class="btn btn-default structure-control" data-name='partition' data-value='{[ $partition->id ]}' style="text-align: left;line-height: 2em;">
                                <div class="struct-item-icon struct-part-icon" > </div><i class="far fa-2x fa-square" id="partition-i-{[ $partition->id ]}"></i>
                                <span>{[ $partition->text ]} </span>
                                <span class='part-state part-state-alarm {[($partition->stateExt->alarm) ? "" : "hidden"]}' title="{[ Lang::get('content.partitionStateAlarm') ]}"></span>
                                <span class='part-state part-state-alarm-memory {[($partition->stateExt->alarmMemory) ? "" : "hidden"]}' title="{[ Lang::get('content.partitionStateAlarmMemory') ]}"></span>
                                <span class='part-state part-state-alarm-memory {[($partition->stateExt->alarmMemoryVerified) ? "" : "hidden"]}'title="{[ Lang::get('content.partitionStateAlarmMemoryVerified') ]}"></span>
                                <span class='part-state part-state-alarm-memory-warn {[($partition->stateExt->warningAlarmMemory)? "" : "hidden"]}' title="{[ Lang::get('content.partitionStateWarningAlarmMemory') ]}"></span>
                                <span class='part-state part-state-fire {[($partition->stateExt->fireAlarm) ? "" : "hidden"]}'title="{[ Lang::get('content.partitionStateFireAlarm') ]}"></span>
                                <span class='part-state part-state-fire-memory {[($partition->stateExt->fireAlarmMemory) ? "" : "hidden"]}'title="{[ Lang::get('content.partitionStateFireAlarmMemory') ]}"></span>
                                <span class='part-state part-state-arm {[($partition->stateExt->arm) ? "" : "hidden"]}'title="{[ Lang::get('content.partitionStateArm') ]}"></span>
                                <span class='part-state part-state-arm1 {[($partition->stateExt->arm1) ? "" : "hidden"]}'title="{[ Lang::get('content.partitionStateArm1') ]}"></span>
                                <span class='part-state part-state-arm2 {[($partition->stateExt->arm2) ? "" : "hidden"]}'title="{[ Lang::get('content.partitionStateArm2') ]}"></span>
                                <span class='part-state part-state-arm3 {[($partition->stateExt->arm3) ? "" : "hidden"]}'title="{[ Lang::get('content.partitionStateArm3') ]}"></span>
                                <span class='part-state part-state-exit-delay {[($partition->stateExt->exitDelay) ? "" : "hidden"]}'title="{[ Lang::get('content.partitionStateExitDelay') ]}"></span>
                                <span class='part-state part-state-exit-delay-long {[($partition->stateExt->exitDelayLong) ? "" : "hidden"]}'title="{[ Lang::get('content.partitionStateExitDelayLong') ]}"></span>
                                <span class='part-state part-state-entry-delay {[($partition->stateExt->entryDelay) ? "" : "hidden"]}'ng-show="zone.stateExt.entryDelay" title="{[ Lang::get('content.partitionStateEntryDelay') ]}"></span>
                                <span class='part-state part-state-bypass {[($partition->stateExt->bypass) ? "" : "hidden"]}' title="{[ Lang::get('content.partitionStateBypass') ]}"></span>
                                <span class='part-state part-state-bypass-guard {[($partition->stateExt->guardBlocked) ? "" : "hidden"]}'title="{[ Lang::get('content.partitionStateGuardBlocked') ]}"></span>
                            </div>
                        </li>
                        @foreach ($partition->zoneList as $zone)
                        <ul style="list-style-type: none;">
                            <li>
                                <div class="btn btn-default structure-control" data-name='zone' data-value='{[ $zone->id ]}' style="text-align: left;line-height: 2em;">
                                    <div class="struct-item-icon struct-zone-icon"> </div>
                                    <i class="far fa-2x fa-square" id="zone-i-{[ $zone->id ]}"></i>
                                    <span>{[ $zone->text ]}</span>
                                    <span class='zone-state zone-state-bypass {[($zone->stateExt->bypass && !$zone->stateExt->bypassConst) ? ""  : "hidden"; ]} ' title="{[ Lang::get('content.zoneStateBypass') ]}"  ></span>
                                    <span class='zone-state zone-state-alarm {[($zone->stateExt->alarm) ? ""  : "hidden"; ]} ' title="{[ Lang::get('content.zoneStateAlarm') ]}" ></span>
                                    <span class='zone-state zone-state-violation {[($zone->stateExt->violation) ? ""  : "hidden"; ]}' title="{[ Lang::get('content.zoneStateViolation') ]}"  ></span>
                                    <span class='zone-state zone-state-tamper {[($zone->stateExt->tamper) ? ""  : "hidden"; ]}' title="{[ Lang::get('content.zoneStateTamper') ]}"  ></span>
                                    <span class='zone-state zone-state-tamper-alarm {[($zone->stateExt->tamperAlarm) ? ""  : "hidden"; ]}' title="{[ Lang::get('content.zoneStateTamperAlarm') ]}" ></span>
                                    <span class='zone-state zone-state-alarm-memory {[($zone->stateExt->memoryAlarm) ? ""  : "hidden"; ]}' title="{[ Lang::get('content.zoneStateMemoryAlarm') ]}"  ></span>
                                    <span class='zone-state zone-state-tamper-memory {[($zone->stateExt->memoryTamperAlarm) ? ""  : "hidden"; ]}' title="{[ Lang::get('content.zoneStateMemoryTamperAlarm') ]}"  ></span>
                                    <span class='zone-state zone-state-noViolation {[($zone->stateExt->noViolation) ? ""  : "hidden"; ]}' title="{[ Lang::get('content.zoneStateNoViolation') ]}"  ></span>
                                    <span class='zone-state zone-state-violationLong {[($zone->stateExt->longViolation) ? ""  : "hidden"; ]}' title="{[ Lang::get('content.zoneStateLongViolation') ]}"  ></span>
                                    <span class='zone-state zone-state-bypassConst {[($zone->stateExt->bypassConst) ? ""  : "hidden"; ]}' title="{[ Lang::get('content.zoneStateBypassConst') ]}"  ></span>
                                    <span class='zone-state zone-state-mask {[($zone->stateExt->mask) ? ""  : "hidden"; ]}' title="{[ Lang::get('content.zoneStateMask') ]}"  ></span>
                                    <span class='zone-state zone-state-mask-memory {[($zone->stateExt->memoryMask) ? ""  : "hidden"; ]}' title="{[ Lang::get('content.zoneStateMemoryMask') ]}"  ></span>
                                </div>
                            </li>
                        </ul>
                        @endforeach
                    </ul>
                    @endforeach
                </ul>
                @endforeach
            </div>
        </div>

    </div>

    @stop
    @section('javascripts')
    <script src="/js/integra-structure.f3eb66a3.js"></script>
    @stop