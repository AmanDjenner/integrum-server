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
                    @include('integra/partials/_wizardPanel', array('st1'=>'','st2'=>'active','st3'=>''))
                    <input id="ethmerrors" value="{[$ethmerrors]}" hidden />
                    <div class="form-group">
                        <div>
                            @include('integra/partials/_createWizard_2_regtypes')
                        </div>
                        <div id="div-ethm-2_a" style="display: none;">
                            @include('integra/partials/_createWizard_2_mac')
                        </div>
                        <div id="div-ethm-2_b" style="display: none;">
                            @include('integra/partials/_createWizard_2_tcp')
                        </div>
                        <div id="div-ethm-2_c" style="display: none;">
                            @include('integra/partials/_createWizard_2_srv')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('javascripts')
<script src="/js/integraethm-add.ee3849cb.js"></script>
@stop