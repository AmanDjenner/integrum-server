<?php

/**
 * Description of StructureController
 *
 * @author karolsz
 */
class IntegraStructureController extends \BaseController
{

    public function show($id)
    {
        try {
            $integraData = new IntegraData();
            $integra     = $integraData->find($id);
            $cp          = new ControlPanels();

			$hierarchy = new HierarchyController();
			$currRegion = HierarchyController::getSessionData();
            $view = View::make('integra.structure.show')
                            ->with('integraStructureWithZonesTree',
                                    $cp->integraStructureWithZonesTree($id))
                            ->with('integra', $integra)
                            ->with('currentHierarchy', $currRegion)
                            ->with('sideRegionVars', $hierarchy->getSideRegionData())
                            ->with('navbarVars', $this->navbarVarsDefault())
                            ->with('permUserIntegraSelect', UserPermissions::containsForRegion('EDTUSERINTEGRA', $integra->getQueryIdx())||UserPermissions::containsForRegion('SELUSERINTEGRA', $integra->getQueryIdx()))
                            ->with('permUserIntegraEdit', UserPermissions::containsForRegion('EDTUSERINTEGRA', $integra->getQueryIdx()))
                            ->with('permIntegraReport',UserPermissions::containsForRegion('RAPINTEGRA', $integra->getQueryIdx()))
                            ->with('permIntegraEdit',UserPermissions::containsForRegion('EDTINTEGRA', $integra->getQueryIdx()))
                            ->with('permIntegraManage',UserPermissions::containsForRegion('MANINTEGRA', $integra->getQueryIdx()))
                            ->with('permGuardx', UserPermissions::containsForRegion('MANGUARDX', $integra->getQueryIdx()))
							->with('permIntegraEvents', UserPermissions::containsForRegion('SELEVENTS', $integra->getQueryIdx()))
                            ->with('hierarchyName', $hierarchy->treeGetName($integra->getIdGroup()))
                            ->with('helpcnt', 'ekran-z-danymi-centrali.html#struktura');
            return $this->message($view);
        } catch (Exception $exc) {
            error_log("IntegraStructureController " . $exc . "\n", 3,
                    Config::get('parameters.pathLogs'));
            return Redirect::route('session.logout')
                            ->with('message', Lang::get('content.disconnected').'<br>'.$exc->getMessage());
        }
    }

    public function action()
    {
        $fillable = ['unbyPassZone', 'byPassZone', 'byPassTempZone', 'armPartition',
            'disarmPartition', 'switch', 'dooropen'];
        if (in_array(Input::get('action'), $fillable)) {
            $id         = (int) Input::get('idIntegra');
            $idZoneList = Input::get('id');
            $action     = Input::get('action');
            try {
                $integra  = new IntegraData();
                $response = $integra->$action($id, $idZoneList);
                return Response::json($response);
            } catch (Exception $exc) {
                return Response::json($exc);
            }
        }
        $result           = BaseController::getMessage('errorAction');
        $result['status'] = FALSE;
        return Response::json($result);
    }

    private function tree(HierarchyData $t)
    {
        $response = $t->getTree();
        return View::make('hierarchy.menu')->with('hierarchyTreeList', $response);
    }

}
