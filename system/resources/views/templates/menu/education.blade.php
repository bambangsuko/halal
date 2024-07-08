@extends('layouts.base')

@section('content')
<div class="container page">
    <div class="education">
        @include('components.breadcrumb', [
        'breadcrumbs' => $breadcrumbs
        ])
        <div class="row highlight">
            <div class="col-lg-6">
                <h1>{{ $menu->title }}</h1>
                {!! $menu->description !!}
            </div>
            <div class="col-lg-6">
                <img class="banner-img" src="{{ $menu->cover ? asset($menu->cover) : asset('files/no-image.jpg') }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
            </div>
        </div>
        @foreach($menu->submenus as $submenu)
        @if($loop->first)
        <h2>{{ $submenu->title }}</h2>
        <div class="row">
            <div class="col-md-8">
                {!! $submenu->description !!}
            </div>
        </div>
        <div class="row faculty">
            @foreach($submenu->submenus as $sub)
            <div class="col-md-6 col-lg-4">
                <div class="item">
                    <img src="{{ $sub->cover ? asset($sub->cover) : asset('files/no-image.jpg') }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';" class="w-100">
                    <div class="title">
                        <a href="{{ generateUrl($sub->slug) }}">{{ $sub->title }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <h2>{{ $submenu->title }}</h2>
        <div class="row unit">
            @foreach($submenu->posts as $post)
            <div class="col-md-6 col-lg-3">
                <div class="item">
                    <img src="{{ $post->cover ? asset($post->cover) : asset('files/no-image.jpg') }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';" class="w-100">
                    <div class="content">
                        <h3>{{ $post->title }}</h3>
                        <a href="{{ generateUrl($post->slug) }}">{{ __('education.detail') }} <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        @endforeach
    </div>
</div>
@endsection