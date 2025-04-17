@extends('layouts.default', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'titleDetail' => Lang::get('content.addPanel')])

@section('content')
<div class="row">
    <div class="content-header"><div class="top-buffer width-100">
            <h1 class="user-h1">{[ Lang::get('content.addPanel') ]} </h1>
        </div>
    </div>
    <div class="col-sm-12" id="middle">
        <div class="col-sm-12 top-buffer well" style="min-width: 480px;max-width: 850px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b id="message-tree"></b>
                </div>
                <div class="panel-body">
                    @include('integra/partials/_wizardPanel', array('st1'=>'active','st2'=>'','st3'=>''))
                    <div class="form-group">
                        <div>
                            <fieldset>
                                <div class="form-group">
                                    <input id='storeXcxValid' value='{[$storeXcxValid]}' style="display: none;" >
                                </div>
                                <div class="form-group">
                                    {[ Form::label('name', ucfirst(Lang::get('content.howToAdd')).': ',['class'=>'col-sm-2 control-label']) ]}
                                    <div class="col-md-10">
                                        <select class="form-control frm-mr-ln" id="selectIntegra" name="selectIntegra">
                                            <option value="a">{[ucfirst(Lang::get('content.parametersPanel'))]}</option>
                                            <option value="b">{[ucfirst(Lang::get('content.xcxPanel'))]}</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div id="div-integrum-a">
                            @include('integra/partials/_createWizard_1')
                        </div>
                        <div id="div-integrum-b" style="display: none;">
                            @include('integra/partials/_createWizard_1_1')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('javascripts')
<script src="/js/integra-add.c817adc1.js"></script>
@stop