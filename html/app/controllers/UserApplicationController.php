<?php

class UserApplicationController extends \BaseController
{

    protected $userApp;
    protected $user;

    public function __construct(UserApp $userApp)
    {
        //$this->auth = new AuthRest();
        $this->userApp = $userApp;
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
        return Redirect::route('users.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        return Redirect::route('users.index');
    }

    /**
     * Zwraca formlarz Edycji lub Create.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return Redirect::route('users.index');
    }

    static public function roleList()
    {
        $data = Permission::appUserRoleList();
        foreach ($data as $value) {
            $role[$value['id']] = $value['name'];
        }
        return $role;
    }

    private function transformAccessRightsData($ret) {
		$keys = array_keys($ret);
		$grpCount = 0;
		foreach($keys as $key){
			if (strpos($key, 'roles') === 0){
				$idx = intval(substr($key,5));
				$grpCount = $idx>$grpCount?$idx:$grpCount;
			}
		}
        $ret['roles'] = [];
		$ret['regions'] =[];
		$arrIdx =0;
		for ($i = 0; $i <= $grpCount; $i++) {
			if (isset($ret['roles' . $i]) && count($ret['roles' . $i])>0 && 
			  isset($ret['regions' . $i]) && count($ret['regions' . $i])>0) {
				$ret['roles'][$arrIdx] = $ret['roles' . $i];
				$ret['regions'][$arrIdx++] = $ret['regions' . $i];
			}
			if(isset($ret['roles' . $i])) unset($ret['roles' . $i]);
			if(isset($ret['regions' . $i])) unset($ret['regions' . $i]);        
		}
        return $ret;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input       = $this->transformAccessRightsData(Input::all());
        $input['id'] = $id;
        $user = new User();
        $user->find($id);
        try {
            $this->userApp->fillApp($input);
            $action    = 'create';
            $userModel = new User();
            $userModel->find($id);
            if (null !== $userModel->__get('login')) {
                $action = 'update';
            }
            if (!$this->userApp->isValid($action)) {
                return Redirect::to(URL::previous())
                                ->with('user', $user)
                                ->with('tab','user-2')
                                ->withErrors($this->userApp->errors());
            }
            $update = json_decode($this->userApp->update());
        } catch (Exception $exc) {
            error_log("UserApplicationController " . $exc . "\n", 3,
                    Config::get('parameters.pathLogs'));
            return Redirect::route('session.logout')
                            ->with('message', Lang::get('content.disconnected').'<br>'.$exc->getMessage());
        }

        if (1 != $update) {
            return Redirect::to('users/'.$id.'/edit')
                    ->with('tab','user-2')
                    ->with('message','updateAppError');
        } else {
            return Redirect::to('users/'.$id.'/edit')
                    ->with('tab','user-2')
                    ->with('message','updateApp');
        }
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
