<?php

/*
 * Centrale / Hierarchia.
 */

class HierarchyController extends BaseController
{

    public function index()
    {
        $region = [];
        if (Session::has('idHierarchy')) {
            $idHierarchy = Session::get('idHierarchy');
            $region      = new Hierarchy($idHierarchy);
        }
		$currRegion = HierarchyController::getSessionData();
        $view = View::make('hierarchy.edit')
                        ->with('sideRegionVars', $this->getSideRegionData())
                        ->with('helpcnt','ekran-ustawienia-regionu.html')
                        ->with('navbarVars', $this->navbarVarsDefault())
                        ->with('permManRegion', UserPermissions::containsForRegion('MANREGION', $currRegion->getQueryIdx()))
                        ->with('hierarchyOn', HierarchyData::withChildren())
                        ->with('currentHierarchy', $currRegion)
                        ->with('tree', $this->tree())
                        ->with('dataHierarchy', json_encode($region));
        return $this->message($view);
    }

    public function store()
    {
        if (!Input::has('name')) {
            return Redirect::back()->with('message', 'badName');
        }

        $input = Input::only('parentNew', 'name');
        try {
            $region = new Hierarchy();
            $region->setName($input['name']);
            $region->setParentId($input['parentNew']);
            $result = $region->save();
            if (1 == $result->result) {
                return Redirect::to('hierarchy')
                                ->with('message', 'action')
                                ->with('idHierarchy', $result->id);
            }
        } catch (Exception $exc) {
            return Redirect::back()->with('message', $exc->getMessage());
        }
        return Redirect::back()->with('message', 'errorAction');
    }

    public function destroy()
    {
        if (!Input::has('id-remove')) {
            return Redirect::back()
                            ->with('message', 'O nie!.');
        }
        $id = Input::get('id-remove');
        try {
            $region = new Hierarchy($id);
            $result = $region->del();
            if (1 != $result->result) {
                return Redirect::back()->with('message', 'hierarchyErrordeletehierarchyAction');
            }
            $response = Redirect::to('hierarchy')
                    ->with('message', 'action')
                    ->with('idHierarchy', $region->getParentId());
            if ($this->checkSettingCookies($region)) {
                $newRegion    = new Hierarchy($region->getParentId());
                $cookieValues = array('id'       => $newRegion->getId(), 'name'     => $newRegion->getName(),
                    'queryIdx' => $newRegion->getQueryIdx());
                $cookie       = Cookie::forever('hierarchy', $cookieValues);
                $response->headers->setCookie($cookie);
            }
            return $response;
        } catch (Exception $exc) {
			return Redirect::back()->with('message', $exc->getMessage());
        }
    }

    /**
     * Zmiana nazwy
     * edithierarchy
     * @param int $id
     * @return type
     */
    public function update()
    {
        $input = Input::only('hierarchyId', 'parentId', 'name');
        try {
            $region = new Hierarchy($input['hierarchyId']);
            $region->setName($input['name']);
            $region->setParentId($input['parentId']);
            $result = $region->save();
            if (1 == $result->result) {
                return Redirect::to('hierarchy')
                                ->with('message', 'action');
            }
        } catch (Exception $exc) {
            return Redirect::back()->with('message', $exc->getMessage());
        }
        return Redirect::back()->with('message', 'errorAction');
    }

    /**
     * sprawdza czy obecny region jest taki sam co usuniety
     * @param Hierarchy $oldRegion
     */
    private function checkSettingCookies(Hierarchy $oldRegion)
    {
        if (Cookie::has('hierarchy')) {
            $cookieValues = Cookie::get('hierarchy');
            $id           = $cookieValues['id'];
            if ($id == $oldRegion->getId()) {
                return true;
            }
        }
        return false;
    }

    public static function putSession($id)
    {
        try {
            $region       = new Hierarchy($id);
            $cookieValues = ['id'       => $region->getId(), 'name'     => $region->getName(),
                'queryIdx' => $region->getQueryIdx()];
        } catch (Exception $ex) {
            return Response::json(['message' => $ex->getMessage()]);
        }
        $cookie   = Cookie::forever('hierarchy', $cookieValues);
        $response = Response::json($cookieValues);
        $response->headers->setCookie($cookie);
        return $response;
    }


    public static function checkSession($id)
    {
		$region       = new Hierarchy($id);
		$cookieValues = ['id'       => $region->getId(), 'name'     => $region->getName(),
			'queryIdx' => $region->getQueryIdx()];
        $cookie   = Cookie::queue('hierarchy', $cookieValues, 2628000);

        return $region;
    }

    public function getSession()
    {
        try {
	    	return Response::json(HierarchyController::getSessionData());
        } catch (Exception $ex) {
            return Response::json(['message' => $ex->getMessage()]);
        }
	}
	
    public static function getSessionData()
    {
        $id = 0;
        if (Cookie::get('hierarchy')) {
            $cookieValues = Cookie::get('hierarchy');
            $id           = $cookieValues['id'];
        }
        try {
            $region = new Hierarchy($id);
        } catch (Exception $ex) {
            return HierarchyController::checkSession(UserContext::getDefaultRegion());
        }
        return $region;
    }

	public function getSideRegionData()
	{
            return ['permManRegion' => UserPermissions::containsForRegion('MANREGION', static::getSessionData()->getQueryIdx())
                ,'tree'=> $this->tree()
                ,'hierarchyOn'=>HierarchyData::withChildren()
                ,'currentHierarchy'=>HierarchyController::getSessionData()
                ];
	}

    public function json()
    {
		$qry = UserContext::getUserRegions();
        if (!$qry) {
            return Response::json(NULL);
        }
        $t = new HierarchyData();
        $response = $t->getTree();
        return Response::json($response);
    }


    public function treeList() {
        $t = new HierarchyData();
        $response = [];
        $tree = $t->getTree();
        return $this->treeListInt($response, $tree,'');
    }
    private function treeListInt($arr, $tree, $intendent) {
        $arr[$tree->id] = $intendent . $tree->name;
        $i = $intendent . '&nbsp;';
        if (isset($tree->hierarchyTreeList)) {
            foreach($tree->hierarchyTreeList as $val) {
                $arr = $this->treeListInt($arr, $val, $i);
            }
        }
        return $arr;
    }
    
    private function tree()
    {
        try {
            $t = new HierarchyData();
            $response = $t->getTreeDisplay();
        } catch (Exception $exc) {
            error_log("HierarchyController " . $exc . "\n", 3,
                    Config::get('parameters.pathLogs'));
            return Redirect::route('session.logout')
                            ->with('message', Lang::get('content.disconnected').'<br>'.$exc->getMessage());
        }
        return View::make('hierarchy.menu')->with('hierarchyTreeList', $response);
    }

    public function treeGetName($hierarchyId)
    {
		$t = new HierarchyData();
		return $t->getName($hierarchyId);
    }
	
    public function putChildren($status)
    {
        Cookie::queue('withChildren', $status, 60 * 24 * 30);
    }

    public function getChildren()
    {
        return Response::json(HierarchyData::withChildren());
    }

}
