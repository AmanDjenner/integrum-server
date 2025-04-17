@extends('layouts.default',['titleDetail'=>Lang::get('content.dashboard'), 'meta'=>'IE=10'])

@section('content')
<div class="panel-split">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel-wrapper" id="panel3" style="height:99vh">
                @include('dashboard/partials/_maps',['permMapEdit' => $permMapEdit, 'permExtraAuth' => $permExtraAuth])
            </div>
        </div>
    </div>

</div>
<div id="ol-css-viewport" style="display:none;"></div>
@stop
@section('stylesheets')
<link rel="stylesheet" href="maps/css/maps.731b39f9.css">
@stop
@section('javascripts')
<script src="/js/script-list.js"></script>
<script src="/js/dash.js"></script>
<script type="text/javascript" src="/maps/js/ol.59d95389.js"></script>
<script src="maps/js/maps-min.09745962.js"></script>
<script type="text/javascript">$(document).ready(function() {
   integrumDash.init(JSON.parse('{[$initData]}'));
      });</script>
@stop