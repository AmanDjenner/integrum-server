<?php

class RolesPermissions
{
    private $id;
    private $name;
    private $list = array();

    public function fill($data)
    {
        if (empty($data['name']) || count($data['accessList']) < 1) {
            return FALSE;
        }
        $this->name = $data['name'];
        $this->setlist($data['accessList']);

        return TRUE;
    }

    public function save()
    {
        $table       = 'userroles';
        $restClient  = new RestClient();
        $curlPostDat = array('name' => $this->name, 'list' => $this->list);
        $restClient->upPost($curlPostDat, $table, 'userroles');
        $response    = json_decode($restClient->getContent(), TRUE);
        return $response;
    }

    public function remove($id)
    {
        $table       = 'userroles/' . $id;
		
        $restClient  = new RestClient();
        $restClient->remove($table, 'userroles');
        $response    = json_decode($restClient->getContent(), TRUE);
        return $response;
    }

    private function setlist($list)
    {
        $accessNow = array();
        foreach ($list as $id) {
            $accessNow[] = array('id' => (int) $id);
        }
        $this->list = $accessNow;
    }

    public function index()
    {
        $table       = 'userroles';
        $restClient  = new RestClient();
        $restClient->get($table, $table, 10);
        $response    = json_decode($restClient->getContent(), TRUE);
        return $response['list'];
    }

    
    public function show($id)
    {
        $table       = 'userroles/' . $id;
        $restClient  = new RestClient();
        $restClient->get($table, $table.$id, 10);
        $response    = json_decode($restClient->getContent(), TRUE);
        if (1 == $response['result']) {
            return array('list' => $response['list']);
        }
        return array();
    }
	
    public function update($id)
    {
        //
    }
}