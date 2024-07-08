<div class="section-header-breadcrumb">
    <div class="breadcrumb-item"><a href="{{ url('cp') }}">Dashboard</a></div>
    @foreach($breadcrumbs as $key => $breadcrumb)
    @if($key == (count($breadcrumbs)-1))
    <div class="breadcrumb-item">{{ $breadcrumb->title }}</div>
    @elseif($key == 0)
    <div class="breadcrumb-item"><a href="{{route("cp.menus.show",$breadcrumb->id)}}">{{ $breadcrumb->title }}</a></div>
    @else
    <div class="breadcrumb-item"><a href="{{route('cp.menus.submenus.show',[$breadcrumb->parent->id,$breadcrumb->id])}}">{{ $breadcrumb->title }}</a></div>
    @endif
    @endforeach
</div>