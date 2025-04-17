<?php

class ControlPanels implements JsonSerializable
{
    private $cacheTime;
    private $response;
    protected $fillable        = array('hierarchyIdx', 'integra', 'ip', 'statusCode',
        'withChildren');
    private static $statusNull = '[{"id":1,"status":2},{"id":2,"status":2},{"id":3,"status":2},{"id":4,"status":2},{"id":5,"status":2},{"id":6,"status":2},{"id":7,"status":2},{"id":8,"status":0}]';
    protected $integraList;

    public function __construct()
    {
        $this->response  = new RestClient();
        $this->cacheTime = 10;
    }

    /**
     * {"integraFilteredList":[{"id":null,"name":"test","address":"168.92.17.1:1","pin":0}]}
     * @param type $param
     */
    public function filtered($param)
    {
        $table             = 'integra/search';
        $curlPostData      = $this->filteredInPut($param);
        $this->response->post($curlPostData, $table, $table . md5(json_encode($curlPostData)));
        $result            = json_decode($this->response->getContent());
        $this->integraList = $result->integraList;
    }

    public function conversion($data)
    {
        $tab = array();
        foreach ($data as $value) {
            $tab[$value->id] = $value->status;
        }
        return $tab;
    }

    private function filteredInPut($paramNow)
    {
        $parameters = array();
        foreach ($paramNow as $key => $value) {
            if (in_array($key, $this->fillable) && !empty($value)) {
                if ("integra" == $key) {
                    $parameters[$key] = array('name' => $value);
                } else {
                    $parameters[$key] = $value;
                }
            }
        }
        return $parameters;
    }

    public function jsonSerialize()
    {
        if (!isset($this->integraList)) {
            return [];
        }
        $tab = [];
        foreach ($this->integraList as $integra) {
            if (!$integra->integraStatusList or 8 != count($integra->integraStatusList)) {
                $integra->integraStatusList = json_decode(self::$statusNull);
            }
            $tab[] = array(
                'action' => $this->action($integra
                            , UserPermissions::containsForRegion('MANINTEGRA', $integra->queryIdx)
                            , UserPermissions::containsForRegion('DELINTEGRA', $integra->queryIdx)),
                'id' => $integra->id,
                'name' => $integra->name,
                'ip' => $integra->address,
                'port' => $integra->port,
                'mapId' => $integra->mapId,
                'statusCode' => $integra->integraStatusList
            );
        }
        return $tab;
    }

    private function action($integraNow, $permIntegraManage, $permIntegraDelete)
    {
        if (8 != count($integraNow->integraStatusList)) {
            return '';
        }
        try {
            $action = View::make('integra.action')
                    ->with('integra', $integraNow)
					->with('permIntegraManage', $permIntegraManage)
					->with('permIntegraDelete', $permIntegraDelete)
                    ->with('status', $integraNow->integraStatusList)->render();
        } catch (Exception $exc) {
            $action = '';
        }
        return (String) $action;
    }

    /**
     * Tablica do prezentacji w formularzach
     * @param int $id
     * @return array
     */
    public function integralist($idx, $withchilds = FALSE)
    {
        $param = ['hierarchyIdx' => $idx, 'withChildren' => $withchilds];
        $this->filtered($param);
        return $this->integraList;
    }

    /**
     *
     * @param int $id :: Id integra
     * @return array
     */
    public function integrastructuretree($id,$withCards = null)
    {
        $table                = 'integra/' . $id .'/structure';
        $this->response->get($table, $table, 10);
        $integrastructuretree = json_decode($this->response->getContent());
        $list                 = $integrastructuretree->integraObjectList;
		if (!is_null($withCards)) {
			$list[]           = array('id' => 0, 'text' => Lang::get('content.partition'), 'partitionList' => array(), 'cardList' =>$this->cardList($id));
		}
		else { 
			$list[]           = array('id' => 0, 'text' => Lang::get('content.partition'), 'partitionList' => array());
		}
        sort($list);
        return $list;
    }
	public static function cardDuplicates($cardList, $cardToCheck, $idx) {
		if (!isset($cardList)) {
			return "";
		}else {
			$ret = "";
			foreach ($cardList as $card) {
			  if (($card->card === $cardToCheck) && ($card->idx !== $idx)) {
				$ret = $ret . $card->name . "\n";
			  }
			}
			return $ret;
		}

	}
	public function cardList($id){
		$users = $this->integraUserList($id);
		$cardUsers = array();
		foreach ($users as $user) {
			if (isset($user->cardNumber)) {
			$cu = new stdClass();
			$cu->idx = $user->idx;
			$cu->name = $user->name;
			$cu->card = $user->cardNumber;
			array_push($cardUsers,$cu);
			}
		}
		return $cardUsers;
	}
	
//=============================================
//ToDo:
//dodać integrastructuretree w formie partitionList id text
//
//==============================================
    /**
     *
     * @param int $id :: Id integra
     * @return array
     */
    public function integraStructureWithZonesTree($id)
    {
        $table                = 'integra/' . $id . '/structure/zones';
        $this->response->get($table, $table, 0);
        $integrastructuretree = json_decode($this->response->getContent());
        if (!$this->integraStructureWithZonesTreeValid($integrastructuretree->integraObjectList)) {
            return [];
        }
        return $integrastructuretree->integraObjectList;
    }

