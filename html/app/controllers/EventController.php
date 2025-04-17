<?php

use League\Csv\Writer;

class EventController extends \BaseController
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
    public function index()
    {
		$hierarchy = new HierarchyController();
        $currRegionIdx = HierarchyController::getSessionData()->getQueryIdx();
        $archive = $this->event->archive();
		$data = View::make('event/index')
                    ->with('sideRegionVars', $hierarchy->getSideRegionData())
                    ->with('navbarVars', $this->navbarVarsDefault())
                    ->with('listTitle', Lang::get('content.events'))
                    ->with('eventComments', UserPermissions::containsForRegion('COMLATEREVENTS', $currRegionIdx))
                    ->with('eventSource', $this->event->eventsourcelist())
                    ->with('eventType', $this->event->eventtypelist($currRegionIdx))
                    ->with('eventUsers', $this->event->eventuserlisttree(UserContext::getAllRegions(), HierarchyData::withChildren()>0))
                    ->with('currentHierarchy', HierarchyController::getSessionData())
                    ->with('helpcnt', 'ekran-zdarzenia.html')
                    ->with('archive', $archive>0?'':'hidden')
                    ->with('archivePanel', $archive>0?'ev-archive':'');
        return $data;
    }

    public function management()
    {
		$hierarchy = new HierarchyController();
        $currRegionIdx = HierarchyController::getSessionData()->getQueryIdx();
        $archive = $this->event->archive();
		$data = View::make('event/manage')
                    ->with('sideRegionVars', $hierarchy->getSideRegionData())
                    ->with('navbarVars', $this->navbarVarsDefault())
                    ->with('eventUsers', $this->event->eventuserlisttree(UserContext::getAllRegions(), HierarchyData::withChildren()>0))
                    ->with('permEventArchive', 1)
                    ->with('days', $this->event->archivedays())
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

    private function transformHierarchyInputData($data) {
      if ($data['hierarchytree']==0||$data['hierarchytree']==null){
          $hd = new HierarchyData();
          $data['hierarchyIdx'] = $hd->getAllUserRegions();
      } else {
          $h = new Hierarchy($data['hierarchytree']);
          $data['hierarchyIdx']=[$h->getQueryIdx()];
      }
      return $data;
    }
    /**
     * Zwraca liste zdarzeń.
     *
     * @return Response
     */
    public function create()
    {
        $data = $this->transformHierarchyInputData(Input::all());
        return $this->event->filter($data);
    }

    /**
     * 
     * @return Response
     */
    public function storearchive()
    {
        return $this->event->savearchivedays(Input::all()["value_"]);
    }

    public function doarchive()
    {
        return $this->event->doarchive();
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
    public function show($id)
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
        $data = $this->transformHierarchyInputData($data);
        $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=EventList.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];
        $callback = function() use ($data) {
          $cp       = new EventData($data);
          $FH = fopen('php://output', 'w');
          $bom = pack("C3",0xEF,0xBB,0xBF);
          fwrite($FH, $bom, 3);
          fputcsv($FH, [Lang::get('content.list-date'), Lang::get('content.class'), Lang::get('content.description'), Lang::get('content.list-source') , Lang::get('content.user')],";");
          do {
              $response = $cp->csvSerialize($data);
              //$csv->insertAll($response->list);
              foreach ($response->list as $row) {
                  fputcsv($FH, $row,";");
              }
              $data["offset"]=$response->offset;
              $data["queryStartIdx"]=$response->queryIdx;
              Log::error($response->offset);
          }while (is_numeric ($response->offset) && $response->offset<1000);
          if ($response->offset>=1000){
              fputcsv($FH, ["LIMIT"],";");
          }
          fclose($FH);
        };
        return Response::stream($callback, 200, $headers);
    }

    function removearchive() {
        $utype = substr(Input::get("eventUsers"), 0, 1);
        $idIntegra = Input::get("controlList");
        $userId = substr(Input::get("eventUsers"), 1);
        $newName = (Input::get("renameDelete") == "rename")?Input::get("new-name"):NULL;
        if ($utype == "I") {
            $this->event->renameIntegraArchive($idIntegra, $userId, $newName);
        } else {
            $this->event->renameUserArchive($userId, $newName);
        }
		return Redirect::route('event.management')->with('message', 'action');
    }
}
