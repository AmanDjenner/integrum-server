@extends('layouts.default',['titleDetail'=>Lang::get('content.dashboard'), 'meta'=>'IE=10'])

@section('content')
{[ Form::hidden('trans-comment', Lang::get('content.comment-do',['id'=>'trans-comment'])) ]}
{[ Form::hidden('trans-comment-next', Lang::get('content.comment-next',['id'=>'trans-comment-next'])) ]}
{[ Form::hidden('trans-comment-add', Lang::get('content.comment-add',['id'=>'trans-comment-add'])) ]}
{[ Form::hidden('trans-comment-delay', Lang::get('content.comment-delay',['id'=>'trans-comment-delay'])) ]}
{[ Form::hidden('trans-comment-date', Lang::get('content.comment-date',['id'=>'trans-comment-date'])) ]}
{[ Form::hidden('trans-comment-operator', Lang::get('content.comment-operator',['id'=>'trans-comment-operator'])) ]}
{[ Form::hidden('trans-comment-descr', Lang::get('content.comment-descr',['id'=>'trans-comment-descr'])) ]}
{[ Form::hidden('trans-comment-descr-add', Lang::get('content.comment-descr-add',['id'=>'trans-comment-descr-add'])) ]}
{[ Form::hidden('trans-comment-close', Lang::get('content.comment-close',['id'=>'trans-comment-close'])) ]}
{[ Form::hidden('trans-comment-close-handling', Lang::get('content.comment-close-handling',['id'=>'trans-comment-close-handling'])) ]}
{[ Form::hidden('trans-comment-confirm', Lang::get('content.comment-confirm',['id'=>'trans-comment-confirm'])) ]}
{[ Form::hidden('trans-comment-confirm-yes', Lang::get('content.comment-confirm-yes',['id'=>'trans-comment-confirm-yes'])) ]}
{[ Form::hidden('trans-comment-confirm-no', Lang::get('content.comment-confirm-no',['id'=>'trans-comment-confirm-no'])) ]}
{[ Form::hidden('trans-comment-default', Lang::get('content.comment-default',['id'=>'trans-comment-default'])) ]}
{[ Form::hidden('trans-comment-clear-alarm', Lang::get('content.clearAlarm',['id'=>'trans-comment-clear-alarm'])) ]}
{[ Form::hidden('trans-comment-disarm', Lang::get('content.disarm',['id'=>'trans-comment-disarm'])) ]}

<div class="panel-split">
    <div class="row">
        <div class="col-lg-4">
            <input id="token" data-token="{[ $token ]}" hidden="hidden" />
            <div class="panel-wrapper h1-3" id="properties" >
                @include('dashboard/partials/_control', ['buttons' => $buttons])
            </div>
            <div class="dashboard-detail panel-wrapper h1-3" id="properties-start" data-type="start">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-info-circle fa-fw"></i></h3>
                    </div>
                    <div class="panel-body">
                        <i class="fa fa-info-circle fa-icon-default"></i>
                    </div>
                </div>
            </div>

            <div class="dashboard-detail panel-wrapper h1-3" id="properties-event-integra" data-type="integra">
                @include('dashboard/partials/_propertiesIntegra')
            </div>
            <div class="dashboard-detail panel-wrapper h1-3" id="properties-event-csp" data-type="csp">
                @include('dashboard/partials/_propertiesCsp')
            </div>
            <div class="dashboard-detail panel-wrapper h1-3" id="properties-control-list" data-type="list">
                @include('dashboard/partials/_controlList')
            </div>
        </div>
        <div class="col-lg-8">
            <div class="panel-wrapper h2-3 hidden-xs" id="panel3">
                @include('dashboard/partials/_maps',['permMapEdit' => $permMapEdit, 'permExtraAuth' => $permExtraAuth])
            </div>
        </div>
    </div>

    <div class="row">
        <input type="hidden" value="{[ csrf_token() ]}" name="_token">
        @include('dashboard/partials/_event', ['id' => 1, 'title' => $dashboardEvent[1]])
        @include('dashboard/partials/_event', ['id' => 2, 'title' => $dashboardEvent[2]])
        @include('dashboard/partials/_event', ['id' => 3, 'title' => $dashboardEvent[3]])
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
<script src="maps/js/maps.2ce66703.js"></script>
<script type="text/javascript">$(document).ready(function() {
   integrumDash.init(JSON.parse('{[$initData]}'));
      });</script>
@stop