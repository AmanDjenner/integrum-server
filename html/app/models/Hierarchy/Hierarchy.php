<?php

class Hierarchy implements JsonSerializable
{
    private $content;
    private $id;
    private $name;
    private $queryIdx;
    private $parentId;

    public function __construct($id = null)
    {
        if (isset($id)) {
            $this->id = (int) $id;
            $this->setAttribute();
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPermissionsInfo(){
        return array_search("XDEBUG_SESSION", array_keys(Cookie::get()))>-1
                ? (" " . HierarchyController::getSessionData()->getQueryIdx() . " => " . implode(UserPermissions::getPermissionsForRegion(HierarchyController::getSessionData()->getQueryIdx()),', '))
                : "";
    }

    public function getQueryIdx()
    {
        return $this->queryIdx;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    function setName($name)
    {
        if (isset($name) && $name) {
            $this->name = $name;
            return;
        }
        throw new Exception('badName');
    }

    function setParentId($parentId)
    {
        if (isset($parentId) && $parentId) {
            $this->parentId = (int) $parentId;
            return;
        }
        throw new Exception('ParentId empty!');
    }

    private function setAttribute()
    {
        $hd = new HierarchyData();
        $data = $hd->getData();
        if (isset($data[$this->id])) {
            $this->name     = $data[$this->id]['name'];
            $this->queryIdx = $data[$this->id]['queryIdx'];
            $this->parentId = $data[$this->id]['parentId'];
            return;
        }
        throw new Exception('findOrFail');
    }

    //Zadrzenia
    protected function add()
    {
        $curlPostDat = array('hierarchy' => array(
            "idParent" => $this->parentId,
            "name" => $this->name
        ));
        $restClient  = new RestClient();
        $restClient->put($curlPostDat, 'hierarchy', 'hierarchy', 0);

        return $this->handleResponse($restClient, 'add', $curlPostDat);
    }

    protected function update()
    {
        $curlPostDat = array('hierarchy' => array(
            "hierarchyId" => $this->id,
            "parentId" => $this->parentId,
            "name" => $this->name
        ));
        $restClient  = new RestClient();
        $restClient->post($curlPostDat, 'hierarchy/'. $this->id, 'hierarchy/'. $this->id, 0);

        return $this->handleResponse($restClient, 'update', $curlPostDat);
    }

    public function save()
    {
        if ($this->id) {
            return $this->update();
        } else {
            return $this->add();
        }
    }

    public function del()
    {
        $restClient  = new RestClient();
        $restClient->remove('hierarchy/'. $this->id, 'hierarchy/'. $this->id, 0);

        return $this->handleResponse($restClient, 'delete', []);
    }

    public function handleResponse($restClient, $table, $curlPostDat)
    {
        $response    = json_decode($restClient->getContent());
        if (!isset($response->result) || 1 != $response->result) {
            error_log("Hierarchy: action: ".$table."\n* post: ".print_r($curlPostDat,
                    1)."\n* message: ".print_r($response, 1)."\n", 3,
                Config::get('parameters.pathLogs'));
            throw new Exception('hierarchyError'.$table.'Action');
        }
        $id = UserContext::getUserRegions();
        $restClient->clean('hierarchy'.$this->id);
        return $response;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $var = get_object_vars($this);
        foreach ($var as $key => &$value) {
            if (is_object($value) && method_exists($value, 'toArray')) {
                $value = $value->getData();
            }
            if (!isset($value)) {
                unset($var[$key]);
            }
        }
        return $var;
    }
}
