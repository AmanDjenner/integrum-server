<?php

//Formatka: Użytkownicy >> Centrale/Uprawnienia
class UserIntegraController extends \BaseController
{

    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Redirect::route('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = new User();
        $user->find($id);
        /** Type User  */
        $type = Permission::userTypeList();

        /** Uprawnienia User  */
        $access = Permission::accessList();

		$currRegion = HierarchyController::getSessionData();
		$hierarchy = new HierarchyController();

        return View::make('users.control.edit')
						->with('sideRegionVars', $hierarchy->getSideRegionData())
						->with('navbarVars', $this->navbarVarsDefault())
						->with('currentHierarchy', $currRegion)
                        ->with('type', $type)
                        ->with('access', $access)
                        ->with('user', $user);
    }

    public function permissionUserGet()
    {
        $userPermission = Permission::userGet(Input::get('integraUserId'),
                        Input::get('integraId'), Input::get('objectId'));
        return Response::json($userPermission);
    }

    public function permissionUserPanels($id)
    {
        $userPermission = Permission::userPanels($id);
        return Response::json($userPermission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $up = new UserPanel();
        $up->setDataForm(Input::all());
        return Response::json($up->save());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
