@if(1==$user->status[0]->status)
@if($permUserDelete||$permUserCreate)
<a class="btn" href="/users/{[ $user->id ]}/restore/" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.restore') ]}">
    <i class="far fa-lg fa-share-square"></i>
</a>
@endif
@else
<a class="btn" href="/users/{[ $user->id ]}/edit/" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.edit') ]}">
    <i class="fa fa-lg fa-edit"></i>
</a>
@if($permUserIntegraEdit)
<a class="btn" href="/users/{[ $user->id ]}/edit/#user-3" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.panel') ]}">
    <i class="fa fa-lg fa-calculator"></i>
</a>
@endif
@if($permUserDelete)
<a class="btn" href="#" data-value="/users/{[ $user->id ]}/destroy/__wp__/{[ csrf_token() ]}" data-name="{[ $user->name ]}" data-toggle="modal" data-target="#confirm-delete" title="{[ Lang::get('content.archiveUser') ]}">
    <i class="fa fa-lg fa-times"></i>
</a>
@endif
@endif
