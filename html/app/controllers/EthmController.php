<?php

class EthmController extends \BaseController
{

    public function index()
    {
        $hierarchy = new HierarchyController();
        $currRegion = HierarchyController::getSessionData();
        $filter = View::make('integra.ethm.filter');
        $data   = View::make('integra.ethm.index')
                ->with('sideRegionVars', $hierarchy->getSideRegionData())
                ->with('navbarVars', $this->navbarVarsDefault())
                ->with('listTitle', Lang::get('content.ethm'))
                ->with('currentHierarchy', $currRegion)
                ->with('helpcnt', 'ekran-moduly-ethernetowe.html')
                ->with('filter', $filter);
        if (UserPermissions::containsForRegion('CREINTEGRA', $currRegion->getQueryIdx())
                && Config::get('parameters.EthmNewServer', false)) {
            $data = $data->with('addLink', '/ethm/create/');
        }
        return $data;
    }

    public function filter()
    {
        $ed       = new EthmData();
        $response = $ed->filtered(Input::all(), HierarchyController::getSessionData()->getQueryIdx());
        return Response::json($response);
    }

    /*     * Formatka dodawania ETHM */

    public function create()
    {
		$currRegion = HierarchyController::getSessionData();
        $view = View::make('integra.ethm.create')
						->with('sideRegionVars', $hierarchy->getSideRegionData())
						->with('navbarVars', $this->navbarVarsDefault())
						->with('currentHierarchy', $currRegion)
						->with('helpcnt','dodanie-nowej-centrali.html');
		return $this->message($view);
    }

    /** Zapis nowego ETHM */
    public function store()
    {
        $inputETHM = Input::all();
        if (Input::has('type')) {
            $type = $inputETHM['type'];
            unset($inputETHM['type']);
        } else
            $type=null;
        if (isset($inputETHM['nameEthm'])) {
            $inputETHM['name'] = $inputETHM['nameEthm'];
            unset($inputETHM['nameEthm']);
        }
        $ed = new EthmData();
        $ed->fill($inputETHM);
        if (!$ed->isValid('create')) {
            return Redirect::back()
                            ->withInput()->withErrors($ed->errors())
                            ->with('type', $type)
                            ->with('ethmerrors', 'a');
        }
        $result = $ed->save();
        if (1 != $result->result) {
            return Redirect::back()
                            ->with('type', $type)
                            ->with('ethmerrors', 'a')
                            ->with('message', 'ErrorDatabase');
        }
        if (Session::has('integra_1')) {
            return Redirect::route('control.storeEthm', ['ethm' => $result->id])->with('integra_1',
                            Session::get('integra_1'));
        }
        return Redirect::route('ethm.edit', ['id' => $result->id]);
    }

    /** Formatka edycji ETHM */
    public function edit($id)
    {
        $ed   = new EthmData();
        $ethm = $ed->find($id);
        if (!isset($ethm)) {
            return Redirect::route('users.index')
                        ->with('message', 'errorAll');
        }
		$currRegion = HierarchyController::getSessionData();
		$hierarchy = new HierarchyController();
        $view = View::make('integra.ethm.edit')
                    ->with('sideRegionVars', $hierarchy->getSideRegionData())
                    ->with('hierarchyName', $hierarchy->treeGetName($ethm->getIdGroup()))
                    ->with('navbarVars', $this->navbarVarsDefault())
                    ->with('permIntegraEdit',UserPermissions::containsForRegion('EDTINTEGRA', $currRegion->getQueryIdx()))
                    ->with('ethm', $ethm)
                    ->with('helpcnt','ekran-z-danymi-modulu-ethernet.html')
                    ->with('currentHierarchy', $currRegion);
        return $this->message($view);
    }

    /** Zapis edytowanego ETHM */
    public function update($id)
    {
        $input       = Input::all();
        $input['id'] = $id;
        unset($input['version']);
        $ed          = new EthmData();
        $ed->fill($input);
        if (!$ed->isValid('update')) {
            return Redirect::back()
                            ->withInput()
                            ->withErrors($ed->errors());
        }
        $result = $ed->update();
        //ToDo: Dodać czyszczenie cache
        if (1 == $result->result) {
            return Redirect::route('ethm.edit', array('id' => $id))
                            ->with('message', 'updateEthm');
        } else {
            return Redirect::route('control.index')
                            ->with('message', 'ErrorDatabase');
        }
    }

    public function destroy()
    {
        if (Input::get('idEthm')) {
            $id       = Input::get('idEthm');
            $ed       = new EthmData();
            $response = $ed->delete($id);
            return Response::json($response);
        }
        return Response::json(FALSE);
    }

}
