@extends('layouts.default', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'titleDetail' => Lang::get('content.addUser')])

@section('content')
    <input type="hidden" value="{[Lang::get('content.file-too-big')]}" id="trans-file-too-big">
<div class="row">
    <div class="content-header"><div class="top-buffer width-100">
            <h1 class="user-h1">{[ Lang::get('content.addUser') ]}</h1>
        </div>
    </div>
    <div class="col-sm-12" id="middle">
        <div class="col-sm-12 top-buffer row">
            <div role="tabpanel">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="user-1">
                        {[ Form::open(array('route' => 'users.store' , 'files' => true , 'method' => 'post', 'class'=>'form-horizontal', 'role'=>'form')) ]}
                        <div class="col-sm-8 margin-35">
                            <div class="form-group">
                                <label for="message-tree" class="col-sm-5 control-label">{[ Lang::get('content.object-region') ]}</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <input readonly class="form-control" id="message-tree" />
                                        <input type="hidden" name="hierarchyId" id="hierarchyId" />
                                        <span class="input-group-btn">
                                            <a href="#" class="btn" id="locationOpen"><span class="fa fa-lg fa-edit"></span></a>
                                        </span>
                                    </div>
                                    @if($errors->first('hierarchyId'))
                                    <div class="alert alert-warning" role="alert">{[ $errors->first('hierarchyId') ]}</div>
                                    @endif
                                </div>
                            </div>
                            @include('users/partials/_form')
							<div>
								<div class="col-sm-offset-4 col-md-offset-5 col-sm-8 col-md-7"><hr /></div>
							</div>
							<div class="form-group">
								{[ Form::label('input-integraDefName', Lang::get('content.user-integraintegraname'),['class'=>'col-sm-4 col-md-5 control-label']) ]}
								<div class="col-sm-8 col-md-7">
									{[ Form::text('integraDefName',NULL,['class'=>'form-control frm-mr-ln', 'maxlength'=>'16', 'id'=>'input-integraDefName', 'tabindex' => '500']) ]}
									{[ $errors->first('integraDefName') ]}
								</div>
							</div>
							<div class="form-group">
								{[ Form::label('input-code', Lang::get('content.user-integracode'),['class'=>'col-sm-4 col-md-5 control-label']) ]}
								<div class="col-sm-8 col-md-7 ml-0">
									<div class="input-group">
										{[ Form::password('code',['placeholder'=>isset($user)?$user->code:'', 'class'=>'form-control frm-mr-ln', 'maxlength'=>'8', 'id'=>'input-code', 'tabindex' => '501']) ]}
										<span class="input-group-btn">
											<a href="#" id="changeToText" data-value='{"id":0,"span":"changeSpan","input":["input-code"]}' class="btn changeToText" ><span id="changeSpan" class="fa fa-eye"></span></a>
										</span>
									</div>
									@if($errors->first('code'))
									<div class="alert alert-warning" role="alert">{[ $errors->first('code') ]}</div>
									@endif
								</div>
							</div>
							<div class="form-group">
								<label for="input-pin" class="col-sm-4 col-md-5 control-label"></label>
								<div class="col-sm-8 col-md-7"><br /></div>
							</div>
                            @if ($permUserIntegraCreate)
                            <div class="form-group">
                                {[ Form::label('permissionProfileId', Lang::get('content.profile').':',['class'=>'col-sm-5 control-label']) ]}
                                <div class="col-sm-7">
                                    <select name='permissionProfileId' class='form-control frm-mr-ln' id='permissionProfileId' disabled='disabled' tabindex = 503> 
									@foreach ($profile as $p)
										<option value="{[ $p['id']]}" data-utype="{[ $p['t']]}">{[ $p['name'] ]}</option>
									@endforeach
									</select>
                                </div>
                            </div>
							<div class="form-group" style="display:none" id="userCntSection">
								<label for="userCnt" class="col-sm-5 control-label">{[ Lang::get('content.userCnt') ]}</label>
								<div class="col-sm-7">
									{[ Form::number('userCnt',NULL,['class'=>'form-control', 'min'=>'1', 'max'=>'255', 'step'=>'1', 'id'=>'userCnt']); ]}
								</div>
							</div>
							<div class="form-group" style="display:none" id="userSchemaSection">
								<label for="userSchema" class="col-sm-5 control-label">{[ Lang::get('content.userSchema') ]}</label>
								<div class="col-sm-7">
									{[ Form::number('userSchema',NULL,['class'=>'form-control', 'min'=>'1', 'max'=>'8', 'step'=>'1', 'id'=>'userSchema']); ]}
								</div>
							</div>
                            <div class="form-group" style="display:none" id="panelSection">
                                {[ Form::label('integraIdList', Lang::get('content.panellist'),['class'=>'col-sm-5 control-label']) ]}
                                <div class="col-sm-7">
                                    <input type="hidden" name="integraIdListOld" id="integraIdListOld" value="[{[ (Input::old('integraIdList'))?implode(", ", Input::old('integraIdList')):'' ]}]"/>
                                           {[ Form::select('integraIdList[]',[],NULL ,[
                                           'class'=>'form-control frm-mr-ln',
                                           'multiple' => 'multiple',
                                           'id'=>'integraIdList',
                                           'style'=>'width:100%',
                                           'disabled'=>'disabled',
										   'tabindex' => '502'
                                           ]); ]}
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col-sm-4 margin-35">						
                        @include('users/partials/_photo', ['userPhoto' => (Input::old('photo'))?Input::old('photo'):'/img/foto.jpg'])
						</div>
                        <div class="form-group">
                            <div class="col-sm-5 col-sm-offset-3 text-right" id='user-submit'>
                                <button type="submit" class="btn btn-default btn-sm btn-icon margin-10" name="create" value="back" title="{[Lang::get('content.saveCreate')]}">
                                    <span class="fa-stack cardButton">
                                        <i class="fa fa-lg fa-stack-1x fa-download"></i>

                                        <span class="save-userredo-overlay">
                                            <i class="fa fa-stack-1x fa-undo"></i>
                                        </span>
                                    </span>
                                </button>
                                <button type="submit" class="btn btn-warning btn-sm btn-icon margin-10" title="{[Lang::get('content.save')]}">
                                    <i class="fa fa-lg fa-download"></i>
                                </button>
                            </div>
                        </div>
                        {[ Form::close() ]}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
@section('javascripts')
<script src="/js/user-create.54912c5a.js"></script>
@stop