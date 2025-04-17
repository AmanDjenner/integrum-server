<?php

class UserPanel
{
    private $userId;
    private $integraId;
    private $integraUserId;
    private $objectId;
    private $userType;
    private $userCnt;
    private $userSchema;
    private $name;
    private $code;
    private $profileId;
    private $partitionList = array();
    private $accessList    = array();

    /**
     * Zwraca Listę central do których
     * użytkownik ma jakie kolwiek uprawnienia
     *
     * @param int $userId
     * @return array
     */
    public function permissionUserPanels($userId)
    {
        $data       = array("userId" => $userId);
        $response   = new RestClient();
        $methodName = 'permissionuserpanels';
        $ids        = array();
        $response->post($data, $methodName, $methodName);
        $result     = json_decode($response->getContent(), TRUE);
        if (1 == $result['result']) {
            $ids = $result['ids'];
        }
        return $ids;
    }

    public function setDataForm($data)
    {
        if (array_key_exists("userId",$data)) {
            $this->userId    = (int) $data['userId'];
        } 
        if (array_key_exists("integraUserId",$data)) {
            $this->integraUserId    = (int) $data['integraUserId'];
        }
        $this->integraId = (int) $data['integraId'];
        $this->objectId  = (int) $data['objectId'];
        $this->userType  = (int) $data['userType'];
        $this->userSchema  = (int) $data['userSchema'];
        $this->userCnt  = (int) (!empty($data['userSchema']))?$data['userSchemaCnt']:$data['userCnt'];
        if (array_key_exists("integraName",$data)) {
            $this->name  = $data['integraName'];
        }
        if (array_key_exists("integraCode",$data)) {
            $this->code  = $data['integraCode'];
        }
        if (array_key_exists("profileId",$data)) {
            $this->profileId  = $data['profileId'];
        }
        if (isset($data['partitionList'])) {
            $this->partitionList = $this->setList($data['partitionList']);
        }
        if (isset($data['accessList'])) {
            $this->accessList = $this->setList($data['accessList']);
        }
    }

    public function setList($list)
    {
        $listNow = array();
        foreach (array_keys($list) as $key) {
            $listNow[]['id'] = $key;
        }
        return $listNow;
    }

    public function save()
    {
        $response   = new RestClient();
        $methodName = 'appuser/'. (isset($this->userId)?$this->userId:0) .'/panels';
        $response->post($this->getData(), $methodName, $methodName);
        $result     = $response->getContent();
        return $this->prepareResponse(json_decode($result));
    }

    /**
     * Przygotowuje Tablice dla konwersji na JSONa
     * @return Array
     */
    public function getData()
    {
        $var = get_object_vars($this);
        foreach ($var as &$value) {
            if (is_object($value) && method_exists($value, 'getData')) {
                $value = $value->getData();
            }
        }
        return $var;
    }

    private function prepareResponse($response)
    {
        if (1 == $response->result) {
            $result           = BaseController::getMessage('action');
            $result['status'] = TRUE;
        } else {
			$result           = BaseController::getMessage('errorActionParam');
			$result['messageDetail'] = (isset($response->extraInfo)?Lang::get('integraError.' . $response->extraInfo):"") . " " . $response->message;
            $result['status'] = FALSE;
        }
        return $result;
    }
}