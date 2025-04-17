@extends('integra.defaultintegra', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'permIntegraManage'=>$permIntegraManage, 'statusDesc' => $integra->getStatusDesc(), 'titleDetail'=>  Lang::get('content.panel') .' '. $integra->getName() .' - '. Lang::get('content.users')])


@section('contentintegra')
<!-- Tab panes -->
<div class="tab-content"> 
{[ Form::hidden('transSlctNoPartition', Lang::get('content.slct-no-partition'), ['id'=>'trans-slct-no-partition'])]} 
    <input type="hidden" value="{[Lang::get('content.addNew')]}" id="translate-selectAddNew">
    <input type="hidden" value="{[Lang::get('content.selectPartition')]}" id="translate-selectPartition">
    <input type="hidden" value="{[ Lang::get('content.list-zone') ]}" id="translate-select-partition-label">
    <input type="hidden" value="{[ Lang::get('content.typeUser') ]}" id="translate-user-type">
    <input type="hidden" value="{[ Lang::get('content.permissions') ]}" id="translate-user-rights">


    <input type="hidden" value="{[$integra->getId()]}" id="structure-integraId">
    <input type="hidden" value="{[Lang::get('content.user-integraintegraname')]}" id="structure-integrausername">
    <input type="hidden" value="{[Lang::get('content.user-preSelect')]}" id="structure-noUserDescr">
    <input type="hidden" value="{[Lang::get('content.integrum-user')]}" id="trans-integrum-user">
    <input type="hidden" value="{[Lang::get('content.user-remove-message')]}" id="trans-remove-userlink">
    <input type="hidden" value="{[Lang::get('content.cardNumberHeader')]}" id="trans-remove-card-title">
    <input type="hidden" value="{[Lang::get('content.card-remove-message')]}" id="trans-remove-card-message">
    <input type="hidden" value="{[Lang::get('content.card-add-message')]}" id="trans-place-card-message">
    <input type="hidden" value="{[Lang::get('content.card-add-again-message')]}" id="trans-place-again-card-message">
    <input type="hidden" value="{[Lang::get('messages.integraAction-message')]}" id="trans-integraAction-message">

    <input type="hidden" value="{[ $hierarchyId]}" id="hierarchyId">
    <table class="table table-striped" id="integraUserTable" align="center" style="max-width: 990px;min-width: 900px">
        <tbody>
            <tr>
                <th></th>
                <th colspan="2">{[ Lang::get('content.integrumName') ]}</th>
                <!--<th style="width:100px;max-width:100px">&nbsp;</th> -->
                <th>{[ Lang::get('content.userType') ]}</th>
                <th>{[ Lang::get('content.o') ]}</th>
                <th>{[ Lang::get('content.u') ]}
                @if($permUserIntegraCreate&&!($permUserIntegraEdit||$permUserIntegraRemove))
                    <button class="btn btn-xs pull-right" data-toggle="modal" data-target="#addUserDialog" data-backdrop="static" ><i class="fa fa-lg fa-user-plus"></i></button>
                @endif
				</th>
               <!-- {[ (Config::get('parameters.integraUser.cardNumber',true)) && $integra->getShowCards() ? '<th>'.Lang::get('content.cardNumberHeader').'</th>':'' ]}
                {[ (Config::get('parameters.integraUser.dallasNumber',false)) && $integra->getShowCards() ? '<th>'.Lang::get('content.dallasNumberHeader').'</th>':'' ]}
                -->
                @if ($permUserIntegraEdit||$permUserIntegraRemove)
                <th style="text-align:right" >{[ Lang::get('content.list-action') ]}</th>
                <th style="text-align:center" >
                @if($permUserIntegraCreate&&($permUserIntegraEdit||$permUserIntegraRemove))
                    <button class="btn btn-xs pull-right" data-toggle="modal" data-target="#addUserDialog" data-backdrop="static" ><i class="fa fa-lg fa-user-plus"></i></button>
                @endif
				</th>
                @endif
            </tr>
            @foreach ($integraUserList as $integraUser)
            <tr data-idintegra="{[ $integra->getId() ]}"  
						data-idobject="{[$integraUser->idObject]}" 
						data-username="{[$integraUser->userName]}" 
						data-name="[{[ $integraUser->idx ]}] {[$integraUser->name]}" 
						data-newname="{[$integraUser->name]}" 
						data-iduser="{[$integraUser->idUser]}" 
						data-integraUserId="{[$integraUser->id]}" 
						data-idx="{[$integraUser->idx]}" >
                        <td style="max-width:35px;width:35px"></td>

                <td align="right" style="width:35px">
                    <div id="userIcon-{[$integraUser->id]}" style="float:left;height:22px;" data-toggle2="tooltip" 
					@if($integraUser->idUser)
						title="{[Lang::get('content.user-integraintegraname')]}: [{[ $integraUser->idx ]}] {[ $integraUser->name ]}"
                    @else
						title="[{[ $integraUser->idx ]}]"
                    @endif
					>
                    	<img class="logo icon-integrum" src="/img/logo_integrum_bw.svg" width="20" alt="INTEGRUM user" style="
                        @if(!$integraUser->idUser)
							display:none;
                        @endif
							">
                    <i class="fa fa-lg fa-calculator icon-integra" style="
                        @if($integraUser->idUser)
							display:none;
                        @endif
							"></i>
					&nbsp;&nbsp;</div>
                </td>
                <td style="width:225px">
                    <a id="userlink-{[$integraUser->id]}"  data-toggle="modal" data-keyboard="true" data-target="#manageUserControl" style="float:left" href="#">
                        {[ ($integraUser->userName)? $integraUser->userName : $integraUser->name ]}
                    </a>
                </td>
                <td style="width:80px;max-width:225px;">{[ $integraUser->type ]}</td>
                <td style="width:60px"><span data-toggle2="tooltip" title="{[$integraUser->o]}">{[ $integraUser->p ]}</span></td>
                <td style="width:200px">{[ $integraUser->u ]}</td>
                {[ (Config::get('parameters.integraUser.dallasNumber',false) && $integra->getShowCards())?'<td>'.$integraUser->dallasNumber.'</td>':'' ]}
                @if ($permUserIntegraEdit||$permUserIntegraRemove)
                <td style="width:45px;max-width:45px;padding-right:0px;" align="right">
                    <div>
                        @if (Config::get('parameters.integraUser.cardNumber',true) && $integra->getShowCards())
                        <a class="btn btn-xs card-btn-defcolor @if (isset($integraUser->repeatedCard) && ($integraUser->repeatedCard>0))
                                      cardWarning
                                      @endif