    public function integraStructureWithZonesTreeValid($integraObjectList)
    {
        $fillable                  = ['id', 'text', 'partitionList'];
        $fillablePartitionList     = ['id', 'text', 'state', 'stateExt', 'zoneList'];
        $fillablePartitionStateExt = ['alarm', 'arm3', 'exitDelay', 'exitDelayLong',
            'entryDelay', 'bypass', 'guardBlocked', 'fireAlarm', 'alarmMemory', 'alarmMemoryVerified',
            'fireAlarmMemory', 'warningAlarmMemory', 'arm', 'arm1', 'arm2'];
        if (!$this->isValid($integraObjectList, $fillable)) {
            return false;
        }
        foreach ($integraObjectList as $integra) {
            if (!$this->isValid($integra->partitionList, $fillablePartitionList)) {
                return false;
            }
            foreach ($integra->partitionList as $parameters) {
                if (!$this->isValid([$parameters->stateExt],
                        $fillablePartitionStateExt)) {
                    return false;
                }
            }
        }

        return true;
    }

    public function integraLocksTree($id)
    {
      $table                = 'integra/' . $id . '/structure/locks';
      $this->response->get($table, $table, 0);
      $integraoutputtree = json_decode($this->response->getContent());
      return $integraoutputtree;
    }

    public function integraOutputsTree($id)
    {
      $table                = 'integra/' . $id . '/structure/outputs';
      $this->response->get($table, $table, 0);
      $integraoutputtree = json_decode($this->response->getContent());
      return $integraoutputtree->integraOutputsGroupsList;
    }

	static function cmp($a, $b)
	{
		return strcmp((is_null($a->userName)?$a->name:$a->userName), 
			(is_null($b->userName)?$b->name:$b->userName));
	}

    public function integraUserList($idIntegra, $alphabetSort=FALSE)
    {
        $fillable    = ['id', 'idObject', "idx", "idUser", "name", "userName", "forename", "surname",
            "type", "o", "p", "u", "cardNumber", "dallasNumber"];
        $table       = 'integra/'. $idIntegra .'/users';
        $this->response->get($table, $table, 10);
        $users       = json_decode($this->response->getContent());
        if (!$this->isValid($users->integraUserList, $fillable)) {
            return [];
        }
		if ($alphabetSort) {
			usort($users->integraUserList, array("ControlPanels","cmp"));
		}
        return $this->addRepeatedCardInfo($users->integraUserList);
    }

    private function addRepeatedCardInfo(array $integraUserList)
    {
		$cards = array();
        foreach($integraUserList as $user) {
			if (isset($user->cardNumber)) {
				$user->repeatedCard = in_array($user->cardNumber,$cards);
				array_push($cards,$user->cardNumber);
				if ($user->repeatedCard) {
					foreach($integraUserList as $user2) {
						if (isset($user2->cardNumber) && ($user->cardNumber==$user2->cardNumber)) {
							$user2->repeatedCard = 1;
						}
					}
				}
			}
			else $user->repeatedCard = false;
		}
		return $integraUserList;
	}
    /**
     * Sprawdza czy dane zdefiniowane pokrywają się z przesłanymi z serwera
     * @param array $arrayObj
     * @param array $fillable
     * @return boolean
     */
    private function isValid(array $arrayObj, array $fillable)
    {
        $countFillable = count($fillable);
        foreach ($arrayObj as $obj) {
            if ($countFillable != count((array) $obj)) {
                error_log("ControlPanels bad property: countFillable != countObj"
                    ." \"".$countFillable." != ".count((array) $obj)."\". ".print_r($obj,
                        1)."\n", 3, Config::get('parameters.pathLogs'));
                return false;
            }
            foreach ($fillable as $value) {
                if (!property_exists($obj, $value)) {
                    error_log("ControlPanels bad property: \"".$value."\". ".print_r($obj,
                            1)."\n", 3, Config::get('parameters.pathLogs'));
                    return false;
                }
            }
        }
        return true;
    }

    public function csvSerialize()
    {
        if (!isset($this->integraList)) {
            return [];
        }
        $tab = new ArrayObject();
        $count=1;
        foreach ($this->integraList as $integra) {
            if ($integra->id) {
                $tab[] = array(
                    'id' => $integra->id,
                    'name' => ($integra->name) ? (string) $integra->name : '',
                    'ip' => ($integra->address) ? $integra->address : '',
                    'port' => ($integra->port) ? $integra->port : '',
                );
            }
            if ($count++>=1000){
                $tab[] = array(
                    'id' => 'LIMIT',
                    'name' => '',
                    'ip' => '',
                    'port' => '',
                );
                return $tab;
            }   
        }
        return $tab;
    }
}