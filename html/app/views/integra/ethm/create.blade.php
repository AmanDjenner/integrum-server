@extends('layouts.default', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'titleDetail' => Lang::get('content.addETHM')])

@section('content')
<div class="row">
    <div class="content-header"><div class="top-buffer width-100">
            <h1 class="user-h1">{[ Lang::get('content.addETHM') ]}</h1>
        </div>
        <ol class="breadcrumb">
            <li class="active"><b id="message-tree"></b></li>
        </ol>
    </div>
    <div class="col-sm-12" id="middle">
        <div class="col-sm-12 top-buffer">
            <div role="tabpanel">
                <!-- Nav tabs -->
                <!-- Tab panes -->
                <div class="ethm-content">
                    {[ Form::open(array('route' => 'ethm.store' , 'files' => true , 'method' => 'post')) ]}
                    <input type="hidden" name="idGroup" id="idGroup"/>
                    {[ $errors->first('idGroup') ]}
                    <fieldset>
                        <div class="row">
                            <div class="col-md-3 control-label">
                                {[ Form::label('address', Lang::get('content.addressip')) ]}
                            </div>
                            <div class="col-md-6">
                                {[ Form::text('address',NULL,['class'=>'form-control frm-mr-ln', 'id'=>'address']) ]}
                                {[ $errors->first('address') ]}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 control-label">
                            </div>
                            <div class="col-md-3">
                                {[ ucfirst(Lang::get('content.guardX')) ]}
                            </div>
                            <div class="col-md-3">
                                {[ ucfirst(Lang::get('content.dloadX')) ]}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 control-label">
                                {[ Form::label('guardPort', 'Port') ]}
                            </div>
                            <div class="col-md-3">
                                {[ Form::number('guardPort',NULL,['class'=>'form-control frm-mr-ln', 'min'=>'1', 'step'=>'1', 'id'=>'guardPort']) ]}
                                {[ $errors->first('guardPort') ]}
                            </div>
                            <div class="col-md-3">
                                {[ Form::number('dloadPort',NULL,['class'=>'form-control frm-mr-ln', 'min'=>'1', 'step'=>'1', 'id'=>'dloadPort']) ]}
                                {[ $errors->first('dloadPort') ]}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 control-label">
                            </div>
                            <div class="col-md-3">
                                GuardX
                            </div>
                            <div class="col-md-3">
                                DloadX
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 control-label">
                                {[ Form::label('guardkey', 'Klucz') ]}
                            </div>
                            <div class="col-md-3">
                                {[ Form::input('password','guardkey',NULL,['class'=>'form-control frm-mr-ln', 'maxlength'=>'12', 'id'=>'guardkey']) ]}
                                {[ $errors->first('guardkey') ]}
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    {[ Form::input('password','dloadkey',NULL,['class'=>'form-control frm-mr-ln', 'maxlength'=>'12', 'id'=>'dloadkey']) ]}
                                    <span class="input-group-btn">
                                        <a href="#" id="changeToText" data-value='{"id":0,"span":"changeSpan","input":["guardkey","dloadkey"]}' class="btn changeToText" ><span id="changeSpan" class="fa fa-eye"></span></a>
                                    </span>
                                    {[ $errors->first('guardkey') ]}
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 control-label">
                                {[ Form::label('nameEthm', 'Nazwa ETHM') ]}
                            </div>
                            <div class="col-md-6">
                                {[ Form::text('nameEthm',NULL,['class'=>'form-control frm-mr-ln', 'id'=>'name']) ]}
                                {[ $errors->first('name') ]}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 control-label">
                                {[ Form::label('number', 'Numer ewidencyjny') ]}
                            </div>
                            <div class="col-md-6">
                                {[ Form::text('number',NULL,['class'=>'form-control frm-mr-ln', 'id'=>'number']) ]}
                                {[ $errors->first('number') ]}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">

                                </div>
                                <div class="col-sm-3 ml-0">
                                    <button type="submit" title="{[ Lang::get('content.save') ]}" class="btn btn-warning pull-right btn-block" ><i class="fa fa-lg fa-download"></i></button>
                                </div>
                                <div class="col-sm-3">
                                    <button type="submit" title="{[ Lang::get('content.saveCreate') ]}" class="btn btn-warning pull-right btn-block" name="create" ><i class="fa fa-lg fa-download"></i></button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    {[ Form::close() ]}
                </div>

            </div>
        </div>
    </div>
</div>
@stop
@section('javascripts')
<script src="/js/integraethm-add.ee3849cb.js"></script>
@stop