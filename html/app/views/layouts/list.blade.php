@extends('layouts.default',['titleDetail'=>$listTitle])
@section('content')
            <div class="row content-header">
                <div class="width-100 top-buffer">
                    <h1>{[ $listTitle ]}</h1>
                    @if(isset($addLink))
                    <a href="{[$addLink]}" class="btn-create"><i class="fa fa-lg fa-plus"></i></a>
                    @endif
                    <div class="pull-right" style="margin-right:8px;">{[$customButtons or '']}</div>
                </div>
				
                <div class="col-sm-12 pl-0" style="height:0px">
                    <ol class="breadcrumb">
                        <li class="active"><b id="message-tree">{[$currentHierarchy->getName() . $currentHierarchy->getPermissionsInfo()]}</b></li>
                    </ol>
					<span class="label label-default pull-right row" style="margin-top: 0.5em;" id="refreshDateBtn"><span id="refreshDateTxt">{[date("Y-m-d H:i:s")]}</span> <i class="fa fa-redo"></i></span>
                </div>
            </div>
@yield('listcontent')
@stop
@section('javascripts')
        <script src="/js/script-list.04b08598.js"></script>
@yield('listjavascripts')
@stop