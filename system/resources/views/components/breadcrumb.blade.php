<div class="bc">
    <a href="{{ url('') }}">{{ __('breadcrumb.home') }} <i class="fas fa-chevron-right"></i></a>
    @foreach($breadcrumbs as $breadcrumb)
    <a href="{{ generateUrl($breadcrumb->slug) }}" @if($loop->last){{'class=active'}}@endif>{{ $breadcrumb->title }} @if(!($loop->last))<i class="fas fa-chevron-right">@endif</i></a>
    @endforeach
</div>