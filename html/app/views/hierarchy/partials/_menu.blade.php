<ul class="tree-menu" >
    @foreach($hierarchyTreeList as $hierarchyTree)
    @if(isset($hierarchyTree))
    <li>
        <span>
            <i class="fa fa-caret-down"></i><a href="{[ URL::to('#' . $hierarchyTree->id) ]}" data-value="{[ $hierarchyTree->id ]}" >{[ $hierarchyTree->name ]}</a>
        </span>
        @if(isset($hierarchyTree->hierarchyTreeList))
        @include('hierarchy.partials._menu', ['hierarchyTreeList' => $hierarchyTree->hierarchyTreeList] )
        @endif
    </li>
    @endif
    @endforeach
</ul>
