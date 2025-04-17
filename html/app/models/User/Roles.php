<?php

/**
 * Description of Roles
 *
 * @author mkiedrowski
 */
class Roles
{

    /**
     * Uprawnienia / Dostępy
     * permissionaccesslist
     */
    static public function accessList()
    {
        $response    = new RestClient;
        $tableMaster = 'userrightslist';
        $curlPostDat = array();
        $response->get($tableMaster, $tableMaster, 10);
        $data        = json_decode($response->getContent());
        $array = $data->accessList;
$array = Roles::accessListClean($array, ["RAPINTEGRA"]);
        return $array;
    }

    static private function accessListClean($array, $cleanup) {
        foreach($cleanup as $val) {
            foreach($array as $k => $v) {
                if ($v->name ==$val) {
                    unset($array[$k]);
                }
            }
        }
        return $array;
    }
    /**
     * Profile
     * permissionprofile list
     * {"profileList":[{"id":(id),"name":"String"},{"id":(id),"name":"String"}]}
     */
    static public function rolesList()
    {
        $response    = new RestClient;
        $tableMaster = 'userroles';
        $response->get($tableMaster, $tableMaster, 10);
        $data        = json_decode($response->getContent(), TRUE);
        foreach ($data['list'] as $profileData) {
            $profile[$profileData['id']] = array('name'=>$profileData['name'], 'id'=>$profileData['id'], 't'=>$profileData['type']);
        }
        return $profile;
    }

    /**
     * Użytkownicy/Edycja/Aplikacja
     * @return role: {"role":[{"id":1,"name":"ComboBox"},{"id":2,"name":"ComboBox 2"}]}
     */
    static public function appUserRoleList()
    {
        $response    = new RestClient;
        $tableMaster = 'userroles';
        $response->get($tableMaster, $tableMaster, 10);
        $data        = json_decode($response->getContent(), TRUE);
        foreach ($data['list'] as $profileData) {
            $profile[$profileData['id']] = array('name'=>$profileData['name'], 'id'=>$profileData['id']);
        }
        return $profile;
    }

}
