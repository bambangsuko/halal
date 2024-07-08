@extends('layouts.base')

@section('content')
<div class="container page">
    <div class="about">
        @include('components.breadcrumb', [
        'breadcrumbs' => $breadcrumbs
        ])
        <div class="row highlight">
            <div class="col-lg-6">
                <h1>{{ $menu->title }}</h1>
                {!! $menu->description !!}
            </div>
            <div class="col-lg-6">
                <img class="banner-img" src="{{ $menu->cover ? asset($menu->cover) : asset('files/no-image.jpg') }}" alt="{{ $menu->title }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="sidebar-button d-lg-none">
                    <a href="#" onclick="showTabMenu(event)"><i class="fas fa-bars"></i> {{ __('menu.tab_menu') }}</a>
                </div>
                <div class="sidebar">
                    <h3>{{ $menu->title }}</h3>
                    <div class="first">
                        @foreach($submenus as $submenu)
                        <a href="{{ $submenu->type == 'menu' ? generateUrl($submenu->slug) : $submenu->link }}"><i class="fas fa-chevron-right"></i> {{ $submenu->title }}</a>
                        @if(isset($submenu->posts))
                        <div class="second">
                            @endif
                            @foreach($submenu->posts as $post)
                            <a href="{{ generateUrl($post->slug) }}"><i class="fas fa-chevron-right"></i> {{ $post->title }}</a>
                            @endforeach
                            @if(isset($submenu->posts))
                        </div>
                        @endif
                        @endforeach
                        @foreach($posts as $post)
                        <a href="{{ generateUrl($post->slug) }}"><i class="fas fa-chevron-right"></i> {{ $post->title }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            @if(isset($posts[0]))
            <div class="col-lg-8">
                <div class="content">
                    <h2>{{ $posts[0]->title }}</h2>
                    @if(isset($posts[0]->cover))
                    <img src="{{ $posts[0]->cover ? asset($posts[0]->cover) : asset('files/no-image.jpg') }}" alt="{{ $posts[0]->title }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';" class="w-100">
                    @endif
                    {!! $posts[0]->description !!}
                </div>
            </div>
            @elseif(isset($menu->submenus[0]->posts[0]))
            <div class="col-lg-8">
                <div class="content">
                    <h2>{{ $menu->submenus[0]->posts[0]->title }}</h2>
                    @if(isset($menu->submenus[0]->posts[0]->cover))
                    <img src="{{ $menu->submenus[0]->posts[0]->cover ? asset($menu->submenus[0]->posts[0]->cover) : asset('files/no-image.jpg') }}" alt="{{ $menu->submenus[0]->posts[0]->title }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';" class="w-100">
                    @endif
                    {!! $menu->submenus[0]->posts[0]->description !!}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection