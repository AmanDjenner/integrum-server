            <div id="wrapper-backdrop" class=""></div>
            <div id="wrapper" class="">
                <div id="sidebar-wrapper" style="margin-left: -240px;">
                    <div class="sidebar-nav" id="sidebar">{[ $tree ]}</div>
                    <div class="btn-group fixed-btns fixed-btns-x" role="group" id="sidebar-btns">
                        <button id="togglechildren" class="btn btn-default region-edit" title="{[Lang::get('content.withChildren')]}"><i class="fa {[$hierarchyOn?'fa-toggle-on':'fa-toggle-off' ]}"></i></button>
                    </div>
					<span style="display:none" id="currentRegionHierarchy" data-currenthierarchy='{[ json_encode($currentHierarchy) ]}'></span>
                </div>
            </div>