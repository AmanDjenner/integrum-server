{[ Form::open( array(
'route' => 'ethm.filter',
'method' => 'post',
'id' => 'form-filter-setting'
) ) ]}
<input type="hidden" name="hierarchytree" id="hierarchytree" value="hierarchytree"/>
<div class="row">
    {[ Form::label('ethmName', 'Nazwa: ') ]}
    {[ Form::text('ethmName','',['class'=>'form-control']) ]}
</div><div class="row">
    {[ Form::label('ip', ucfirst(Lang::get('content.addressip'))) ]}
    {[ Form::text('ip','',['class'=>'form-control']) ]}
    {[ $errors->first('ip') ]}
</div><div class="row">
    <div class="col-md-6">{[ Form::label('notAssigned','Bez centrali')]}</div>
    <div class="col-md-2">
        {[ Form::checkbox('notAssigned',1, null, [
        'id' => 'notAssigned',
        ]) ]}
    </div>
</div>
<br />
{[ Form::submit('Filtruj',['class'=>'btn btn-primary', 'id'=>'btnFilter', 'disabled' => 'disabled']) ]}
<a href="#" class="btn btn-primary">Wyczyść</a>

{[ Form::close() ]}