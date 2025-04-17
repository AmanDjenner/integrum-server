<?php

use League\Csv\Writer;

class IntegraController extends \BaseController
{

    private static $addLink = '/control/createstart';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $hierarchy = new HierarchyController();
        $currRegion = HierarchyController::getSessionData();
        $data = View::make('integra.index')
                ->with('sideRegionVars', $hierarchy->getSideRegionData())
                ->with('navbarVars', $this->navbarVarsDefault())
                ->with('listTitle', Lang::get('content.panels'))
                ->with('customButtons',
                        Config::get('parameters.EthmNewServer', false) ? '<a href="/ethm/" class="btn-ethm"><span class="fa fa-2 fa-server" aria-hidden="true"></span></a>' : '')
                ->with('currentHierarchy', $currRegion)
                ->with('helpcnt', 'ekran_centrale.html');
        $data = $this->message($data);
        if (UserPermissions::containsForRegion('CREINTEGRA', $currRegion->getQueryIdx())) {
            $data = $data->with('addLink', self::$addLink);
        }
        return $data;
    }

    private function transformHierarchyTree($data){
        if ($data['hierarchytree']==0||$data['hierarchytree']==null){
            $hd = new HierarchyData();
            $data['hierarchyIdx'] = $hd->getAllUserRegions();
        } else {
            $h = new Hierarchy($data['hierarchytree']);
            $data['hierarchyIdx']=[$h->getQueryIdx()];
        }            
        return $data;
    }
    
    public function filter()
    {
        $cp = new ControlPanels();
        $data = $this->transformHierarchyTree(Input::all());
        $cp->filtered($data);
//      $cp->jsonSerialize();
        return Response::json($cp);
    }

    public function filterCSV()
    {
        if (!Input::has('data')) {
            return null;
        }
        $cp       = new ControlPanels();
        $data = $this->transformHierarchyTree(json_decode(Input::get('data'), true));
        $cp->filtered($data);
        $response = $cp->csvSerialize();
        $csv      = Writer::createFromFileObject(new SplTempFileObject());
        $csv->setDelimiter(";"); //the delimiter will be the tab character
        $csv->setNewline("\r\n"); //use windows line endings for compatibility with some csv libraries
        $csv->setOutputBOM(Writer::BOM_UTF8);
        $csv->insertOne(['id', 'Nazwa', 'IP', 'port']);
        $csv->insertAll($response);
        $csv->output('ControlList.csv');
    }

    public function findByName()
    {
        $name = Input::get('name');
        try {
            $cp = new ControlPanels();
			
            $findParameters = ['integra' => $name,
		'withChildren' => HierarchyData::withChildren()>0,
                'hierarchyIdx' => HierarchyData::getCurrentQueryIdx()];
            $cp->filtered($findParameters);
        } catch (Exception $exc) {
            Log::error($exc);
            return Response::json([]);
        }
        return $cp->jsonSerialize(HierarchyData::getCurrentQueryIdx());
    }

    public function jsonControlList($id, $withchilds = false)
    {
        $cp = new ControlPanels();
        $h = new Hierarchy($id);	
        return Response::json($cp->integralist([$h->getQueryIdx()], $withchilds));
    }

    public function integraStructureTree($idNow, $withCards = null)
    {
        $idTab = explode(",", $idNow);
        if (1 == count($idTab)) {
            $cp = new ControlPanels();
            return $cp->integrastructuretree($idNow, $withCards);
        }
        return NULL;
    }

    public function integraStructureTreeFull($idNow)
    {
        $idTab = explode(",", $idNow);
        if (1 == count($idTab)) {
            $cp = new ControlPanels();
            return $cp->integraStructureWithZonesTree($idNow);
        }
        return NULL;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $ethmData = new EthmData();
        $currRegion = HierarchyController::getSessionData();
		$hierarchy = new HierarchyController();
        if (Session::has('integra_1')) {
            $ethmerrors = (Session::has('ethmerrors')) ? Session::get('ethmerrors') : 0;
            $ethm       = $ethmData->ethmListTab(array());
            $data       = View::make('integra.create_ethm')
					->with('sideRegionVars', $hierarchy->getSideRegionData())
					->with('navbarVars', $this->navbarVarsDefault())
                    ->with('ethmerrors', $ethmerrors)
                    ->with('ethm', $ethm)
                    ->with('type', Session::get("type"))
					->with('currentHierarchy', $currRegion)
					->with('helpcnt', 'dodanie-nowej-centrali.html');
            return $this->message($data);
        } elseif (Session::has('integra_2')) {
            return $this->createCompleted(Session::get('integra_2'), $currRegion);
        }
        $storeXcxValid = (Session::has('storeXcx')) ? 'true' : 'false';
        $view          = (Config::get('parameters.IntegraXcx', false)) ? 'integra.create_select' : 'integra.create';
        $data          = View::make($view)
				->with('sideRegionVars', $hierarchy->getSideRegionData())
				->with('navbarVars', $this->navbarVarsDefault())
                ->with('storeXcxValid', $storeXcxValid)
				->with('currentHierarchy', $currRegion)
					->with('helpcnt', 'dodanie-nowej-centrali.html');
        return $this->message($data);
    }

    public function createStart()
    {
        Session::forget('integra_1');
        return Redirect::route('control.create');
    }

    public function createCompleted($integra, $currRegion)
    {
		$hierarchy = new HierarchyController();
		$data = View::make('integra.create_completed')
				->with('sideRegionVars', $hierarchy->getSideRegionData())
				->with('navbarVars', $this->navbarVarsDefault())
                ->with('addLink', self::$addLink)
                ->with('idIntegra', $integra)
				->with('currentHierarchy', $currRegion);
        return $this->message($data);
    }

    public function storeValid()
    {
        $integra = new IntegraData();
        $integra->fill(Input::all());
        if (!$integra->isValid()) {
            return Redirect::back()->withInput()->withErrors($integra->errors());
        }
        Session::put('integra_1', $integra);
        return Redirect::back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $integradata = Session::get('integra_1');
        $integra     = $integradata->getData();
        $integraEthm = Input::get('ethm');
        $integra->setIntegraEthm($integraEthm);

        if (!$integradata->isValid()) {
            return Redirect::back()->withInput()->withErrors($integradata->errors());
        }
        Session::forget('integra_1');
        $result    = $integradata->save();
        $message   = 'ErrorDatabase';
        $idIntegra = 0;
        if (Config::get('parameters.RESULT_OK') == $result->result || Config::get('parameters.RESULT_WARNING') == $result->result) {
            $message   = 'addPanel';
            $idIntegra = $result->id;
        }
        return Redirect::back()->with('message', $message)->with('integra_2',
                        $idIntegra);
    }

    public function storeXcx()
    {
        $integra = new IntegraXcx();
        $integra->fill(Input::only('xcx', 'name', 'idGroup', 'xcxCode', 'online'),
                TRUE);
        if (!$integra->isValid()) {
            return Redirect::back()->withInput()->withErrors($integra->errors())->with('storeXcx',
                            true);
        }
        $result = $integra->save(1);
        $this->storeFireBird($result, $integra);
        return $this->redirect($result);
    }

    private function storeFireBird($result, IntegraXcx $integra)
    {
        if (1 != $result->result) {
            return FALSE;
        }
        $data = array('id'    => $result->id,
            'typ'   => $result->type,
            'plus'  => $result->plus,
            'name'  => $integra->name,
            'data1' => $integra->getXcx(),
            'grupa' => $integra->idGroup
        );
        IntegraAddFireBird::add($data);
    }

    private function redirect($result)
    {
        if (1 != $result->result) {
            return Redirect::back()->withInput()->with('message',
                            'ErrorDatabase');
        }

        if (Input::get('create')) {
            return Redirect::route('control.create')
                            ->with('message', 'addPanel');
        } else {
            return Redirect::route('control.edit', array('id' => $result->id))
                            ->with('message', 'addPanel');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $integraData = new IntegraData();
        $integra     = $integraData->find($id);
        return Response::json($integra->getData());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $integraData = new IntegraData();
        $integra     = $integraData->find($id);
        if (null == $integra) {
            return Redirect::route('control.index')
                            ->with('message', 'app');
        }
        $hierarchy = new HierarchyController();
        $currRegion = HierarchyController::getSessionData();
        $ethm = new EthmData();
        $data = View::make('integra.edit')
            ->with('sideRegionVars', $hierarchy->getSideRegionData())
            ->with('navbarVars', $this->navbarVarsDefault())
            ->with('permUserIntegraSelect', UserPermissions::containsForRegion('EDTUSERINTEGRA', $currRegion->getQueryIdx()) || UserPermissions::containsForRegion('SELUSERINTEGRA', $currRegion->getQueryIdx()))
            ->with('permUserIntegraEdit', UserPermissions::containsForRegion('EDTUSERINTEGRA', $currRegion->getQueryIdx()))
            ->with('permIntegraReport', UserPermissions::containsForRegion('RAPINTEGRA', $currRegion->getQueryIdx()))
            ->with('permIntegraEdit', UserPermissions::containsForRegion('EDTINTEGRA', $currRegion->getQueryIdx()))
            ->with('permIntegraManage', UserPermissions::containsForRegion('MANINTEGRA', $currRegion->getQueryIdx()))
            ->with('permGuardx', UserPermissions::containsForRegion('MANGUARDX', $currRegion->getQueryIdx()))
            ->with('integra', $integra)
            ->with('permIntegraEvents', UserPermissions::containsForRegion('SELEVENTS', $integra->getQueryIdx()))
            ->with('ethm',  Config::get('parameters.EthmNewServer', false) ? $ethm->ethmListTab($integra->getIntegraEthm()) : $integra->getIntegraEthm()["nameEthm"] )
            ->with('currentHierarchy', $currRegion)
            ->with('hierarchyName', $hierarchy->treeGetName($integra->getIdGroup()))
            ->with('helpcnt', 'ekran-z-danymi-centrali.html#ogolne');
        return $this->message($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input       = Input::all();
        $input['id'] = $id;
        $integra     = new IntegraData();
        $integra->fill($input);
        if (!$integra->isValid()) {
            return Redirect::back()->withInput()->withErrors($integra->errors());
        }
        $result = $integra->update();
        if (Config::get('parameters.RESULT_OK') == $result->result) {
            return Redirect::route('control.edit', array('id' => $id))
                            ->with('message', 'updateappuser');
        } else {
            if (Config::get('parameters.RESULT_ERROR') == $result->result) {
                return Redirect::route('control.index')
                                ->with('message', 'ErrorDatabase');
            } else {
                return Redirect::route('control.index')
                                ->with('message', 'integraErrorAction');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy()
    {
        if (Input::get('idIntegra')) {
            $id       = Input::get('idIntegra');
            $integra  = new IntegraData();
            $response = $integra->delete($id);
            return Response::json($response);
        }
        return Response::json(FALSE);
    }

    public function startGuardX()
    {
            $id       = Input::get('idIntegra');
            $integra  = new IntegraData();
            $response = $integra->startGuardX($id);
            return Redirect::away($response);
    }

    public function clearAlarm()
    {
        if (Input::get('idIntegra')) {
            $id       = Input::get('idIntegra');
            $integra  = new IntegraData();
            $response = $integra->clearAlarm($id);
            return Response::json($response);
        }
        return Response::json(FALSE);
    }

    public function clearTrouble()
    {
        if (Input::get('idIntegra')) {
            $id       = Input::get('idIntegra');
            $integra  = new IntegraData();
            $response = $integra->clearTrouble($id);
            return Response::json($response);
        }
        return Response::json(FALSE);
    }

    public function arm()
    {
        if (Input::get('idIntegra')) {
            $id       = Input::get('idIntegra');
            $integra  = new IntegraData();
            $response = $integra->arm($id);
            return Response::json($response);
        }
        return Response::json(FALSE);
    }

    public function disArm()
    {
        if (Input::get('idIntegra')) {
            $id       = Input::get('idIntegra');
            $integra  = new IntegraData();
            $response = $integra->disArm($id);
            return Response::json($response);
        }
        return Response::json(FALSE);
    }
}
