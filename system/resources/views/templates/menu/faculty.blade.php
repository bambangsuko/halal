@extends('layouts.base')

@section('content')
<div class="container">
    <div class="faculty-detail">
        @include('components.breadcrumb', [
        'breadcrumbs' => $breadcrumbs
        ])
        <div class="row highlight">
            <div class="col-lg-6">
                <h1>{{ $menu->title }}</h1>
                {!! $menu->description !!}
            </div>
            <div class="col-lg-6">
                <img class="banner-img w-100" src="{{ $menu->cover ? asset($menu->cover) : asset('files/no-image.jpg') }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
                <div class="detail">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="table-fit">{{ __('faculty.address') }}</td>
                            <td class="table-fit">:</td>
                            <td>{{ $menu->address }}</td>
                        </tr>
                        <tr>
                            <td class="table-fit">{{ __('faculty.phone') }}</td>
                            <td class="table-fit">:</td>
                            <td>{{ $menu->phone }}</td>
                        </tr>
                        <tr>
                            <td class="table-fit">{{ __('faculty.fax') }}</td>
                            <td class="table-fit">:</td>
                            <td>{{ $menu->fax }}</td>
                        </tr>
                        <tr>
                            <td class="table-fit">{{ __('faculty.email') }}</td>
                            <td class="table-fit">:</td>
                            <td>{{ $menu->email }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('faculty.website') }}</td>
                            <td>:</td>
                            <td>{{ $menu->website }}</td>
                        </tr>
                    </table>
                    <a href="https://{{ $menu->website }}" class="btn btn-black">{{ __('faculty.visit_website') }}</a>
                </div>
            </div>
        </div>
        @if(count($menu->posts) != 0)
        <div class="major">
            <h2>Program Studi</h2>
            <div class="row">
                @foreach($menu->posts as $post)
                <div class="col-md-3">
                    <div class="item">
                        <img src="{{ $post->cover ? asset($post->cover) : asset('files/no-image.jpg') }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';" class="w-100">
                        <div class="content">
                            <a href="{{ generateUrl($post->slug) }}">{{ $post->title }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection