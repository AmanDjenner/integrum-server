<?php $type = isset($type)?$type:"a"; ?>
<div class="tab-content">
    {[ Form::open(array('route' => 'control.store' , 'files' => true , 'method' => 'post')) ]}
<div class="ethm-content div-wizard" style="padding-left:15px;padding-right:15px">
    <fieldset>
        <div class="form-group">
            <div class="col-sm-12">
                <h4>{[ ucfirst(Lang::get('content.integra')) . ":" . Lang::get('content.ethm')]}</h4>
            </div>
        </div>
        <div class="form-group row">
            {[ Form::label('ethm', ucfirst(Lang::get('content.connectionType')),['class'=>'col-sm-2 control-label']) ]}
            <div class="col-sm-10">
                <select class="form-control" id="idEthm" name="ethm">
                    <option value="a" {[ ($type =="a")?'selected':'']}>{[ ucfirst(Lang::get('content.ofMacImei')) ]}</option>
                    <option value="b" {[ ($type =="b")?'selected':'']}>{[ ucfirst(Lang::get('content.ofTCPIP')) ]}</option>
                    @if (Config::get('parameters.EthmNewServer', false))
                    <option value="c" {[ ($type =="c")?'selected':'']}>{[ ucfirst(Lang::get('content.newServerSatel')) ]}</option>
                    @endif
                    <?php
                    if (count($ethm)>0) {
                        ?>
                        <optgroup label="{[ Lang::get('content.ethm') ]}:">
                            @foreach ($ethm as $value => $text)
                            <option value="{[$value]}">{[$text]}</option>
                            @endforeach
                        </optgroup>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group" id="sub-ethmList-row" style="display: none;" id="">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10 form-inline">
                {[ Form::submit( Lang::get('content.next'),['class'=>'btn btn-warning btn-block', 'id' =>'sub-ethmList']) ]}
            </div>
        </div>
    </fieldset>
</div>
    {[ Form::close() ]}
</div>
