@extends('layouts.base')

@section('content')
<div class="container">
    <div class="detail-menu">
        <div class="bc">
            <a href="{{ url('') }}">{{ __('breadcrumb.home') }} <i class="fas fa-chevron-right"></i></a>
            <a href="#" class="active">{{ __('search.search_result') }}</a>
        </div>
        <h1>{{ __('search.search_result') }}</h1>
        <div class="row">
            @forelse($posts as $post)
            <div class="col-md-4">
                <a href="{{ generateUrl($post->slug) }}">
                    <div class="item">
                        <img src="{{ asset($post->cover) }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
                        <div class="content">
                            <h2>{{ $post->title }}</h2>
                            <span>{{ $post->created_at->format('d F Y') }}</span>
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
        {{ $posts->appends([
            'keyword' => request('keyword')
            ])->links('components.pagination') }}
    </div>
</div>
@endsection