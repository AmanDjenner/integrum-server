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

                </div>
                <div class="panel-body">
                    @include('integra/partials/_wizardPanel', array('st1'=>'','st2'=>'','st3'=>'active'))
                    <div id="div-integrum-1">
                        <div class="tab-content">
                            <div class="row div-wizard">
                                <div class="form-group"></div>
                                @if (0 != $idIntegra)
                                <div class="form-group">
                                    <div class="col-xs-6 col-md-4 frm-mr-ln">
                                        <a href="{[$addLink]}" class="btn btn-success btn-block">{[Lang::get('content.addPanel')]}</a>
                                    </div>
                                    <div class="col-xs-6 col-md-8 frm-mr-ln">
                                        <a href="/control/{[$idIntegra]}/edit/" class="btn btn-warning btn-block">{[Lang::get('content.next')]}</a>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop