@if(isset($post))
@php
$title = $post->title;
$description = Str::limit(strip_tags($post->description), 200);
$image = !empty($post->cover) ? asset($post->cover) : asset('assets/img/nocover.png');
$url = generateUrl($post->slug);
@endphp
@elseif(isset($menu))
@php
$title = $menu->title;
$description = Str::limit(strip_tags($menu->description), 200);
$image = !empty($menu->cover) ? asset($menu->cover) : asset('assets/img/nocover.png');
$url = generateUrl($menu->slug);
@endphp
@else
@php
$title = data_get($setting, 'name', '-');
$description = strip_tags(data_get($setting, 'tagline', '-'));
$image = asset(data_get($setting, 'icon', '-'));
$url = generateUrl('');
@endphp
@endif

        <meta name="description" content="{{ strip_tags(data_get($setting, 'tagline', '-')) }}"/>
        <meta name="author" content="{{ data_get($setting, 'name', '-') }}" />
        <meta name="copyright" content="{{ data_get($setting, 'name', '-') }}" />
        <meta name="application-name" content="{{ data_get($setting, 'name', '-') }}" />

        <meta property="og:title" content="{{ $title }}" />
        <meta property="og:type" content="article" />
        <meta property="og:image" content="{{ $image }}" />
        <meta property="og:image:alt" content="{{ $title }}" />
        <meta property="og:image:width" content="500" />
        <meta property="og:image:height" content="500" />
        <meta property="og:url" content="{{ $url }}" />
        <meta property="og:description" content="{{ $description }}" />

        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="{{ $title }}" />
        <meta name="twitter:description" content="{{ $description }}" />
        <meta name="twitter:image" content="{{ $image }}" />