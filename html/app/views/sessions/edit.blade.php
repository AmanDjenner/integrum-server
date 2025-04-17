@extends('layouts.default', ['sideRegionVars'=>$sideRegionVars, 'navbarVars'=>$navbarVars, 'titleDetail' => 'Zmiana hasła'])

@section('content')
<div class="loginbox">
    <h1>Zmiana hasła </h1>
    <br />
    {[ Form::model('', ['method' => 'PATCH', 'route' => ['sessions.update', $id]]) ]}
    <div>
        {[ Form::label('password', 'nowe hasło: ') ]}
        {[ Form::password('password') ]}
        {[ $errors->first('password') ]}
    </div>
    <div>
        {[ Form::label('password2', 'powtórz: ') ]}
        {[ Form::password('password2') ]}
    </div>
    <div>{[ Form::submit('Zapisz') ]}</div>
    {[ Form::close() ]}
</div>
@stop