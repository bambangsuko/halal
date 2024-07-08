@extends('layouts.base')

@section('content')
@if(data_get($setting, 'homepage_banner', '-') == 'video')
<video class="video" muted="muted" autoplay="" loop="">
    <source src="{{ asset(data_get($setting, 'video', '-')) }}" type="video/webm">
</video>
@else
<div id="slider" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @forelse($sliders as $key => $slider)
        <div class="carousel-item{{ $key == 0 ? ' active' : '' }}" data-interval="3000">
            <img class="d-block w-100" src="{{ $slider->image }}" alt="{{ $slider->caption }}">
            <div class="carousel-caption d-none d-md-block">
                @if($slider->caption)
                <h1>{{ $slider->caption }}</h1>
                @endif
                @if($slider->link)
                <a class="btn btn-success mt-4" href="{{ $slider->link }}">{{ __('homepage.read_more') }}</a>
                @endif
            </div>   
        </div>
        @empty
        <div class="item">
            <div class="d-flex">
                <img src="{{ asset('files/no-image.jpg') }}" alt="Selamat Datang di Website">
                <div class="caption">
                    <h1>Selamat Datang di Website {{ data_get($setting, 'name', '-') }}</h1>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    <a class="carousel-control-prev" href="#slider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#slider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
@endif
@if(count($homemenus) != 0)
<div class="container home">
    @if(count($latestnews) != 0)
    <div class="latest-news">
        <div class="row">
            @foreach($latestnews->chunk(1) as $news)
            @foreach($news as $item)
            @if($loop->parent->first)
            <div class="col-md-5">
                <img class="latest-img" src="{{ $item->cover ? asset($item->cover) : asset('files/no-image.jpg') }}" alt="{{ $item->title }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
            </div>
            <div class="col-md-7">
                <h1>{{ __('homepage.latest_news') }}</h1>
                <div class="latest">
                    <h3>{{ $item->formatted_published_at }}</h3>
                    <h2>{{ $item->title }}</h2>
                    <p>{!! Str::limit(strip_tags($item->description), 450) !!}</p>
                    <a href="{{ generateUrl($item->slug) }}">{{ __('homepage.read_more') }}</a>
                </div>
            </div>
            @else
            <div class="col-md-4">
                <div class="item">
                    <img src="{{ $item->cover ? asset($item->cover) : asset('files/no-image.jpg') }}" alt="{{ $item->title }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
                    <div class="content">
                        <h3>{{ $item->formatted_published_at }}</h3>
                        <h2>{{ $item->title }}</h2>
                        <a href="{{ generateUrl($item->slug) }}">{{ __('homepage.read_more') }}</a>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @endforeach
        </div>
        <div class="w-100 text-center">
            <a href="{{ generateUrl($latestnews[0]->menu->slug) }}" class="btn btn-black">{{ __('homepage.more_news') }}</a>
        </div>
    </div>
    @endif
</div>
@endif
<div class="container home">
    <div class="post">
        <div class="row justify-content-center">
            @foreach($homemenus as $key => $homemenu)
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h2>{{ $homemenu->title }}</h2>
                    <a class="other" href="{{ generateUrl($homemenu->slug) }}">{{ __('homepage.other') }} <i class="fas fa-chevron-right"></i></a>
                </div>
                @if(isset($homemenu->posts[0]))
                <div class="item shadow">
                    <img src="{{ $homemenu->posts[0]->cover ? asset($homemenu->posts[0]->cover) : asset('files/no-image.jpg') }}" alt="{{ $homemenu->posts[0]->title }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
                    <div class="text">
                        <h3>{{ $homemenu->posts[0]->title }}</h3>
                    </div>
                    <a href="{{ generateUrl($homemenu->posts[0]->slug) }}">{{ __('homepage.read_more') }}</a>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@if(count($onhomemenus) != 0)
