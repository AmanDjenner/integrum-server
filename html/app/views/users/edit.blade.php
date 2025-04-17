@extends('users.defaultusers', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'titleDetail'=>  Lang::get('content.user') .' '. $user->name ])
@section('contentusers')

<!-- Tab panes -->
<div class="tab-content">
    <input type="hidden" value="{[Lang::get('content.select')]}" id="translate-select">
    <input type="hidden" value="{[Lang::get('content.addNew')]}" id="translate-selectAddNew">
    <input type="hidden" value="{[Lang::get('content.selectPartition')]}" id="translate-selectPartition">
    <input type="hidden" value="{[Lang::get('content.cardNumberHeader')]}" id="trans-remove-card-title">
    <input type="hidden" value="{[Lang::get('content.card-remove-message')]}" id="trans-remove-card-message">
    <input type="hidden" value="{[Lang::get('content.card-add-message')]}" id="trans-place-card-message">
    <input type="hidden" value="{[Lang::get('content.card-add-again-message')]}" id="trans-place-again-card-message">
    <input type="hidden" value="{[Lang::get('content.file-too-big')]}" id="trans-file-too-big">
    <input type="hidden" value="{[Lang::get('messages.integraAction-message')]}" id="trans-integraAction-message">
    <input type="hidden" value="{[$tab or 'user-1']}" id="activeTab">
    <div role="tabpanel" class="tab-pane fade {[(!isset($tab) || $tab=='user-1')?' in active':'']}" id="user-1">
        {[ Form::model($user->attributes(), ['method' => 'PATCH', 'route' => ['users.update', $user->id], 'files' => true ]) ]}
    {[ Form::hidden('tab','user-1') ]}
		<div class="row">
		<div class="col-sm-2 col-sm-push-10 col-md-3 col-md-push-9 margin-35">						
		@include('users/partials/_photo', ['userPhoto' => $user->photo])
		</div>
        <div class="col-sm-10 col-sm-pull-2 col-md-9 col-md-pull-3 margin-sm-35">
            <div class="form-group">
                <label for="message-tree" class="col-sm-4 col-md-5 control-label">{[ Lang::get('content.object-region') ]}</label>
                <div class="col-sm-8 col-md-7">
                    <div class="input-group">
                        <input readonly class="form-control" id="message-tree" value="{[ $hierarchyName ]}"/>
                        <input type="hidden" name="hierarchyId" id="hierarchyId" value="{[ $user->hierarchyId ]}"/>
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
			{[ Form::hidden('integraDefName',NULL,['id'=>'input-integraDefName']) ]}
			{[ Form::hidden('code',NULL,['id'=>'input-code']) ]}
        </div>
        </div>
		<div class="row">
        <div class="col-sm-10 col-md-9 margin-35">
            <div class="form-group">
                @if ($permUserEdit)
                <div class="col-sm-8 col-md-7 col-sm-offset-4 col-md-offset-5 text-right">
                    <button type="submit" title="{[ Lang::get('content.user-save') ]}" class="btn btn-icon btn-warning" ><i class="fa fa-lg fa-download"></i></button>
                </div>
                @endif
            </div>
		</div>
		</div>
        {[ Form::close() ]}
    </div>
    @if ($permUserIntegraEdit||$permUserIntegraRemove)
    <div role="tabpanel" class="tab-pane fade {[(isset($tab) && $tab=='user-3')?' in active':'']}" id="user-3">
<div class="container-fluid">
<div class="row">
        @include('users/panel/partials/_form',['type'=>$type, 'access' => $access])
        <div id='pre'></div>
    </div>
    </div>
    </div>
	@endif
    <div role="tabpanel" class="tab-pane fade {[(isset($tab) && $tab=='user-2')?' in active':'']}" id="user-2">
        @include('users/app/partials/_form',['approles'=>$role])
    </div>
</div>
@stop
@section('modalDialogs')
@if($permUserIntegraEdit)
@include('integra/user/carddialog', ['cardList' => $cardList])
@endif
@if($permUserIntegraRemove)
@include('integra/user/removeuserdialog',['idIntegra' => 0])
@endif
@yield('usermodalDialogs')
@stop
@section('javascripts')
<script src="/js/user-edit.3d6447f0.js"></script>
@if ($permUserIntegraEdit||$permUserIntegraRemove)
<script src="/js/user-panel.aeddfe57.js"></script>
@endif
@stop