<?php

class ProfileAccess
{
    private $id;
    private $name;
    private $type;
    private $list = array();

    public function fill($data)
    {
        if (empty($data['name']) || !isset($data['type']) || count($data['accessList'])
            < 1) {
            return FALSE;
        }
        $this->name = $data['name'];
        $this->type = $data['type'];
        $this->setlist($data['accessList']);

        return TRUE;
    }

    public function save()
    {
        $table       = 'permissionprofile';
        $restClient  = new RestClient();
        $curlPostDat = array('name' => $this->name, 'type' => $this->type, 'list' => $this->list);
        $restClient->upPost($curlPostDat, $table, 'permissionprofile');
        $response    = json_decode($restClient->getContent(), TRUE);
        return $response;
    }

    public function remove($id)
    {
        $table       = 'permissionprofile/' . $id;
		
        $restClient  = new RestClient();
        $restClient->remove($table, 'permissionprofile');
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
        $table       = 'permissionprofile';
        $restClient  = new RestClient();
        $restClient->get($table, $table, 10);
        $response    = json_decode($restClient->getContent(), TRUE);
        return $response['list'];
    }

    public function show($id)
    {
        $table       = 'permissionprofile/' . $id;
        $restClient  = new RestClient();
        $restClient->get($table, $table.$id, 10);
        $response    = json_decode($restClient->getContent(), TRUE);
        if (1 == $response['result']) {
            return array('usertypeid' => $response['usertypeid'], 'list' => $response['list']);
        }
        return array();
    }

    public function update($id)
    {
        //
    }
}