<div class="container home">
    @foreach($onhomemenus as $menuhome)
    <div class="menu-home">
        <div class="row row-highlight">
            <div class="col-md-5">
                <img class="highlight-img" src="{{ $menuhome->cover ? asset($menuhome->cover) : asset('files/no-image.jpg') }}" alt="{{ $menuhome->title }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
            </div>
            <div class="col-md-7">
                <h1>{{ $menuhome->title }}</h1>
                <div class="highlight">
                    <p>{!! Str::limit(strip_tags($menuhome->description), 450) !!}</p>
                    <a href="{{ generateUrl($menuhome->slug) }}" class="btn btn-black">{{ __('homepage.more') }}</a>
                </div>
            </div>
        </div>
        @if(count($menuhome->posts) != 0 || count($menuhome->submenus) != 0)
        <div class="row justify-content-center">
            @foreach($menuhome->posts as $post)
            <div class="col-md-6 col-lg-3">
                <div class="item-post">
                    <img src="{{ $post->cover ? asset($post->cover) : asset('files/no-image.jpg') }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';" class="w-100">
                    <div class="title">
                        <a href="{{ generateUrl($post->slug) }}">{{ $post->title }}</a>
                    </div>
                </div>
            </div>
            @endforeach
            @foreach($menuhome->submenus as $submenu)
            <div class="col-md-6 col-lg-3">
                <div class="item-post">
                    <img src="{{ $submenu->cover ? asset($submenu->cover) : asset('files/no-image.jpg') }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';" class="w-100">
                    <div class="title">
                        <a href="{{ generateUrl($submenu->slug) }}">{{ $submenu->title }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    @endforeach
</div>
@endif
{{-- <div class="well">
    <div class="content">
        @if($external_apps->isNotEmpty())
        <div class="external-apps">
            @foreach($external_apps as $app)
            <a href="{{ $app->link }}" target="_blank">
                <img src="{{ asset($app->logo) }}">
                {{ $app->title }}
            </a>
            @endforeach
        </div>
        @endif
        @if(count($pinned_posts) != 0)
        <div class="wp-posts">
            <div class="wp-slider">
                @if(data_get($setting, 'wp_posts', '-') == 1)
                @if($wp_posts)
                @foreach($wp_posts as $wp_post)
                @foreach($wp_post as $wp)
                <div>
                    <div class="item d-flex flex-column justify-content-around shadow-sm">
                        <h1>{!! $wp->title->rendered !!}</h1>
                        <div class="row">
                            <div class="col-7 d-flex flex-column justify-content-between">
                                <div>
                                    <p class="date">{{ date('d F Y',strtotime(substr($wp->date,0,10))) }}</p>
                                    <p>{!! Str::limit(strip_tags($wp->excerpt->rendered), 180) !!}</p>
                                </div>
                                <a href="{{ $wp->link }}" class="btn w-100">Selengkapnya</a>
                            </div>
                            <div class="col-5 d-flex align-items-end">
                                @php
                                $jsonImg = $wp->featured_media != 0 ? getJson('https://'.explode('/',$wp->link)[2].'/wp-json/wp/v2/media/'.$wp->featured_media) : false;
                                $img = $jsonImg ? $jsonImg->source_url : '';
                                @endphp
                                <img src="{{ $img ? $img : asset('files/no-image.jpg') }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endforeach
                @endif
                @else
                @foreach($pinned_posts as $news)
                <div>
                    <div class="item d-flex flex-column justify-content-around shadow-sm">
                        <h1>{{ $news->title }}</h1>
                        <div class="row align-items-center">
                            <div class="col-7 d-flex flex-column justify-content-between">
                                <div>
                                    <p class="date">{{ $news->formatted_published_at }}</p>
                                    <p>{!! Str::limit(strip_tags($news->description), 170) !!}</p>
                                </div>
                                <a href="{{ generateUrl($news->slug) }}" class="btn w-100">Selengkapnya</a>
                            </div>
                            <div class="col-5">
                                <img src="{{ $news->cover ? asset($news->cover) : asset('files/no-image.jpg')  }}" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <div class="customize-controls" id="customize-controls" aria-label="Carousel Navigation" tabindex="0">
                <button data-controls="prev" tabindex="-1"><i class="fas fa-chevron-left"></i></button>
                <button data-controls="next" tabindex="-1"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        @endif
    </div>
</div> --}}

  <div class="mt-87"></div>
@endsection

@push('script')
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
    // var slider = tns({
    //     container: '.wp-slider',
    //     // items: 2,
    //     // slideBy: 'page',
    //     nav: false,
    //     autoplay: true,
    //     loop: true,
    //     controlsContainer: "#customize-controls",
    //     "autoplayButtonOutput": false,
    //     "mouseDrag": true,
    //     "gutter": 5,
    //     "responsive": {
    //         "420": {
    //             "fixedWidth": 380,
    //         },
    //         // "576": {
    //         //     "fixedWidth": 445,
    //         // },
    //         "1200": {
    //             "fixedWidth": 380,
    //         },
    //     },
    // });

    // var slider1 = tns({
    //     container: '.slider-container',
    //     items: 1,
    //     nav: false,
    //     autoplay: true,
    //     loop: true,
    //     autoplayButtonOutput: false,
    //     mouseDrag: true,
    //     controlsContainer: "#customize-controls-home",
    //     autoHeight: true
    // });


</script>
@endpush