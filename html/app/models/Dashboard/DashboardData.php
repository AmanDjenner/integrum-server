<?php

/**
 * * Suppose we have following: offset = null, limit = 5, queryStartIdx =
 * * null. The ids of events are following: 15, 14, 13, 12, 11 (the order has
 * * meaning). Then next call to getFilteredEventList(...) has offset = 5,
 * * limit = 5 and queryStartIdx = 15 (which is the first id of previous
 * * returned list), then the ids of events are: 10, 9, 8, 7, 5. Then the user
 * * on UI will move to begining of the list (ids of events are following: 15,
 * * 14, 13, 12, 11, offset = 0, limit = 5 and queryStartIdx = 15). Suppose
 * * the next user action will be to move up (scroll up) so the invocation of
 * * getFilteredEventList(...) has offset = null(or 0), limit = 5 and
 * * queryStartIdx = null and resulting ids will be 20, 19, 18, 17, 16 (those
 * * ids was written to db after the first invocation of
 * * getFilteredEventList(...)). Next user action will be scroll down and the
 * * call to getFilteredEventList(...) has offset = 5, limit = 5 and
 * * queryStartIdx = 20 (which is the first id of previous returned list).
 */
class DashboardData 
{
    private $cacheTime;
    private $response;
    private static $dashRest;
    
    public function __construct()
    {
        self::$dashRest    = Config::get('parameters.dashRest');
        $this->response  = new RestClient();
        $this->cacheTime = 10;
    }

    /**
     * Integer hierarchytree;
     * Integer integraId;
     * Integer objectId;
     * Integer partitionId;
     * Integer source;
     * Integer userId;
     * Integer typeEvent;
     * String dateFrom;
     * String dateTo;
     * Boolean withChildren;
     * Long queryStartIdx; pierwsze id pierwszej strony
     * Integer offset;
     * Integer limit; ilosc zwracanych rekordow
     *
     *
     * @param type $param
     * @return type
     */
	function setParameter($param, $key, $value) {
		$found = false;
		for ($i = 0; $i < count($param); $i++) {
			if ($param[$i]['key']==$key) {
				$found = true;
				break;
			}
		}
		if ($found)
			$param[$i]['value']=$value;
		else
			$param[] = array('key'=>$key,'value'=>$value);
		return $param;
	}
		function getParameter($param, $key) {
		$found = false;
		//try {
		for ($i = 0; $i < count($param); $i++) {
			if ($param[$i]['key']==$key) {
				return $param[$i]['value'];			
			}
		}
		//echo $key . " ";
		return null;

		//}
		//catch exception
		//catch(Exception $e) {
		//	dd($key . print_r($param));
		//}
	}
    public function events($htree, $param)
    {
        $param['parameters'] = $this->setParameter($param['parameters'], 'limit', Config::get('parameters.eventLimit') + 1);
		if (!empty($htree)) {
			$param['parameters'] = $this->setParameter($param['parameters'], 'hierarchytree', $htree);
        }
		$filterParam    = $param;
        $table     = 'dashboard/events';
        $this->response->postAny($filterParam, self::$dashRest, $table, $table, 0);
        $eventList = json_decode($this->response->getContent(), TRUE);
        if (1 != $eventList['result']) {
            $eventList['eventList'] = NULL;
            return $eventList;
        }
        //Sprawdzamy czy sa jeszcze jakieś rekordy
        if ($this->getParameter($param['parameters'],'limit') == count($eventList['eventList'])) {
            array_pop($eventList['eventList']); //removes last
        } else {
            /** Ukryj przycisk Starsze */
            $param['parameters'] = $this->setParameter($param['parameters'], 'offset', 'hide');
        }
		$queryStartIdx=$this->getParameter($param['parameters'],'queryStartIdx');
        if (!isset($queryStartIdx) && isset($eventList['eventList'][0]['id'])) {
            $eventList['queryStartIdx'] = $eventList['eventList'][0]['id'];
        } else {
            $eventList['queryStartIdx'] = $queryStartIdx;
        }
        $eventList['offset'] = $this->getParameter($param['parameters'],'offset');
        return json_encode($eventList);
    }

