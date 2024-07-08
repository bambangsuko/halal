@extends('layouts.base')

@section('content')
<div class="container">
    <div class="detail-menu">
        @include('components.breadcrumb', [
        'breadcrumbs' => $breadcrumbs
        ])
        <h1>{{ $menu->title }}</h1>
        @if(count($submenus) != 0 && count($posts) != 0)
        <div class="row">
            <div class="col-md-4">
                <div class="sidebar-button d-lg-none d-md-none">
                    <a href="#" onclick="showTabMenu(event)"><i class="fas fa-bars"></i> {{ __('menu.tab_menu') }}</a>
                </div>
                <div class="sidebar">
                    <h3>{{ $menu->title }}</h3>
                    <div class="first">
                        @foreach($submenus as $submenu)
                        <a href="{{ $submenu->type == 'menu' ? generateUrl($submenu->slug) : $submenu->link }}"><i class="fas fa-chevron-right"></i> {{ $submenu->title }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    @foreach($posts as $post)
                    <div class="col-md-6">
                        <a href="{{ generateUrl($post->slug) }}">
                            <div class="item">
                                <img src="{{ $post->cover ? asset($post->cover) : asset('files/no-image.jpg') }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
                                <div class="content">
                                    <h2>{{ $post->title }}</h2>
                                    <span>{{ $post->formatted_published_at }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @elseif(count($submenus) != 0 && count($posts) == 0)
        <div class="row">
            @forelse($submenus as $submenu)
            <div class="col-lg-4 col-md-6">
                <a href="{{ $submenu->type == 'menu' ? generateUrl($submenu->slug) : $submenu->link }}">
                    <div class="item">
                        <img src="{{ $submenu->cover ? asset($submenu->cover) : asset('files/no-image.jpg') }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
                        <div class="content">
                            <h2>{{ $submenu->title }}</h2>
                            <span>{{ $submenu->formatted_published_at }}</span>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 d-flex justify-content-center align-items-center no-data">
                <h3>{{ __('search.no_data') }}</h3>
            </div>
            @endforelse
        </div>
        {{ $submenus->links('components.pagination') }}
        @elseif(count($submenus) == 0 && count($posts) != 0)
        <div class="row">
            @forelse($posts as $post)
            <div class="col-lg-4 col-md-6">
                <a href="{{ generateUrl($post->slug) }}">
                    <div class="item">
                        <img src="{{ $post->cover ? asset($post->cover) : asset('files/no-image.jpg') }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
                        <div class="content">
                            <h2>{{ $post->title }}</h2>
                            <span>{{ $post->formatted_published_at }}</span>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 d-flex justify-content-center align-items-center no-data">
                <h3>{{ __('search.no_data') }}</h3>
            </div>
            @endforelse
        </div>
        {{ $posts->links('components.pagination') }}
        @else
        <div class="d-flex justify-content-center align-items-center no-data">
            <h3>{{ __('search.no_data') }}</h3>
        </div>
        @endif
    </div>
</div>
@endsection