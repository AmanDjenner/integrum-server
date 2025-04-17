<?php

class IntegraData
{

    private $integra;
    private $errors;
    public static $rules = [
        'name'        => 'required',
        'serviceCode' => 'required|numeric|digits_between:1,8',
        'intergrid'   => 'required|hex|size:10',
        'dloadid'     => 'hex|size:10',
        'guardid'     => 'required|hex|size:10',
        'idGroup'     => 'required|integer|min:1'];
    public $messages;

    public function __construct()
    {
        $this->messages = array(
            'hex' => Lang::get('validation.hex')
        );
    }

    /**
     *
     * @param Array $input
     */
    public function fill($input)
    {
        $this->integra = new Integra();
        $this->integra->setInputIntegra($input);
    }

    public function isValid()
    {
        $validation = Validator::make($this->integra->getData(), static::$rules,
                        $this->messages);

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

    /**
     * Zapisuje Centrale
     * addintegra
     */
    public function save($mode=0)
    {
		$table = "integra";
		if ($mode==1) {
			$table .= "/xcx";
		}
        $curlPostDat['integra'] = $this->integra->getData();
		unset($curlPostDat['integra']['showCards']);
		unset($curlPostDat['integra']['statusCode']);
        $restClient             = new RestClient();
        $restClient->put($curlPostDat, $table, $table, 0);
        return json_decode($restClient->getContent());
    }

    /**
     * Zapisuje Centrale
     * addintegra
     */
    public function update()
    {
		$table = 'integra/' . $this->integra->getId();
        $curlPostDat['integra'] = $this->integra->getData();
		unset($curlPostDat['integra']['showCards']);
		unset($curlPostDat['integra']['statusCode']);
        $restClient             = new RestClient();
        $restClient->post($curlPostDat, $table, $table, 0);
        return json_decode($restClient->getContent());
    }

    /**
     * Szuka integry po ID
     * editintegraget
     * @param Integer $idIntegra
     * @return \Integra
     */
    public function find($idIntegra)
    {
        $table       = 'integra/' . $idIntegra;
        $restClient  = new RestClient();
        $restClient->get($table, $table, 0);
        $integra     = new Integra();
        $response    = json_decode($restClient->getContent());
        if ($response->integra) {
            $integra->setIntegra($response);
            return $integra;
        }
        return NULL;
    }

    public function delete($idIntegra)
    {
        $restClient = new RestClient();

        $restClient->remove('integra/' . $idIntegra, 'integra/' . $idIntegra);
        $response = $restClient->getContent();
        return $this->prepareResponse(json_decode($response));
    }

    public function clearAlarm($idIntegra)
    {
        $response    = $this->action("alarm/clear", $idIntegra);
        return $this->preparePanelResponse($response);
    }
    
    public function startGuardX($idIntegra)
    {
      $restClient = new RestClient();
      $table = 'integra/'.$idIntegra.'/guardx';
      $restClient->get($table, $table);
      $response = $restClient->getContent();
      return "integrum+guardx://". $response;
    }

    public function clearTrouble($idIntegra)
    {
        $response    = $this->action("troubles/clear", $idIntegra);
        return $this->preparePanelResponse($response);
    }
    
    public function arm($idIntegra)
    {
        $response    = $this->action('arm', $idIntegra);
        return $this->preparePanelResponse($response);
    }

    public function disArm($idIntegra)
    {
        $response    = $this->action('disarm', $idIntegra);
        return $this->preparePanelResponse($response);
    }

    public function armPartition($idIntegra, $idPartition)
    {
        $curlPostDat = array('ids' => $idPartition);
        $response    = $this->action('partitions/arm', $idIntegra, $curlPostDat);
        return $this->preparePanelResponse($response);
    }

    public function disarmPartition($idIntegra, $idPartition)
    {
        $curlPostDat = array('ids' => $idPartition);
        $response    = $this->action('partitions/disarm', $idIntegra, $curlPostDat);
        return $this->preparePanelResponse($response);
    }

    public function unbyPassZone($idIntegra, $idZoneList)
    {
        $curlPostDat = array('ids' => $idZoneList);
        $response    = $this->action('zones/unbypass', $idIntegra, $curlPostDat);
        return $this->preparePanelResponse($response);
    }

    public function switch($idIntegra, $idOutputList)
    {
        $curlPostDat = array('ids' => $idOutputList);
        $response    = $this->action('outputs/switch', $idIntegra, $curlPostDat);
        return $this->preparePanelResponse($response);
    }

    public function dooropen($idIntegra, $idLocksList)
    {
        $curlPostDat = array('ids' => $idLocksList);
        $response    = $this->action('doors/open', $idIntegra, $curlPostDat);
        return $this->preparePanelResponse($response);
    }

    public function byPassZone($idIntegra, $idZoneList)
    {
        $curlPostDat = array('ids' => $idZoneList);
        $response    = $this->action('zones/isolate', $idIntegra, $curlPostDat);
        return $this->preparePanelResponse($response);
    }

    public function byPassTempZone($idIntegra, $idZoneList)
    {
        $curlPostDat = array('ids' => $idZoneList);
        $response    = $this->action('zones/inhibit', $idIntegra, $curlPostDat);
        return $this->preparePanelResponse($response);
    }

    public function correlateIntegraUserWithUser($idIntegra, $integraUserId, $userId)
    {
        $curlPostDat = array('userId' => (int) $userId);
        $table      = 'integra/'.$idIntegra.'/users/'.$integraUserId;
        $restClient = new RestClient();
        $response   = json_decode($restClient->post($curlPostDat, $table,$table));
        return $this->prepareResponse($response);
    }

    public function deleteIntegraUser($idIntegra, $id)
    {
        $table      = 'integra/'.$idIntegra.'/users/'.$id;
        $restClient = new RestClient();
        $response   = json_decode($restClient->remove($table,$table));
        return $this->preparePanelResponse($response);
    }

    private function preparePanelResponse($response)
    {
        if (Config::get('parameters.RESULT_OK') == $response->result) {
            $result           = BaseController::getMessage('integraAction');
            $result['status'] = TRUE;
        } else {
            $result                 = BaseController::getMessage('integraErrorAction');
			$result['messageDetail'] = (isset($response->extraInfo)?Lang::get('integraError.' . $response->extraInfo):"") . " " . $response->message;
            $result['status']       = FALSE;
        }
        return $result;
    }

    private function prepareResponse($response)
    {
        if (Config::get('parameters.RESULT_OK') == $response->result) {
            $result           = BaseController::getMessage('action');
            $result['status'] = TRUE;
        } else {
			$result           = BaseController::getMessage('errorActionParam');	
			$result['messageDetail'] = (isset($response->extraInfo)?Lang::get('integraError.' . $response->extraInfo):"") . " " . $response->message;
            $result['status'] = FALSE;
        }
        return $result;
    }

    private function action($action, $idIntegra, $curlPostDat=[])
    {
        $restClient = new RestClient();
		$table = 'integra/'.$idIntegra.'/action/'.$action;
        $restClient->post($curlPostDat, $table, $table);
        $response = $restClient->getContent();
        return json_decode($response);
    }

    public function getData()
    {
        return $this->integra;
    }

}
