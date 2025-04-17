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

class EventData extends EloquentJ
{
    private $cacheTime;
    private $response;

    public function __construct()
    {
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
    public function filterInternal($param)
    {
        $param['limit'] = Config::get('parameters.eventLimit') + 1;
        $filterParam    = $this->filterParam($param);

        $table     = 'events';
        $this->response->post($filterParam, $table, $table, 0);
        $eventList = json_decode($this->response->getContent(), TRUE);
        if (1 != $eventList['result']) {
            $eventList['eventList'] = NULL;
            return $eventList;
        }
        //Sprawdzamy czy sa jeszcze jakieś rekordy
        if ($param['limit'] == count($eventList['eventList'])) {
            array_pop($eventList['eventList']); //removes last
        } else {
            /** Ukryj przycisk Starsze */
            $filterParam['offset'] = 'hide';
        }
        if (!isset($filterParam['queryStartIdx']) && isset($eventList['eventList'][0]['id'])) {
            $eventList['queryStartIdx'] = $eventList['eventList'][0]['id'];
        } else {
            $eventList['queryStartIdx'] = $filterParam['queryStartIdx'];
        }
        $eventList['offset'] = $filterParam['offset'];
        return $eventList;
    }

    public function filter($param)
    {
        return json_encode($this->filterInternal($param));        
    }

    public function archive()
    {
        $table            = 'events/archive';
        $this->response->get($table,$table,0);
        return $this->response->getContent();
    }    

    public function archivedays()
    {
        $table            = 'events/setting/archive_days_old';
        $this->response->get($table,$table,0);
        return $this->response->getContent();
    } 

    public function savearchivedays($days)
    {
        $table            = 'events/setting/archive_days_old';
        $this->response->post([$days], $table,$table,0);
        return $this->response->getContent();
    }    

    public function doarchive()
    {
        $table            = 'events/doarchive';
        $this->response->post([], $table,$table,0);
        return $this->response->getContent();
    }
    
    public function getUnhandled()
    {
        $table            = 'events/unhandled';
        $eventSourceList  = array();
        $this->response->post(["queryIdx"=>Cookie::get('hierarchy')["queryIdx"]],$table,$table,0);
        return json_decode($this->response->getContent(), TRUE)["events"];
    }

    public function csvSerialize($param)
    {
        $list=$this->filterInternal($param);
        $tab = new stdClass();
        $tab->list = new ArrayObject();
        foreach ($list["eventList"] as $ev) {
            if ($ev["id"]) {
                //id":77589,"date":"2017.06.30 14:43","source":"130","user":" ","userId":0,"type":"Działa","description":"Tab D 49 MKiedrowskyy","systemId":449,"commentCount":0
                $tab->list[] = array(
                    'data' => $ev["date"],
                    'type' => $ev["source"],
                    'zdarzenie' => ($ev["type"]) ? (string) $ev["type"] : 'null',
                    'szczegóły' => ($ev["description"]) ? $ev["description"] : 'null',
                    'użytk' => $ev["user"],
                );
            }
        }
        $tab->queryIdx = $list["queryStartIdx"];
        $tab->offset = $list["offset"];
        return $tab;
    }
    public function addComment($id, $comment)
    {
        $addComment    = ["id"=>$id, "comment"=>$comment];

        $table     = 'events/comments';
        $this->response->post($addComment, $table, $table, 0);
        return json_decode($this->response->getContent(), TRUE);
    }
	
    //Przetworzenie danych z formularza
    private function filterParam($param)
    {
        unset($param['btnNext']);
		unset($param['eventUsers']);
        unset($param['idTree']);
        unset($param['_token']);
		
        $offset = 0;

        if (!empty($param['source']) and ! is_array($param['source'])) {
            $param['source'] = array(--$param['source']);
        }

        if (!empty($param['typeEvent'])) {
            $param['typeEvent'] = array(--$param['typeEvent']);
        }
        unset($param['hierarchytree']);
	if (!isset($param['hierarchyIdx'])) {
            $param['hierarchyIdx'] = '1#';
            $param['withChildren']  = TRUE;
        }
        
        foreach ($param as $key => $value) {
            if ($value) {
                $filterParam[$key] = $value;
            } else if ($key == 'withComments'){
				$filterParam['withComments'] = $value;		
			}
        }
        if (isset($param['queryStartIdx']) && $param['queryStartIdx']) {
            $filterParam['offset'] = ($param['limit'] + $param['offset']) - 1;
        } else {
            $filterParam['queryStartIdx'] = NULL;
            $filterParam['offset']        = $offset;
        }

        if (isset($filterParam['withChildren']) && "true" == $filterParam['withChildren']) {
            $filterParam['withChildren'] = true;
        } else {
            $filterParam['withChildren'] = false;
        }
        return $filterParam;
    }

    public function eventsourcelist()
    {
        $table            = 'event_classes';
        $eventSourceList  = array();
        $this->response->get($table,$table);
        $eventSourceArray = json_decode($this->response->getContent(), TRUE);
        if (!$eventSourceArray['sourceList']) {
            return NULL;
        }
        foreach ($eventSourceArray['sourceList'] as $event) {
            $eventSourceList[$event['id']] = $event['name'];
        }
        return $eventSourceList;
    }

    public function eventsDetail($id)
    {
        $table            = 'events/'.$id;
		$this->response->get($table,$table);
        $eventDetail = json_decode($this->response->getContent(), TRUE);
		if (!$eventDetail['result']==1) {
            return NULL;
        }
        return $eventDetail["event"];
    }

    /**
     * Widok: Centrala :: Filtr
     * Out: {"typeEventList":[{"id":(id),"name":"String"},{"id":(id),"name":"String"}]}
     */
    public function eventtypelist($eventClasses = NULL)
    {
		$table          = 'event_names?class=' . (((NULL!=$eventClasses) && is_array($eventClasses))?implode(",",$eventClasses):$eventClasses);
        $this->response->get($table, $table);
        $eventTypeArray = json_decode($this->response->getContent(), TRUE);
        if (!$eventTypeArray['typeEventList']) {
            return array(["id"=>0, "name" => Lang::get('content.description'), "evtClass"=>""]);
        }
		array_unshift($eventTypeArray['typeEventList'], array("id"=>0, "name" => Lang::get('content.description'), "evtClass"=>""));
		return $eventTypeArray['typeEventList'];
    }

    /**
     * Widok: Centrala :: Filtr
     *
     */
    public function eventuserlisttree($id, $withChildren = false)
    {
        return $this->eventuserlist($id, $withChildren);
    }

    /**
     * Widok: Centrala :: Filtr
     *
     */
    public function eventuserlistintegra(array $id, $withChildren = false)
    {
        if (2 != count($id)) return NULL;
        return $this->eventuserlist((int)$id[0], $withChildren, (int) $id[1]);
    }

    private function eventuserlist($hierarchytree, $withChildren, $panelId = NULL)
    {
        $table = 'events_users'. '?' ;
        if (is_array($hierarchytree)) {
        	foreach($hierarchytree as $ids) {
        		$table .= "hierarchyId=". $ids ."&";
        	}
        } else {
        	$table .= "hierarchyId=". $hierarchytree ."&";
        }
        $table .=   'withChildren=' . ($withChildren?'1':'0') . ($panelId == NULL?'':'&panelId=' . $panelId);
        $this->response->get($table, $table);
        $eventUserArray = json_decode($this->response->getContent());
        $list           = $eventUserArray->usersList;
        if ($panelId == NULL) {
            foreach ($list as $key=>$item)
                if (substr($item->id,0,1)=="I"||substr($item->id,0,1)=="S")
                    unset($list[$key]);
        }
        function uidx2num($id) {
            $idx =substr($id,0,1);
            switch($idx) {
                case "U": return 10;
                case "S": return 50;
                case "I": return 20;
                default: return 21;
            }
        }
        usort($list, function ($a, $b)
        {
            if ($a == $b) {
                return 0;
            }
            if (property_exists($a,"id") && property_exists($b,"id") && 
                gettype($a->id)=="string" && gettype($b->id)=="string" &&
                strlen($a->id)>1 && strlen($b->id)>1) {
                    $ai = uidx2num($a->id);
                    $bi = uidx2num($b->id);
                    if ($ai==$bi) {
                        $res = 0;
                    } else {
                        $res = ($ai < $bi) ? -1 : 1;
                    }
                if ($res==0) {
                    return (substr($a->id,0,1)=="U"&&substr($b->id,0,1)=="U")?substr_compare($a->name,$b->name,0):substr_compare($a->id,$b->id,1);
                } else {
                    return $res;
                }
            } else {
                return ($a < $b) ? -1 : 1;
            }
        });
		$list = array_unique($list, SORT_REGULAR);
		return $list;
    }

    public function find($id)
    {

    }

    public function renameIntegraArchive($integraId, $integraUserId, $newName=NULL) {
        $table = "events/integra/" . $integraId . "/user/" . $integraUserId;
        if (isSet($newName)) { // @PUT
            $param = [ "newName" => $newName];
            $this->response->put($param, $table, $table, 0);
            $eventList = json_decode($this->response->getContent(), TRUE);
            if (1 != $eventList['result']) {
                $eventList['eventList'] = NULL;
                return $eventList;
            }
        } else { // @DELETE
            $this->response->remove($table, $table, 0);
            $eventList = json_decode($this->response->getContent(), TRUE);
            if (1 != $eventList['result']) {
                $eventList['eventList'] = NULL;
                return $eventList;
            }
        }
    }

    public function renameUserArchive($userId, $newName=NULL) {
        $table = "events/user/" . $userId;
        if (isSet($newName)) { // @PATCH
            $param = [ "newName" => $newName];
            $this->response->put($param, $table, $table, 0);
            $eventList = json_decode($this->response->getContent(), TRUE);
            if (1 != $eventList['result']) {
                $eventList['eventList'] = NULL;
                return $eventList;
            }
        } else { // @DELETE
            $this->response->remove($table, $table, 0);
            $eventList = json_decode($this->response->getContent(), TRUE);
            if (1 != $eventList['result']) {
                $eventList['eventList'] = NULL;
                return $eventList;
            }
        }
    }
}