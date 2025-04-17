<a href="/ethm/{[ $id ]}/edit/" class="btn" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.edit') ]}"><i class="fa fa-lg fa-edit"></i></a>
@if($permIntegraRemove && Config::get('parameters.EthmNewServer', false))
{[ Form::open(array('route' => 'ethm.destroy', 'method' => 'post','class'=>'ajax')) ]}
<input name="idEthm" id="idIntegra" type="hidden" value="{[ $id ]}">
<button type="submit" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="{[ Lang::get('content.remove') ]}" ><i class="fa fa-lg fa-times"></i></button>
{[ Form::close() ]}
@endif