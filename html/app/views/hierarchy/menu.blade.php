<ul class="tree-menu" id="tree-menu" >
    @if(!is_array($hierarchyTreeList))
    <li>
        <span>
            <i class="fa fa-caret-down"></i><a id="tree-menu-a{[$hierarchyTreeList->id]}" href="{[ URL::to('#' . $hierarchyTreeList->id) ]}" data-value="{[ $hierarchyTreeList->id ]}">{[ $hierarchyTreeList->name ]}</a>
        </span>
        @if(isset($hierarchyTreeList->hierarchyTreeList))
        @include('hierarchy.partials._menu', ['hierarchyTreeList' => $hierarchyTreeList->hierarchyTreeList] )
        @endif
    </li>
    @else 
        @if(isset($hierarchyTreeList))
        @include('hierarchy.partials._menu', ['hierarchyTreeList' => $hierarchyTreeList] )
        @endif
    @endif
</ul>