" data-idintegra="{[ $integra->getId() ]}" data-useridx="{[ $integraUser->idx ]}" data-username="{[ $integraUser->name ]}" data-name="{[ $integra->getName()]}" data-toggle="modal" data-target="#modalAccessControl" data-cardnumber="{[$integraUser->cardNumber]}" title="{[$integraUser->cardNumber . "\n" . ControlPanels::cardDuplicates($cardListArray, $integraUser->cardNumber, $integraUser->idx)]}">
                            <span class="fa-stack cardButton">
                                <i class="fa fa-lg fa-rotate-315 fa-stack-1x fa-credit-card"></i>
                                <span class="cardAdd" style="display:
                                      @if (is_null($integraUser->cardNumber))
                                      block
                                      @else
                                      none
                                      @endif
                                      ">
                                    <i class="fa fa-stack-1x fa-plus"></i>
                                </span>
                            </span>
                        </a>
                        @endif
                    </div>
                </td>
                <td style="width:104px;max-width:104px;padding-left:0px;" align="right">
                    <div>
                        @if ($permUserIntegraEdit)
                        <button id="buttonUserLink-{[$integraUser->id]}" type="button" class="btn btn-xs userChangeButton" data-toggle="modal" data-keyboard="true" data-target="#manageUserControl">
                            <i class="fa fa-lg fa-edit"></i>
                        </button>
                        @endif
                        @if($permUserIntegraRemove)
						<button class="btn btn-xs" type="button" data-toggle="modal" data-id="{[ $integraUser->id ]}" data-target="#confirmDelete" title="{[ Lang::get('content.removeUserFromPanel')]}" data-title="{[ Lang::get('content.removeUserFromPanelConfirm').$integraUser->name ]}">
                            <i class="fa fa-lg fa-times"></i>
                        </button>
						@endif
                    </div>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
@section('modalDialogs')
    @if($permUserIntegraCreate)
    @include('integra/user/adduserdialog')
    @endif
    @if($permUserIntegraRemove)
    @include('integra/user/removeuserdialog',['idIntegra'=> $integra->getId()])
    @endif
    @if($permUserIntegraEdit)
    @include('integra/user/carddialog', ['cardList' => $cardList])
    @include('integra/structure/manageuserdialog')
    @endif
@stop
@section('javascripts')
<script src="/js/integra-user.ceefd890.js"></script>
@if($permUserIntegraRemove)
<script src="/js/integra-user-rem.416d83ae.js"></script>
@endif
@if($permUserIntegraCreate||$permUserIntegraEdit)
<script src="/js/integra-user-edt.488eaa18.js"></script>
@endif
@stop