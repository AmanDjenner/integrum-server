<?php

class HierarchyData
{
    private $tableMaster;
    private $cacheTime;
    private static $dataTree;
    private static $data;

    public function __construct()
    {
        $this->tableMaster = 'hierarchy';
        $this->cacheTime   = 30;
        $this->find(UserContext::getAllRegions());       
    }

    private function find($idAccessNow)
    {
        if (!isset(HierarchyData::$dataTree)) {
            $response = new RestClient;
            $key = $this->tableMaster. "--" . implode($idAccessNow,'#');
            $url = $this->tableMaster. '?' ;
            foreach($idAccessNow as $ids) {
                $url .= "ids=". $ids ."&";
            }
            $response->get($url, $key, $this->cacheTime, FALSE);
            if (!$response->result()) {
                return FALSE;
            }
            HierarchyData::$dataTree = json_decode($response->getContent());
            $this->create(HierarchyData::$dataTree, 0);
        }
        return TRUE;
    }

    public function getByQry($queryIdx)
    {
        foreach(self::$data as $val) {
            if ($val['queryIdx']==$queryIdx) {
                return $val;
            }
        }
        return NULL;
    }

    public function getTreeDisplay()
    {
        return (HierarchyData::$dataTree!=null&&HierarchyData::$dataTree->id==0)
            ?HierarchyData::$dataTree->hierarchyTreeList
            :HierarchyData::$dataTree;
    }

    public function getTree()
    {
        return HierarchyData::$dataTree;
    }

    /**
     *
     * @return array ['id', 'name', 'parentId', 'queryIdx' ]
     */
    public function getAllUserRegions()
    {
        if (HierarchyData::$data && HierarchyData::$data[0]['id']==0) {
            $regs = [];
            foreach(HierarchyData::$data as $v) {
                if($v['parentId']==0 && $v['id']!=0) {
                    array_push($regs, $v['queryIdx']);
                }
            }
            return $regs;
        } else {
            return [HierarchyData::$data[0]['queryIdx']];
        }
    }
    
    public function getData()
    {
        return HierarchyData::$data;
    }

    private function create($loc, $p)
    {
        HierarchyData::$data[$loc->id] = array('id' => $loc->id, 'name' => $loc->name, 'queryIdx' => $loc->queryIdx,
            'parentId' => $p);
        if ($loc->hierarchyTreeList) {
            foreach ($loc->hierarchyTreeList as $hierarchyTree) {
                if ($hierarchyTree!=null) {
                    $this->create($hierarchyTree, $loc->id);
                }
            }
        }
    }

    public function getName($idNow)
    {
        if (!isset(HierarchyData::$data[$idNow])) {
            return NULL;
        }
        $locations = HierarchyData::$data[$idNow];
        return $locations['name'];
    }

    public function getQueryIdx($idNow)
    {
        if (!isset(HierarchyData::$data[$idNow])) {
            return NULL;
        }
        $locations = HierarchyData::$data[$idNow];
        return $locations['queryIdx'];
    }

	public static function withChildren() {
        if (Cookie::has('withChildren')) {
            return Cookie::get('withChildren');
        } else {
            return 0;
        }
	}

    public static function getCurrentQueryIdx()
    {
        $cookieValues = Cookie::get('hierarchy');
        $queryIdx     = ($cookieValues['queryIdx']) ? $cookieValues['queryIdx'] : '1#';
        return [$queryIdx];
    }

    public static function getCurrentQueryId()
    {
        $cookieValues = Cookie::get('hierarchy');
        $queryId     = ($cookieValues['id']) ? $cookieValues['id'] : '1';
        return $queryId;
    }
}