<?php

use League\Csv\Writer;

class IntegraEventsController extends \BaseController
{

    protected $event;

    public function __construct()
    {
        $this->event = new EventData();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function show($id)
    {
		$integraData = new IntegraData();
		$integra     = $integraData->find($id);
		Session::set('integra', $integra);		
		$hierarchy = new HierarchyController();
		$currRegionIdx = HierarchyController::getSessionData()->getQueryIdx();
		$data = View::make('integra/events')
                    ->with('sideRegionVars', $hierarchy->getSideRegionData())
                    ->with('navbarVars', $this->navbarVarsDefault())
                    ->with('listTitle', Lang::get('content.events'))
                            ->with('integra', $integra)
                            ->with('permUserIntegraSelect', UserPermissions::containsForRegion('EDTUSERINTEGRA', $integra->getQueryIdx())||UserPermissions::containsForRegion('SELUSERINTEGRA', $integra->getQueryIdx()))
                            ->with('permIntegraReport',UserPermissions::containsForRegion('RAPINTEGRA', $integra->getQueryIdx()))
                            ->with('permIntegraEdit',UserPermissions::containsForRegion('EDTINTEGRA', $integra->getQueryIdx()))
                            ->with('permIntegraManage',UserPermissions::containsForRegion('MANINTEGRA', $integra->getQueryIdx()))
                            ->with('permGuardx', UserPermissions::containsForRegion('MANGUARDX', $integra->getQueryIdx()))
							->with('permIntegraEvents', UserPermissions::containsForRegion('SELEVENTS', $integra->getQueryIdx()))
                            ->with('hierarchyName', $hierarchy->treeGetName($integra->getIdGroup()))
                    ->with('eventComments', UserPermissions::containsForRegion('COMLATEREVENTS', $currRegionIdx))
                    ->with('eventSource', $this->event->eventsourcelist())
                    ->with('eventType', $this->event->eventtypelist($currRegionIdx))
                    ->with('eventUsers', $this->event->eventuserlisttree(UserContext::getAllRegions(), HierarchyData::withChildren()>0))
                    ->with('currentHierarchy', HierarchyController::getSessionData())
                    ->with('helpcnt', 'ekran-zdarzenia.html');
        return $data;
    }

    public function eventDscrList()
    {
		$classes= Input::get("eventClasses");
		$response = $this->event->eventtypelist(empty($classes)?NULL:$classes);
        return Response::json($response);
    }

    public function eventUserList($idNow, $withChildrenNow)
    {
        return $this->event->eventuserlisttree($idNow, $withChildrenNow);
    }

    public function eventUserListByIntegra($idNow, $withChildrenNow)
    {
        $idTab = explode("_", $idNow);
        return $this->event->eventuserlistintegra($idTab, $withChildrenNow);
    }

    /**
     * Zwraca liste zdarzeń.
     *
     * @return Response
     */
    public function create()
    {
        $data = Input::all();
        if ($data['hierarchytree']==0||$data['hierarchytree']==null){
            $hd = new HierarchyData();
            $data['hierarchyIdx'] = $hd->getAllUserRegions();
        } else {
            $h = new Hierarchy($data['hierarchytree']);
            $data['hierarchyIdx']=[$h->getQueryIdx()];
        }   
        return $this->event->filter($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show2($id)
    {
       	$response = $this->event->eventsDetail($id);
        return Response::json($response);
    }
    public function addComment()
    {
        return json_encode($this->event->addComment(Input::get("id"), Input::get("comment")));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function filterCSV()
    {
        if (!Input::has('data')) {
            return null;
        }        
        set_time_limit(6000);
        $data=json_decode(Input::get('data'), true);
        $data["offset"]=0;
        $data["queryStartIdx"]="";
        $cp       = new EventData();
        $csv      = Writer::createFromFileObject(new SplTempFileObject());
        $csv->setDelimiter(";"); //the delimiter will be the tab character
        $csv->setNewline("\r\n"); //use windows line endings for compatibility with some csv libraries
        $csv->setOutputBOM(Writer::BOM_UTF8);
        $csv->insertOne(['data', 'typ', 'zdarzenie', 'szczegóły', 'użytkownik']);
        do {
            $response = $cp->csvSerialize($data);
            $csv->insertAll($response->list);
            $data["offset"]=$response->offset;
            $data["queryStartIdx"]=$response->queryIdx;
            Log::error($response->offset);
        }while (is_numeric ($response->offset) && $response->offset<1000);
        if ($response->offset>=1000){
            $csv->insertOne("LIMIT");
        }    
        $csv->output('EventList.csv');
    }


}
