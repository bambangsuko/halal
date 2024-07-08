<div class="col-md-4 d-none d-md-block d-lg-block">
    @if($post->menu->id == 4 || $post->menu->id == 8 || $post->menu->id == 9 || $post->menu->id == 10 || $post->menu->id == 11)
    <div class="sidebar">
        <ul>
            <li class="active"><a href="{{ generateUrl($post->menu->slug) }}">{{ $post->menu->title }}</a></li>
            <li><a href="{{ url('') }}">{{ __('breadcrumb.home') }}</a></li>
        </ul>
    </div>
    @elseif($post->menu->id == 40)
    <div class="sidebar">
        <ul>
            @foreach($post->menu->parent->submenu as $submenu)
            <li {{ $submenu->id == $post->menu->id ? 'class=active' : '' }}><a href="{{ generateUrl($submenu->slug) }}">{{ $submenu->title }}</a></li>
            @endforeach
            <li><a href="{{ url('') }}">{{ __('breadcrumb.home') }}</a></li>
        </ul>
    </div>
    @else
    <div class="sidebar">
        <ul>
            @foreach($sidebars->posts as $key => $sidebar)
            <li {{ $sidebar->title == $post->title ? 'class=active' : '' }}><a href="{{ generateUrl($sidebar->slug) }}">{{ $sidebar->title }}</a></li>
            @endforeach
            <li><a href="{{ url('') }}">{{ __('breadcrumb.home') }}</a></li>
        </ul>
    </div>
    @endif
</div>