    public function filter($htree, $system,$param)
    {
		if (!empty($htree)) {
			$param['parameters'] = $this->setParameter($param['parameters'], 'hierarchytree', $htree);
        }
        $table     = 'dashboard/filter';
        $this->response->postAny($param, self::$dashRest, $table, $table, 0);
		$ret = json_decode($this->response->getContent());
		foreach($ret as $x) {
			$statuscode = new stdClass();
			foreach($x->statusCode as $scode){
			$statuscode->{$scode->id}=$scode->status;
			}
			$x->statusCode =$statuscode;
		}
		return $ret;
        //$eventList = json_decode($this->response->getContent(), TRUE);
		/*
        if (1 != $eventList['result']) {
            $eventList['eventList'] = NULL;
            return $eventList;
        }
		*/
        //return json_encode($eventList);
    }

	public function detail($system, $id)
    {
		
        $table     = 'dashboard/detail';
		$param['system']= $system;
		$param['parameters']= array();
		$param['parameters'][] = array('key'=>'id', 'value'=>$id);
        $this->response->postAny($param, self::$dashRest, $table, $table, 0);
		
        $response    = json_decode($this->response->getContent(), TRUE);
		
		$ret = new stdClass();
		foreach($response as $props=>$val) {
			if ($props=="parameters") {
				$parameters = new stdClass();
				foreach($val as $idx=>$x) {
					$parameters->{$x["key"]}=$x["value"];
				}
				$ret->{$props}=$parameters;
			}
			else {
				$ret->{$props}=$val;
			}
		}
		
		return $ret;
		/*
		if ($response["system"]=="integra") {
			$integra     = new Integra();
            $integra->setName($this->getParameter($response['parameters'],'name'));
            $integra->setIdGroup($this->getParameter($response['parameters'],'hierarchytree'));
            $integra->setType($this->getParameter($response['parameters'],'integraType'));
            $integra->setVersion($this->getParameter($response['parameters'],'version'));
			$status = json_decode($this->getParameter($response['parameters'],'state'), TRUE);
			$is=array();//{"id":1,"status":3}
			$is[] = (object) [];
			for($i=1;$i<=8;$i++) {
				$singlestate = $this->getParameter($status,'id'.$i);
				$is[] = (object) ['id'=> $i, 'status'=> $singlestate];
			}
			$integra->setIntegraState($is);
			return $integra;
        }
		if ($response["system"]=="csp") {
			$integra     = new Integra();
            $integra->setName($this->getParameter($response['parameters'],'name'));
            $integra->setIdGroup($this->getParameter($response['parameters'],'hierarchytree'));
            $integra->setType($this->getParameter($response['parameters'],'integraType'));
            $integra->setVersion($this->getParameter($response['parameters'],'version'));
			$status = json_decode($this->getParameter($response['parameters'],'state'), TRUE);
			$is=array();//{"id":1,"status":3}
			$is[] = (object) [];
			for($i=1;$i<=8;$i++) {
				$singlestate = $this->getParameter($status,'id'.$i);
				$is[] = (object) ['id'=> $i, 'status'=> $singlestate];
			}
			$integra->setIntegraState($is);
			return $integra;
        }
        return NULL;
		*/
    }

	public function overallstate($mode, $idAccessGroupUser) {
        $table        = 'dashboard/overallstate/'.$mode.'/'.$idAccessGroupUser.'/1';
//		$table        = 'overallstate/'.$idAccessGroupUser.'/1';
        $response = json_decode($this->response->curlAny(NULL, self::$dashRest, "GET", $table));
		$ret = array();
		for ($i = 0; $i < count($response->parameters); $i++) {
			$ret[$response->parameters[$i]->key]=$response->parameters[$i]->value;
		}
		
        return Response::json($ret);		
	}

}