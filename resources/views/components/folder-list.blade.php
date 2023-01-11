<ul class="navigation">
    @foreach($navigation->_embedded->items as $item)
        <ul class="navigation">
            @if($item->type == 'dir')
                <li>
                    <p class="nav-item js-open-nav" data-folder="{{$item->path}}">{{$item->name}}</p>
                    <div class="subnav-items"></div>
                </li>
            @else
                <li>
                    <p class="nav-item">{{$item->name}}</p>
                </li>
            @endif
        </ul>
    @endforeach
</ul>
