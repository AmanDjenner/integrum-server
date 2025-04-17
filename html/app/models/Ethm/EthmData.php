<?php

/**
 * Description of Ethm
 *
 * @author karolsz
 */
class EthmData
{

    private $ethm;
    private $id;
    private $name;
    private $response;
    private $ethmList;
    public static $rules = [
        'create' => [
        'name'      => 'required',
        'macORimei' => array('required_without:address','regex:/^(([0-9A-F]{2}[:]){5}([0-9A-F]{2}))$|^([0-9]{15})$/'),
        'address'   => array('required_without:macORimei', 'regex:/^([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])(\.([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]))*$/i','ExistsIPandPort:address,guardPort'),
        'guardPort' => 'required_with:address|integer|between:1,65535|different:dloadPort|ExistsIPandPort:address,guardPort',
        'dloadPort' => 'integer|between:1,65535|different:guardPort',
        'guardkey'  => 'required|min:1|max:12',
        'dloadkey'  => 'max:12',
        'number'    => 'max:50',
        'idGroup'   => 'required|integer|min:1'
        ],
        'update' => [
        'name'      => 'required',
        'macORimei' => array('required_without:address','regex:/^(([0-9A-F]{2}[:]){5}([0-9A-F]{2}))$|^([0-9]{15})$/'),
        'address'   => array('required_without:macORimei', 'regex:/^([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])(\.([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]))*$/i','ExistsIPandPort:address,guardPort,id'),
        'guardPort' => 'required_with:address|integer|between:1,65535|different:dloadPort|ExistsIPandPort:address,guardPort,id',
        'dloadPort' => 'integer|between:1,65535|different:guardPort',
        'guardkey'  => 'required|min:1|max:12',
        'dloadkey'  => 'max:12',
        'number'    => 'max:50',
        'idGroup'   => 'required|integer|min:1'
		]
		];

    public function __construct()
    {
        $this->response = new RestClient();
    }

    public function ethmList()
    {
        $table        = 'ethmlist';
        $cacheTime    = 20;
        $curlPostData = array();
        $this->response->post($curlPostData, $table, $table, $cacheTime);
        $ethmList     = json_decode($this->response->getContent());
        if (isset($ethmList->integraEthm)) {
            $this->ethmList = $ethmList->integraEthm;
            return TRUE;
        }
        return NULL;
    }

    /**
     *
     * @param array $EthmNow // id name obecnie przypisanego ETHM do centrali
     * @return array
     */
    public function ethmListTab($EthmNow)
    {
        $ethmListTab = array();
        $this->ethmList();
        if (!is_array($this->ethmList)) {
            return array();
        }

        if (isset($EthmNow['id'])) {
            $ethmListTab[$EthmNow['id']] = $EthmNow['nameEthm'];
        }
        foreach ($this->ethmList as $ethm) {
            if (isset($ethm->name)) {
                $ethmListTab[$ethm->id] = $ethm->name;
            }
        }
        return $ethmListTab;
    }

	public function existIPandPort($ip, $guardPort, $thisid) {
		$param["hierarchytreeid"] = 1;
		if (null==$ip) {
			return false;
		}
		$param["integraEthmIP"] = $ip;
        $filteredEthm   = $this->filteredInternal($param,'ethm/isaddressandportexists');
		$result = $filteredEthm->ethmList;
		if (isset($result)) {
            foreach ($result as $items) {
                $integraEthm = $items->integraEthm;				
				if ($guardPort == $integraEthm->guardPort && $thisid != $integraEthm->id) {
					return true;
				}
			}
        }
		return false;
	}
	
    public function filtered($param, $currRegion)
    {
        $filteredEthm   = $this->filteredInternal($param);
        if (isset($filteredEthm->ethmList)) {
            $ethmList = $this->jsonList($filteredEthm->ethmList, $currRegion);
            return $ethmList;
        }
    }
	
    public function filteredInternal($param, $table= 'ethm/filtered')
    {
        $param['limit'] = Config::get('parameters.eventLimit') + 1;
		$filterParam    = $this->filterParam($param);
        $cacheTime      = 0;
        $this->response->post($filterParam, $table, $table, $cacheTime);
        return json_decode($this->response->getContent());
    }

