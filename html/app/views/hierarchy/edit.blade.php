@extends('layouts.default', ['sideRegionVars'=>$sideRegionVars, 'titleDetail' => Lang::get('content.settings') ])

@section('content')
<?php $editTree = true; ?>
<div class="row" style="margin-left: 208px;">
    <div class="col-sm-12 top-buffer content-header"><div class="top-buffer width-100" style="margin-left: 32px;">
            <h1 class="user-h1">{[ Lang::get('content.settings') ]} </h1>
    <a href="#create" class="btn-create"><i class="fa fa-lg fa-plus"></i></a>
        </div>
    </div>
    <div class="col-sm-12 top-buffer">
        <div role="tabpanel" style="margin-left: 32px;">
            <input id="dataHierarchy" name="dataHierarchy" data-value='{[$dataHierarchy]}' hidden />
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade" id="hierarchy-1">
                    <div class="col-sm-8 margin-35">
                        <div class="col-sm-12 top-buffer well" style="min-width: 480px;max-width: 850px;">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    {[ Lang::get('content.edit') ]}
                                </div>
                                <div class="panel-body">

                                    <div class="tab-content">
                                        {[ Form::open(array('route' => ['hierarchy.update', 0], 'method' => 'PUT')) ]}
                                        <input type="hidden" name="hierarchyId" id="hierarchyId" />
                                        <div class="form-group">
                                            {[ Form::label('name', Lang::get('content.name').':',['class'=>'col-sm-4 control-label']) ]}
                                            <div class="col-sm-8">
                                                {[ Form::text('name',NULL,['class'=>'form-control frm-mr-ln', 'id'=>'name']) ]}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {[ Form::label('parent', Lang::get('content.parent').':',['class'=>'col-sm-4 control-label']) ]}
                                            <div class="col-sm-8">
                                                <select class="form-control" name="parentId" id="parentId">
                                                    <option class='active' value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-4 margin-10 text-right">
                                                    <a href="#" class="btn btn-default btn-icon" data-toggle="modal" id="btnRemove" data-target="#controlDestroy" title="{[ Lang::get('content.remove') ]}"><i class="fa fa-lg fa-times red-txt"></i></a>
                                                    <button type="submit" title="{[ Lang::get('content.save') ]}" class="btn btn-icon btn-warning" ><i class="fa fa-lg fa-download"></i></button>
                                            </div>
                                        </div>
                                        {[ Form::close() ]}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($permManRegion)
                <div role="tabpanel" class="tab-pane fade" id="hierarchy-2">
                    <div class="col-sm-8 margin-35">
                        <div class="col-sm-12 top-buffer well" style="min-width: 480px;max-width: 850px;">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    {[ Lang::get('content.add') ]}
                                </div>
                                <div class="panel-body">

                                    <div class="tab-content">
                                        {[ Form::open(array('route' => 'hierarchy.store', 'method' => 'post')) ]}
                                        <div class="form-group">
                                            {[ Form::label('name', Lang::get('content.name').':',['class'=>'col-sm-4 control-label']) ]}
                                            <div class="col-sm-8">
                                                {[ Form::text('name',NULL,['class'=>'form-control', 'id'=>'name']) ]}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {[ Form::label('parentNew', Lang::get('content.parent').':',['class'=>'col-sm-4 control-label']) ]}
                                            <div class="col-sm-8 margin-10">
                                                <select class="form-control" name="parentNew" id="parentNew">
                                                    <option class='active' value=""></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-8 col-sm-offset-4 margin-10 text-right">
                                                <a href="#edit" id="regionEdit" class="btn btn-icon btn-default" title="{[ Lang::get('content.cancel')]}"><i class="fa fa-lg fa-ban"></i></a>
                                                <button type="submit" title="{[ Lang::get('content.save') ]}" class="btn btn-icon btn-warning" ><i class="fa fa-lg fa-download"></i></button>
                                            </div>
                                        </div>
                                        {[ Form::close() ]}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				@endif
            </div>

        </div>
    </div>
</div>
@stop
@section('modalDialogs')
<div class="modal" id="controlDestroy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                &nbsp;&nbsp;
            </div>
            <div class="modal-body" style="width: 70%; margin: 0 auto;">
                <h3>{[ Lang::get('content.removeHierarchy') ]} <b id="delethierarchy"> </b>?</h3>
            </div>
            <div class="modal-footer">
                {[ Form::open(array('route' => 'hierarchy.destroy', 'method' => 'post')) ]}
                <input type="hidden" name="id-remove" id="id-remove" />
                <input type="hidden" name="id-parent" id="id-parent" />
                <button type="button" class="btn btn-default" data-dismiss="modal">{[ Lang::get('content.cancel') ]}</button>
                <button class="btn btn-danger btn-ok">{[ Lang::get('content.remove') ]}</button>
                {[ Form::close() ]}
            </div>
        </div>
    </div>
</div>
@stop
@section('javascripts')
<script src="/js/hierarchy.b4ee3789.js"></script>
@stop