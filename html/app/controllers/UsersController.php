<?php

class UsersController extends \BaseController
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $access = Permission::accessList();
        $hierarchy = new HierarchyController();
        $currRegion = HierarchyController::getSessionData();
        $data = View::make('users.index')
                ->with('sideRegionVars', $hierarchy->getSideRegionData())
                ->with('navbarVars', $this->navbarVarsDefault())
                ->with('listTitle', Lang::get('content.users'))
                ->with('currentHierarchy', $currRegion)
                ->with('access', $access)
                ->with('helpcnt', 'ekran_uzytkownicy.html');
        $data = $this->message($data);
        if (UserPermissions::containsForRegion('CREUSER', $currRegion->getQueryIdx())) {
            $data = $data->with('addLink', '/users/create/');
        }
        return $data;
    }

    public function show($id)
    {
        return Redirect::to('/users/' . $id . '/edit/');
    }

    public function usersList()
    {
        $data = Input::all();
        if ($data['hierarchyId']==0||$data['hierarchyId']==null){
            $hd = new HierarchyData();
            $data['hierarchyIdx'] = $hd->getAllUserRegions();
        } else {
            $h = new Hierarchy($data['hierarchyId']);
            $data['hierarchyIdx']=[$h->getQueryIdx()];
        }        
        try {
            $users = new Users();
            $users->find($data, $data['hierarchyIdx'][0]);   //TODO correct here
        } catch (\Throwable $exc) {
            error_log("UsersController " . $exc . "\n", 3,
                    Config::get('parameters.pathLogs'));
            throw $exc;
        }
        return Response::json($users->getList());
    }

    public function findByName($name = null)
    {
        try {
            $users          = new Users();
            $findParameters = ['name'                  => $name,
                'selectedHierarchyQueryIdx' => $this->getQueryIdx()];
            $users->findByName($findParameters);
        } catch (Exception $exc) {
            error_log("UsersController " . $exc . "\n", 3,
                    Config::get('parameters.pathLogs'));
            return Response::json([]);
        }
        return Response::json($users->getList());
    }

    public function findByNameNew($name = null)
    {
        try {
            $users          = new Users();
            $findParameters = ['name'                  => $name,
                'status'                    => 4,
                'selectedHierarchyQueryIdx' => $this->getQueryIdx()];
            $users->findByName($findParameters);
        } catch (Exception $exc) {
            error_log("UsersController " . $exc . "\n", 3,
                    Config::get('parameters.pathLogs'));
            return Response::json([]);
        }
        return Response::json($users->getList());
    }

    private function getQueryIdx()
    {
        if (Session::has('integra')) {
            $integra = Session::get('integra');
            return $integra->getQueryIdx();
        }

        $cookieValues = Cookie::get('hierarchy');
        $queryIdx     = ($cookieValues['queryIdx']) ? $cookieValues['queryIdx'] : '1#';
        return $queryIdx;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $hierarchy = new HierarchyController();
        $profile = Permission::profileList(Lang::get('content.profileSelect'));
        $currRegion = HierarchyController::getSessionData();
        $data = View::make('users.create')
                ->with('sideRegionVars', $hierarchy->getSideRegionData())
                ->with('navbarVars', $this->navbarVarsDefault())
                ->with('permUserIntegraCreate', UserPermissions::containsForRegion('CREUSERINTEGRA', $currRegion->getQueryIdx()))
                ->with('permUserEdit', UserPermissions::containsForRegion('EDTUSER', $currRegion->getQueryIdx()))
                ->with('profile', $profile)
                ->with('currentHierarchy', $currRegion)
                ->with('helpcnt', 'dodanie-nowego-uzytkownika.html');
        $data2 = $this->message($data);
        return $data2;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $this->user->fillUser($input);
        if (!$this->user->isValid('create')) {
            return Redirect::back()
                            ->withInput()
                            ->withErrors($this->user->errors());
        }
        $data = json_decode($this->user->save());

        if (1 == $data->result) {
            if (Input::get('create')) {
                return Redirect::route('users.create')
                                ->with('message', 'addappuser');
            } else {
                if (isset($input["integraDefName"])&& strlen($input["integraDefName"])>0) {
                    if (isset($input['integraIdList'])) {
                        return Redirect::to('/users/')->with('message', 'integraAction');
                    } else {
                        return Redirect::to('/users/')->with('message', 'addappuser');
                    }
                } else {
                        return Redirect::to('/users/' . $data->id . '/edit/#user-2')
                                                        ->with('message', 'addappuser');
                }
            }
        } else {
            return Redirect::route('users.index')
                            ->with('message', 'addappuserError')
                            ->with('messageDetail',(isset($data->extraInfo)?Lang::get('integraError.' . $data->extraInfo):"") ." ". $data->message);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        /** Type User  */
        $type = Permission::userTypeList();

        /** Uprawnienia User  */
        $access = Permission::accessList();

        $profile = Permission::profileList(Lang::get('content.profile'));
		
        if ($this->user->find($id)) {
            $hierarchy = new HierarchyController();
            $currRegion = HierarchyController::getSessionData();
            $data = View::make('users.edit')
                            ->with('sideRegionVars', $hierarchy->getSideRegionData())
                            ->with('navbarVars', $this->navbarVarsDefault())
                            ->with('permProfileManage', UserPermissions::containsForRegion('MANPROFILE', $currRegion->getQueryIdx()))
                            ->with('permProfileExcept', UserPermissions::containsForRegion('NOPROFILE', $currRegion->getQueryIdx()))
                            ->with('permUserAppManage', UserPermissions::containsForRegion('MANUSERAPPL', $currRegion->getQueryIdx()))
                            ->with('permUserIntegraSelect', UserPermissions::containsForRegion('SELUSERINTEGRA', $currRegion->getQueryIdx()))
                            ->with('permUserIntegraCreate', UserPermissions::containsForRegion('CREUSERINTEGRA', $currRegion->getQueryIdx()))
                            ->with('permUserIntegraEdit', UserPermissions::containsForRegion('EDTUSERINTEGRA', $currRegion->getQueryIdx()))
                            ->with('permUserIntegraRemove', UserPermissions::containsForRegion('DELUSERINTEGRA', $currRegion->getQueryIdx()))
                            ->with('permUserCreate', UserPermissions::containsForRegion('CREUSER', $currRegion->getQueryIdx()))
                            ->with('permUserEdit', UserPermissions::containsForRegion('EDTUSER', $currRegion->getQueryIdx()))
                            ->with('permUserRemove', UserPermissions::containsForRegion('DELUSER', $currRegion->getQueryIdx()))
                            ->with('currentHierarchy', $currRegion)
                            ->with('type', json_encode($type))
                            ->with('typeDta', $this->userTypeList($type))
                            ->with('user', $this->user)
                            ->with('access', json_encode($access))
                            ->with('accessDta', $access)
                            ->with('profile', $profile)
                            ->with('cardList', '')
                            ->with('hidePanels', !($this->user->attributes()["integraDefName"] || $this->user->attributes()["hasPanels"]))
                            ->with('role', UserApplicationController::roleList())
                            ->with('regions', $hierarchy->treeList())
                            ->with('hierarchyName',$hierarchy->treeGetName($this->user->hierarchyId))
                            ->with('tab', Session::get('tab','user-1'))
                            ->with('helpcnt', 'ekran-z-danymi-uzytkownika.html');
            $data2 = $this->message($data);
            return $data2;
        } else {
            //Wskazany użytkownik nie istnieje w bazie
            return Redirect::route('users.index')->with('message', 'errorAll');
        }
        return $data;
    }

    private function userTypeList($list)
    {
        $selectList = array();
        foreach ($list as $value) {
            $selectList[$value["id"]] = $value["name"];
        }
        return $selectList;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::all();
        if (Input::has("tab")) {
            $tab = Input::get("tab");
            unset($input["tab"]);
        } else {
            $tab = "user-1";
        }
        $this->user->fillUser($input, TRUE);
        if (!$this->user->isValid('update', $id)) {
            return Redirect::back()->withInput()->withErrors($this->user->errors())->with('tab',$tab);
        }
        $this->user->id = $id;
        $dataUpdate     = json_decode($this->user->updateappuser());

        if ($dataUpdate) {
            return Redirect::route('users.edit', array('id' => $id))->with('message',
                            'updateappuser')->with('tab',$tab);
        } else {
            return Redirect::route('users.index')->with('message',
                            'updateappuserError')->with('tab',$tab);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, $withPanels, $CSRF)
    {
        if (Session::token() !== $CSRF) {
            return Redirect::route('users.index')->with('message',
                            'destroyError');
        }
        (int) $id;
        if (!is_int($id)) {
            $id = (int) $id;
        }
		$result = $this->user->setDelete($id, TRUE, $withPanels=== 'true');
		if (!property_exists($result,'result') || 0 == $result->result) {
            return Redirect::route('users.index')->with('message',
                            'destroyError');
        } else {
			if (1 == $result->result) {
				return Redirect::route('users.index')->with('message', 'destroy');
			}
			else {
				return Redirect::route('users.index')->with('message', 'destroyError')->with('messageDetail', $result->message);
			}
				
        }
    }

    /**
     * Przywrócenie skasowanego użytkownika
     *
     * @param int $id
     */
    public function restore($id)
    {
        if (!is_int($id)) {
            $id = (int) $id;
        }
		$result = $this->user->setDelete($id, FALSE, FALSE);
		if (!property_exists($result,'result') || 0 == $result->result) {
            return Redirect::route('users.index')->with('message',
                            'restoreError');
        } else {
			if (1 == $result->result) {
				return Redirect::route('users.index')->with('message', 'restore');
			}
			else {
				return Redirect::route('users.index')->with('message', 'restoreError')->with('messageDetail', $result->message);
			}
				
        }
    }

}
