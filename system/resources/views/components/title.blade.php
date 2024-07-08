<div class="header-title">
    @if(isset($post))
    @if($post->menu->id == 4 || $post->menu->id == 8 || $post->menu->id == 9 || $post->menu->id == 10 || $post->menu->id == 11 || $post->menu->id == 40)
    @if($breadcrumbs[1]->title == $post->title)
    <h1>{{ $breadcrumbs[0]->title }}</h1>
    @else
    <h1>{{ $breadcrumbs[1]->title }}</h1>
    @endif
    <div class="breadcrumb">
        <a href="{{ url('') }}">{{ __('breadcrumb.home') }}</a>
        @foreach($breadcrumbs as $key => $breadcrumb)  
        @if($key == (count($breadcrumbs)-1))
        <a>Detail</a>
        @else
        <a>{{ $breadcrumb->title }}</a>
        @endif
        @endforeach
    </div>
    @else
    @if(isset($breadcrumbs[1]->title))
    <h1>{{ $breadcrumbs[1]->title }}</h1>
    @elseif(isset($post->title))
    <h1>{{ $post->title }}</h1>
    @else
    <h1>{{ $menu->title }}</h1>
    @endif
    <div class="breadcrumb">
        <a href="{{ url('') }}">{{ __('breadcrumb.home') }}</a>
        @foreach($breadcrumbs as $breadcrumb)
        @if($breadcrumb->title != 'Page')
        <a>{{ $breadcrumb->title }}</a>
        @endif
        @endforeach
    </div>
    @endif
    @endif

    @if(isset($menu))
    @if($menu->id == 4 || $menu->id == 8 || $menu->id == 9 || $menu->id == 10 || $menu->id == 11 || $menu->id == 40)
    @if(isset($breadcrumbs[1]->title))
    <h1>{{ $breadcrumbs[1]->title }}</h1>
    @else
    <h1>{{ $breadcrumbs[0]->title }}</h1>
    @endif
    <div class="breadcrumb">
        <a href="{{ url('') }}">{{ __('breadcrumb.home') }}</a>
        @foreach($breadcrumbs as $breadcrumb)
        @if($breadcrumb->title != 'Page')
        <a>{{ $breadcrumb->title }}</a>
        @endif
        @endforeach
    </div>
    @else
    @if(isset($breadcrumbs[1]->title))
    <h1>{{ $breadcrumbs[1]->title }}</h1>
    @elseif(isset($post->title))
    <h1>{{ $post->title }}</h1>
    @else
    <h1>{{ $menu->title }}</h1>
    @endif
    <div class="breadcrumb">
        <a href="{{ url('') }}">{{ __('breadcrumb.home') }}</a>
        @foreach($breadcrumbs as $breadcrumb)
        @if($breadcrumb->title != 'Page')
        <a>{{ $breadcrumb->title }}</a>
        @endif
        @endforeach
    </div>
    @endif    
    @endif    
</div>