    /** [restSchemaIn] => {
     * "hierarchytreeid" :{"type": "Integer"},
     * "withHierarchyChildren" :{"type": "Boolean"},
     * "integraEthmName" :{"type": "String"},
     * "integraEthmIP" :{"type": "String"},
     * "notAssigned" :{"type": "Boolean"},
     * "offset" :{"type": "Integer"},
     * "limit" :{"type": "Integer"}}
     */
    private function filterParam($param)
    {
        unset($param['_token']);
        $filterParam = array();
        foreach ($param as $key => $value) {
            if ($value) {
                $filterParam[$key] = $value;
            }
        }
        $filterParam['offset'] = 0;
        //ToDo: Dodać stronicowanie
        return $filterParam;
    }

    private function jsonList($ethmList, $currRegion)
    {
        $tab = array();
        foreach ($ethmList as $items) {
            $integraEthm = $items->integraEthm;
            $integra     = $items->integra;
            $tab[]       = array('action'    => $this->action($integraEthm->id
                    , UserPermissions::containsForRegion('DELINTEGRA', $currRegion)),
                'name'      => $integraEthm->name,
                'ip'        => $integraEthm->address,
                'guardPort' => $integraEthm->guardPort,
                'dloadPort' => $integraEthm->dloadPort,
                'version'   => $integraEthm->version,
                'macORimei' => $integraEthm->macORimei,
                'license'   => $integraEthm->license,
                'id'        => $integraEthm->id,
                'integra'   => $integra->name,
                'integraId' => $integra->id,
            );
        }
        return $tab;
    }

    private function action($id, $permRemove)
    {
        $action = View::make('integra.ethm.action')->with('id', $id)->with('permIntegraRemove',
                $permRemove);
        return (String) $action;
    }

    public function find($id)
    {
        $table       = 'ethm/' . $id;
        $cacheTime   = 0;
        $this->response->get($table, $table, $cacheTime);
        $integraEthm = json_decode($this->response->getContent());
        if (isset($integraEthm->integraEthm)) {
            $ethm = new Ethm();
            $ethm->setId($id);
            $ethm->setEthm($integraEthm->integraEthm);
            $ethm->setEthmState($integraEthm->integraEthmState);
            return $ethm;
        }
        return NULL;
    }

    public function delete($idEthm)
    {
        $this->cleanCache();
        $response = $this->remove($idEthm);
        if (1 == $response->result) {
            $result['status']   = TRUE;
            $result['cssClass'] = "deleteintegra";
            $result['message']  = "deleteethm OK!";
        } else {
            $result['message'] = "NONO!";
            $result['status']  = FALSE;
        }
        return $result;
    }

    private function remove($table, $idEthm)
    {
		$table = 'ethm/' . $idEthm;
        $restClient  = new RestClient();
        $restClient->remove($table, $table, 0);
        $response    = json_decode($restClient->getContent());
        return $response;
    }

    /**
     *
     * @param Array $input
     */
    public function fill($input)
    {
        $object     = "object";
        $this->ethm = new Ethm();
        if (is_array($input)) {
            $object = json_decode(json_encode($input), FALSE); // zamian na object(stdClass)
            $this->ethm->setEthm($object);
        }
    }

    public function save()
    {
		$table = 'ethm';
        $this->cleanCache();
        $curlPostDat['integraEthm'] = $this->ethm->getData();
        $restClient                 = new RestClient();
        $restClient->put($curlPostDat, $table, $table, 0);
        return json_decode($restClient->getContent());
    }

    public function update()
    {
		$table = 'ethm/' . $this->ethm->getId();
        $this->cleanCache();
        $curlPostDat['integraEthm'] = $this->ethm->getData();
        $restClient                 = new RestClient();
        $restClient->post($curlPostDat, $table, $table, 0);
        return json_decode($restClient->getContent());
    }
	
    public function isValid($mode)
    {
        $validation = Validator::make($this->ethm->getData(), static::$rules[$mode]);

        if ($validation->passes()) {
            return true;
        }
        $this->errors = $validation->messages();
        return false;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function cleanCache()
    {
        if (!(App::environment(Config::get('parameters.localPort'))||!Config::get('parameters.useCache',true))) {
            Cache::forget('ethmlist');
        }
    }

}
