<?php

/** CENTRALE >> EDYCJA >> UZYTKOWNICY */
class IntegraUserController extends \BaseController
{

    public function show($id)
    {
        try {
            /** Type User  */
            $type = Permission::userTypeList();
            /** Uprawnienia User  */
            $access = Permission::accessList();

            $integraData = new IntegraData();
            $integra     = $integraData->find($id);
            Session::set('integra', $integra);
            $cp          = new ControlPanels();
            $hierarchy = new HierarchyController();
            $currRegion = HierarchyController::getSessionData();
            $profile = Permission::profileList(Lang::get('content.profile'));
            $cardList = $cp->cardList($id);
            $userList = $cp->integraUserList($id, Config::get('parameters.sortIntegraUsersByName',FALSE));
            $view = View::make('integra.user.show')
                            ->with('integraUserList', $userList)
                            ->with('integra', $integra)
                            ->with('hierarchyId', $integra->getIdGroup())
                            ->with('sideRegionVars', $hierarchy->getSideRegionData())
                            ->with('navbarVars', $this->navbarVarsDefault())
                            ->with('permUserSel', UserPermissions::containsForRegion('SELUSER', $integra->getQueryIdx()))
                            ->with('permProfileManage', UserPermissions::containsForRegion('MANPROFILE', $integra->getQueryIdx()))
                            ->with('permProfileExcept', UserPermissions::containsForRegion('NOPROFILE', $integra->getQueryIdx()))
                            ->with('profile',$profile)
                            ->with('type', htmlspecialchars(json_encode($type)))
                            ->with('typeDta', $this->userTypeList($type))
                            ->with('access',htmlspecialchars(json_encode($access)))
                            ->with('accessDta', $access)
                            ->with('permUserIntegraCreate', UserPermissions::containsForRegion('CREUSERINTEGRA', $integra->getQueryIdx()))
                            ->with('permUserIntegraSelect', UserPermissions::containsForRegion('EDTUSERINTEGRA', $integra->getQueryIdx())||UserPermissions::containsForRegion('SELUSERINTEGRA', $integra->getQueryIdx()))
                            ->with('permUserIntegraEdit', UserPermissions::containsForRegion('EDTUSERINTEGRA', $integra->getQueryIdx()))
                            ->with('permUserIntegraRemove', UserPermissions::containsForRegion('DELUSERINTEGRA', $integra->getQueryIdx()))
                            ->with('permIntegraReport',UserPermissions::containsForRegion('RAPINTEGRA', $integra->getQueryIdx()))
                            ->with('permIntegraEdit',UserPermissions::containsForRegion('EDTINTEGRA', $integra->getQueryIdx()))
                            ->with('permIntegraManage',UserPermissions::containsForRegion('MANINTEGRA', $integra->getQueryIdx()))
                            ->with('permGuardx', UserPermissions::containsForRegion('MANGUARDX', $integra->getQueryIdx()))
							->with('permIntegraEvents', UserPermissions::containsForRegion('SELEVENTS', $integra->getQueryIdx()))
                            ->with('currentHierarchy', $currRegion)
                            ->with('cardList', json_encode($cardList))
                            ->with('cardListArray', $cardList)
                            ->with('hierarchyName', $hierarchy->treeGetName($integra->getIdGroup()))
                            ->with('helpcnt', 'ekran-z-danymi-centrali.html#uzytkownicy');
			return $this->message($view);
        } catch (Exception $exc) {
            error_log("IntegraUserController " . $exc . "\n", 3,
                    Config::get('parameters.pathLogs'));
            return Redirect::route('session.logout')
                            ->with('message', Lang::get('content.disconnected').'<br>'.$exc->getMessage());
        }
    }

    private function userTypeList($list)
    {
        $selectList = array();
        foreach ($list as $value) {
            $selectList[$value["id"]] = $value["name"];
        }
        return $selectList;
    }

    public function destroy()
    {
        $integraData = new IntegraData();
        $result      = $integraData->deleteIntegraUser(Input::get('idIntegra'),Input::get('id'));
        return Response::json($result);
    }

    public function storeIntegraAsIntegrum()
    {
        $input          = Input::all();
        $input['photo'] = null;
        $userid         = $input["userId"];
        unset($input["userId"]);
        $user           = new User();
        $user->fillUser($input);
        if (!$user->isValid('create')) {
            return Response::json(array('result' => '3', 'message' => $user->errors()->first('name')));
        }
        $data = json_decode($user->save());

        if (1 == $data->result) {
            $this->correlateInternal($userid, $data->userId);
            return Response::json(array('result' => '1', 'id' => $data->userId, 'message' => BaseController::getMessage('addappuser')));
        } else {
            return Response::json(array('result' => '3', 'message' => BaseController::getMessage('addappuserError')));
        }
    }

    public function correlate()
    {
        return $this->correlateInternal(Input::get('idIntegra'), Input::get('id'), Input::get('idUser'));
    }

    public function correlateInternal($idIntegra, $id, $idUser)
    {
        $integraData = new IntegraData();
        $result      = $integraData->correlateIntegraUserWithUser($idIntegra, $id, $idUser);
        return Response::json($result);
    }

}
