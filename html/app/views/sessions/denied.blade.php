@extends('layouts.sessions', ['title' => Lang::get('content.denied')])
@section('content')
<input type="hidden" id="help-content-link" value="/help/{[$helpcnt or 'wprowadzenie.html']}"/>
@include('layouts/navbar',$navbarVars)
<div class="login-vertical-align">
    <div class="loginbox">
<table width="100%">
<tbody style="background:rgba(1,1,1,0)">
<tr>
<td align="center"><i style="color:red" class="fa fa-2x fa-ban"></i> {[Lang::get('content.denied')]}: 
@foreach (Session::get('privs_required',[]) as $perm)
 {[Lang::get('permissions.'.$perm)]}
@endforeach
</td>
</tr>
</tbody>
</table>
</div>
</div>
<div class="alert alert-warning" role="alert">
@foreach (UserPermissions::getPermissions() as $perm)
 {[Lang::get('permissions.'.$perm)]},
@endforeach
</div>
@include('help/sidewindow')
<script src="/js/vendor.7884c6a6.js"></script>
@include('help/welcomedialog')
@stop
	