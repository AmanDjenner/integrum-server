@extends('layouts.default', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'titleDetail'=> $titleDetail])
@section('content')
<div class="row">
    <div class="content-header"><div class="top-buffer width-100">
            <h1 class="user-h1">{[ $user->name ]}</h1>
        </div>
        <ol class="breadcrumb">
            <li class="active"><b>{[ $hierarchyName]}</b></li>
        </ol>
		<span class="label label-default pull-right row" style="margin-top:0.5em;margin-right:0" onclick="window.location.reload();">{[date(Lang::get('content.dateServerFormatSec'))]} <i class="fa fa-redo"></i></span>
    </div>
    <div class="col-sm-12" id="middle">
            <div class="col-sm-12 top-buffer">
                <div class="tabs" role="tabpanel">
                    <!-- Nav tabs -->
                    <ul role="tablist">
                        <li role="presentation" {[(!isset($tab) || $tab=='user-1')?'class="active"':'']}><a href="#user-1" aria-controls="user-1" role="tab" data-toggle="tab">{[ Lang::get('content.user-general') ]}</a></li>
                        @if ($permUserIntegraEdit||$permUserIntegraRemove)
						<li role="presentation" {[(isset($tab) && $tab=='user-3')?'class="active"':'']}><a href="#user-3" aria-controls="user-3" role="tab" data-toggle="tab">{[ Lang::get('content.user-panels') ]}</a></li>
						@endif
                        <li role="presentation" {[(isset($tab) && $tab=='user-2')?'class="active"':'']}><a href="#user-2" aria-controls="user-2" role="tab" data-toggle="tab">{[ Lang::get('content.user-application') ]}</a></li>
                    </ul>
                </div>
                @yield('contentusers')
            </div> 
	</div>	
</div>
        @stop
	