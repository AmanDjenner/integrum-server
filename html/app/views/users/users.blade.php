<!-- RIGHT PANEL -->
<div class="row">
    <table class="table table-striped">
        <tbody>
            <tr><th>Akcje</th><th>Imie Nazwisko</th><th>e-mail</th><th>telefon</th><th>status</th></tr>
            @foreach ($users as $user)
            <tr>
                <td>
                    @if(3==$user->status)
                    {[ HTML::link('/users/'.$user->id.'/restore/', 'Restore',['class'=>'btn btn-primary btn-xs']) ]} 
                    @else 
                    {[ HTML::link('/users/'.$user->id.'/edit/', 'Edit',['class'=>'btn btn-primary btn-xs']) ]} 
                    {[ HTML::link('/users/'.$user->id.'/destroy/', 'Delete',['class'=>'btn btn-danger btn-xs']) ]} 
                    {[ HTML::link('/usercontrol/'.$user->id, 'Centrale',['class'=>'btn btn-info btn-xs']) ]}
                    @endif       
                </td>
                <td> ({[ $user->id ]}) {[ $user->name ]} {[ $user->surname ]} </td>
                <td> {[ $user->email ]} </td>
                <td> {[ $user->telephone ]} </td>
                <td> {[ $user->statusName() ]} </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>