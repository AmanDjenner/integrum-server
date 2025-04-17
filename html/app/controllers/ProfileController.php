<?php

class ProfileController extends \BaseController
{

    public function index()
    {

        /** Uprawnienia User  */
        $access = Permission::accessList();

        $profile = Permission::profileList(NULL);
		
        $hierarchy = new HierarchyController();
		$currRegion = HierarchyController::getSessionData();
		$data = View::make('profile.index')
				->with('navbarVars', $this->navbarVarsDefault(false, false))
				->with('type', $this->userTypeList())
				->with('access', $access)
				->with('profile', $profile)
				->with('hidePanels',FALSE)
				->with('role', UserApplicationController::roleList())
                ->with('helpcnt', 'ekran-szablony-uzytkownikow.html');
		return $this->message($data);
    }
    
    public function profileList() {
        $profile = Permission::profileList(Lang::get("content.profile"));
        return Response::json($profile);
    }

    private function userTypeList()
    {
        $list       = Permission::userTypeList();
        $selectList = array();
        foreach ($list as $value) {
            $selectList[$value["id"]] = $value["name"];
        }
        return $selectList;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function json()
    {
        $profile  = new ProfileAccess();
        $response = $profile->index();
        return Response::json($response);
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
        $response = [];

        $profile = new ProfileAccess();
        if ($profile->fill(Input::all())) {
            $save = $profile->save();
            if ($save['result']) {
                $response['save']    = 'OK';
                $response['message'] = BaseController::getMessageText('profileSaved');
            } else {
                $response['save']    = NULL;
                $response['message'] = BaseController::getMessageText('errorAll');
            }
        } else {
            $response['save'] = NULL;
            $response       = BaseController::getMessage('badName');
        }

        return Response::json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $profile  = new ProfileAccess();
        $response = $profile->show($id);
        return Response::json($response);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy()
    {
        $response[] = 'Delete';

        $profile = new ProfileAccess();
		$save = $profile->remove(Input::all()['id']);
		if ($save['result']) {
			$response['save']    = 'OK';
			$response['message'] = BaseController::getMessageText('profileRemoved');
		} else {
			$response['save']    = NULL;
			$response['message'] = BaseController::getMessageText('errorAll');
		}

        return Response::json($response);
    }
}