<?php

class Integra
{

    private $id;
    private $name;
    private $serviceCode;
    private $intergrid;
    private $dloadid;
    private $guardid;
    private $idGroup;
    private $version;
    private $type;
    private $mapId;
    private $integraState;
    private $integraEthm;
    private $queryIdx;
    private $active;
    private $showCards;
    private $statusCode;

    /**
     * @return Integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getShowCards()
    {
        return $this->showCards;
    }

    public function getStatusDesc()
    {
		if ($this->active) {
        return Lang::get('integraStates.statusDesc-' . $this->statusCode);
		}
		else {
			return Lang::get('integraStates.statusDesc--10');
		}
    }

    /**
      }
     *
     * @return String
     */
    function getQueryIdx()
    {
        return $this->queryIdx;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return String
     */
    public function setName($value)
    {
        $this->name = $value;
    }

    /**
     * @return Integer
     */
    public function getServiceCode()
    {
        return $this->serviceCode;
    }

    /**
     * @return String
     */
    public function getIntergrid()
    {
        return $this->intergrid;
    }

    /**
     * @return String
     */
    public function getDloadid()
    {
        return $this->dloadid;
    }

    /**
     * @return String
     */
    public function getGuardid()
    {
        return $this->guardid;
    }

    /**
     * @return Integer
     */
    public function getIdGroup()
    {
        return $this->idGroup;
    }

    /**
     * @return Integer
     */
    public function setIdGroup($value)
    {
        $this->idGroup = $value;
    }

    /**
     *
     * @return String:"1.12 2013-11-29"
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     *
     * @return String:"1.12 2013-11-29"
     */
    public function setVersion($value)
    {
        $this->version = $value;
    }

    /**
     * @return string:"Integra 128",
     */
    public function getType()
    {
        return $this->type;
    }

    public function setType($value)
    {
        $this->type = $value;
    }

    /**
     * @return array
     */
    public function getIntegraState()
    {
        return $this->integraState;
    }

    /**
     * @return Integer
     */
    public function getMapId()
    {
        return $this->mapId;
    }

    /**
     *
     * @param  Integer $integraEthm
     */
    public function setIntegraEthm($integraEthm)
    {
        $this->integraEthm['id'] = $integraEthm;
    }

    /**
     *
     * @return Integer
     */
    public function getIntegraEthm()
    {
        return $this->integraEthm;
    }

    /**
     *
     * @return Integer
     */
    public function getIntegraEthmId()
    {
        return $this->integraEthm['id'];
    }

    public function setId($id)
    {
        if (isset($id)) {
            $this->id = (int) $id;
        }
    }

    public function setIntegra($integra)
    {
        $integraObj        = $integra->integra;
        $this->id          = $integraObj->id;
        $this->name        = $integraObj->name;
        $this->serviceCode = $integraObj->serviceCode;
        $this->intergrid   = $integraObj->intergrid;
        $this->dloadid     = $integraObj->dloadid;
        $this->guardid     = $integraObj->guardid;
        $this->idGroup     = $integraObj->idGroup;
        $this->version     = $integraObj->version;
        $this->type        = $integraObj->integraType;
        $this->queryIdx    = $integraObj->queryIdx;
        $this->active      = $integraObj->active;
        $this->showCards   = $integraObj->showCards;
        $this->statusCode  = $integraObj->statusCode;
        $this->setIntegraState($integraObj->integraState);
        if (isset($integraObj->mapId)) {
            $this->mapId = $integraObj->mapId;
        }
        $this->integraEthm['id']       = $integraObj->integraEthm->id;
        $this->integraEthm['nameEthm'] = $integraObj->integraEthm->name;
    }

    public function setInputIntegra($input)
    {
        if (isset($input['id'])) {
            $this->id = (int) $input['id'];
        }
        if (isset($input['name'])) {
            $this->name = $input['name'];
        }
        if (isset($input['serviceCode'])) {
            $this->serviceCode = $input['serviceCode'];
        }
        if (isset($input['intergrid'])) {
            $this->intergrid = $input['intergrid'];
        }
        if (isset($input['dloadid'])) {
            $this->dloadid = $input['dloadid'];
        }
        if (isset($input['guardid'])) {
            $this->guardid = $input['guardid'];
        }
        if (isset($input['idGroup'])) {
            $this->idGroup = (int) $input['idGroup'];
        }
        if (isset($input['version'])) {
            $this->version = (double) $input['version'];
        }
        if (isset($input['active'])) {
            $this->active = (bool) $input['active'];
        } else {
            $this->active = FALSE;
        }
        if (isset($input['ethm'])) {
            $this->integraEthm['id'] = (int) $input['ethm'];
        }
        unset($this->queryIdx);
        unset($this->showCards);
        unset($this->statusCode);
    }

    /**
     * "integraState":[{"id":1,"status":3},{"id":2,"status":3},{"id":3,"status":2},{"id":4,"status":2},{"id":5,"status":2},{"id":6,"status":2},{"id":7,"status":2}]
      "[{"id":1,"status":3},{"id":2,"status":3},{"id":3,"status":2},{"id":4,"status":2},{"id":5,"status":null},{"id":6,"status":null},{"id":7,"status":"1"},{"id":8,"status":2}]"
     *
     * @param type $integraState
     */
    public function setIntegraState($integraState)
    {
        if (isset($integraState[6])) {
            if (2 == $integraState[6]->status||3 == $integraState[6]->status) {
                $this->integraState['online'] = 1;
            } else {
                $this->integraState['online'] = 0;
            }
            $this->integraState['state']  = $integraState;
            $this->integraState['action'] = $integraState[7]->status;
        }
    }

    /**
     * Przygotowuje Tablice dla konwersji na JSONa
     * @return Array
     */
    public function getData()
    {
        unset($this->queryIdx);
        $var = get_object_vars($this);
        foreach ($var as &$value) {
            if (is_object($value) && method_exists($value, 'getData')) {
                $value = $value->getData();
            }
        }
        return $var;
    }

    /**
     * Przygotowuje Tablice dla wyświetlenia w Formularzu
     * @return Array
     */
    public function getDataForm()
    {
        $var           = $this->getData();
        $var['ethm']   = $var['integraEthm']['id'];
        unset($var['integraState']);
        unset($var['integraEthm']);
        return $var;
    }

}
