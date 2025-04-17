<?php

class Users
{

    private $parameters = array();
    private $userData;

    public function __construct()
    {
        $this->response = new RestClient;
    }

    /**
     * Filtruje liste użytkowników
     * @param array $userFilterNow
     */
    public function filtereduser($userFilterNow)
    {
        $this->setFilter($userFilterNow);
        $key = md5(print_r($this->parameters, 1));
        $this->response->post($this->parameters, 'appuser/search', $key, 20);
        if (!$this->response->result()) {
            return NULL;
        }

        $userList = json_decode($this->response->getContent());
        $objTab   = array();
        foreach ($userList->filteredUserList as $user) {
            $u = new User;

            $u->fill($user, TRUE);
            $objTab[] = $u;
        }
        return $objTab;
    }

    private function setFilter($data)
    {
        $fillable = array('_token', 'message-tree',
            'hierarchyIdx'      => 'hierarchyIdx',
            'surname'          => 'name',
            'email'            => 'email',
            'phone'            => 'phone',
            'status'           => 'status',
            'controlList'      => 'integraIdList',
            'integraPartition' => 'objectId',
            'integraZone'      => 'partitionId',
            'access'           => 'permissionProfileId',
            'withChildren'     => 'withHierarchyChildren');
        foreach ($data as $key => $value) {
            if (isset($fillable[$key]) && !empty($value)) {
                $this->parameters[$fillable[$key]] = $value;
            }
        }
    }

    public function find($filterData, $currRegionIdx)
    {
        $filteredusers = $this->filtereduser($filterData);
        $this->setList($filteredusers, $currRegionIdx);
    }

    private function setList($userData, $currRegionIdx)
    {
        $tab = array();
        foreach ($userData as $user) {
            $tab[] = array(
                'action'    => $this->action($user, UserPermissions::containsForRegion('CREUSER', $currRegionIdx),  UserPermissions::containsForRegion('EDTUSERINTEGRA', $currRegionIdx), UserPermissions::containsForRegion('DELUSER', $currRegionIdx)),
                'id'        => $user->id,
                'name'      => $user->name,
                'email'     => $user->email,
                'telephone' => $user->telephone,
                'status'    => $user->status,
            );
        }
        $this->userData = $tab;
    }

    public function getList()
    {
        return $this->userData;
    }

    private function action($userNow, $permCreate, $permEdit, $permDelete)
    {
        $action = View::make('users.action')
            ->with('user', $userNow)
            ->with('permUserCreate', $permCreate)
            ->with('permUserDelete', $permDelete)
            ->with('permUserIntegraEdit', $permEdit)
            ->render();
        return base64_encode((String) $action);
    }

    /**
     *
     * @param array $findParameters ['name', 'selectedHierarchyId', 'selectedHierarchyQueryIdx']
     * @return void
     */
    public function findByName(array $findParameters)
    {
        $getParameters = array_merge($findParameters,
                ['hierarchyIdx' => UserContext::getUserRegions()]);
        $userData      = $this->filtereduser($getParameters);
        if (!$userData) {
            return array();
        }
        $this->setListByName($findParameters, $userData);
    }

    private function setListByName($findParameters, $userData)
    {
        $name     = $findParameters['name'];
        $queryIdx = $findParameters['selectedHierarchyQueryIdx'];
        $tab      = array();        
        foreach ($userData as $user) {
            if (false !== stripos($queryIdx, $user->queryIdx) && (!$name || false !== stripos($user->name,
                            $name) || false !== stripos($user->surname, $name))) {
                $dispname = strcmp($user->name, $user->surname) == 0 ? str_replace(" ",
                                "&nbsp;", $user->name) : str_replace(" ",
                                "&nbsp;", $user->name) . " " . str_replace(" ",
                                "&nbsp;", $user->surname);
                $tab[]    = array(
                    'id'   => $user->id,
                    'name' => $user->name,
                    'devName' => $user->panelName,
                    'hasCode' => $user->hasCode
                );
            }
        }
        $this->userData = $tab;
    }

}
