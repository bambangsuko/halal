@extends('layouts.base')

@section('content')
<div class="container page">
    <div class="about">
        @include('components.breadcrumb', [
        'breadcrumbs' => $breadcrumbs
        ])
        <div class="row">
            <div class="col-lg-4">
                <div class="sidebar-button d-lg-none">
                    <a href="#" onclick="showTabMenu(event)"><i class="fas fa-bars"></i> {{ __('menu.tab_menu') }}</a>
                </div>
                <div class="sidebar">
                    <h3>{{ $menu->title }}</h3>
                    <div class="first">
                        @foreach($menu->submenus as $submenu)
                        <a href="{{ $submenu->type == 'menu' ? generateUrl($submenu->slug) : $submenu->link }}"><i class="fas fa-chevron-right"></i> {{ $submenu->title }}</a>
                        @if(isset($submenu->posts))
                        <div class="second">
                            @endif
                            @foreach($submenu->posts as $item)
                            <a href="{{ generateUrl($item->slug) }}"><i class="fas fa-chevron-right"></i> {{ $item->title }}</a>
                            @endforeach
                            @if(isset($submenu->posts))
                        </div>
                        @endif
                        @endforeach
                        @foreach($menu->posts as $p)
                        <a href="{{ generateUrl($p->slug) }}"><i class="fas fa-chevron-right"></i> {{ $p->title }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="content">
                    <h2>{{ $post->title }}</h2>
                    @if(isset($post->cover))
                    <img src="{{ asset($post->cover) }}" alt="{{ $post->title }}" class="w-100">
                    @endif
                    {!! $post->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection