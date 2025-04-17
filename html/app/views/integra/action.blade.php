@if($permIntegraManage)
@if(2==$status[6]->status||3==$status[6]->status)
@if(2==$status[7]->status)
<a href="#" data-value="{[ $integra->id ]}" class="btn" data-name="{[ $integra->name ]}" data-toggle="modal" data-target="#controlArm" title="{[ Lang::get('content.arm') ]}"><i class="fa fa-lg fa-lock"></i></a>
@elseif(1==$status[7]->status)
<a href="#" data-value="{[ $integra->id ]}" class="btn" data-name="{[ $integra->name ]}" data-toggle="modal" data-target="#controlDisarm" title="{[ Lang::get('content.disarm') ]}"><i class="fa fa-lg fa-unlock"></i></a>
@else
<a href="#" data-value="{[ $integra->id ]}" class="btn" data-name="{[ $integra->name ]}" data-toggle="modal" data-target="#controlArm" title="{[ Lang::get('content.arm') ]}"><i class="fa fa-lg fa-lock"></i></a>
<a href="#" data-value="{[ $integra->id ]}" class="btn" data-name="{[ $integra->name ]}" data-toggle="modal" data-target="#controlDisarm" title="{[ Lang::get('content.disarm') ]}"><i class="fa fa-lg fa-unlock"></i></a>
@endif
@else
<a href="#" data-value="{[ $integra->id ]}" class="btn" data-name="{[ $integra->name ]}" title="disable" disabled='disabled'><i class="fa fa-lg fa-lock"></i></a>
@endif
@endif

<a href="/control/structure/{[ $integra->id ]}" class="btn" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.edit') ]}"><i class="fa fa-lg fa-edit"></i></a>
@if($permIntegraDelete)
<a href="#" data-value="{[ $integra->id ]}" class="btn" data-name="{[ $integra->name ]}" data-toggle="modal" data-target="#controlDestroy" title="{[ Lang::get('content.remove') ]}">
    <i class="fa fa-lg fa-times"></i>
</a>
@endif
