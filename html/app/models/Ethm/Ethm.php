<?php

/**
 * Description of Ethm
 *
 * @author karolsz
 */
class Ethm
{

    private $id;
    private $idIntegra;
    private $name;
    private $address;
    private $dloadPort;
    private $guardPort;
    private $dloadkey;
    private $guardkey;
    private $number;
    private $idGroup;
    private $state;
    private $macORimei;
    private $version;
    private $license;
    private $deviceType;

    /** Obiekt ETHM */
    public function setEthm($integraEthm)
    {
        if (isset($integraEthm->id)) {
            $this->setId($integraEthm->id);
        }
        if (isset($integraEthm->idIntegra)) {
            $this->idIntegra = $integraEthm->idIntegra;
        }
        if (isset($integraEthm->name)) {
            $this->name = $integraEthm->name;
        }
        if (isset($integraEthm->address)) {
            $this->address = $integraEthm->address;
        }
        if (isset($integraEthm->guardPort)) {
            $this->guardPort = $integraEthm->guardPort;
        }
        if (isset($integraEthm->dloadPort)) {
            $this->dloadPort = $integraEthm->dloadPort;
        }
        if (isset($integraEthm->dloadkey)) {
            $this->dloadkey = $integraEthm->dloadkey;
        }
        if (isset($integraEthm->guardkey)) {
            $this->guardkey = $integraEthm->guardkey;
        }
        if (isset($integraEthm->number)) {
            $this->number = $integraEthm->number;
        }
        if (isset($integraEthm->idGroup)) {
            $this->idGroup = $integraEthm->idGroup;
        }
        if (isset($integraEthm->version)) {
            $this->version = $integraEthm->version;
        }
        if (isset($integraEthm->macORimei)) {
            $this->macORimei = $integraEthm->macORimei;
        }
        if (isset($integraEthm->deviceType)) {
            $this->deviceType = $integraEthm->deviceType;
        }
        if (isset($integraEthm->license)) {
            $this->license = $integraEthm->license;
        }
    }

    public function setEthmState($integraEthmState)
    {
        /**  [version] =>
         *   [versionDate] =>
         *   [versionNotsupported] =>
         */
        if (isset($integraEthmState)) {
            $this->state = $integraEthmState;
        }
    }

    /**
     *
     * @param int $id
     */
    public function setId($id)
    {
        if (isset($id)) {
            $this->id = (int) $id;
        }
    }

    /**
     *
     * @return Integer
     */
    function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return String
     */
    function getName()
    {
        return $this->name;
    }

    /**
     * od 1 do 12 znaków
     * @return String
     */
    function getDloadkey()
    {
        return $this->dloadkey;
    }

    /**
     * od 1 do 12 znaków
     * @return String
     */
    function getGuardkey()
    {
        return $this->guardkey;
    }

    /**
     *
     * @return String
     */
    function getAddress()
    {
        return $this->address;
    }

    /**
     *
     * @return String
     */
    function getMacORimei()
    {
        return $this->macORimei;
    }

    /**
     *
     * @return Integer
     */
    function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     *
     * @return Integer
     */
    function getPort()
    {
        return $this->port;
    }

    /**
     * od 1 do 10
     * @return Integer
     */
    function getNumber()
    {
        return $this->number;
    }

    /**
     *
     * @return Integer
     */
    function getIdGroup()
    {
        return $this->idGroup;
    }

    /**
     *
     * @return array
     */
    function getState()
    {
        return $this->state;
    }

    /**
     * Przygotowuje Tablice dla konwersji na JSONa
     * @return Array
     */
    public function getData()
    {
        $var = get_object_vars($this);
        foreach ($var as $key => &$value) {
            if (is_object($value) && method_exists($value, 'getData')) {
                $value = $value->getData();
            }
            if (!isset($value)) {
                unset($var[$key]);
            }
        }
        return $var;
    }

}
