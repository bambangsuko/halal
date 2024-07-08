<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    @if (App::environment('local'))
    <!--To prevent most search engine web crawlers from indexing a page on your site-->
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ data_get($setting, 'name', '-') }}</title>
    <link rel="shortcut icon" href="{{ asset(data_get($setting, 'icon', '-')) }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css?ver=' . strtotime(date('Y-m-d H:i:s')))}}">
    @stack('style')
    @include('components.meta')
</head>

<body>
    <div class="navbar-second">
        <div class="link-container">
            @foreach($sidemenus as $sidemenu)
            <a class="link" href="{{ $sidemenu->type == 'menu' ? generateUrl($sidemenu->slug) : $sidemenu->link }}">{{ $sidemenu->title }}</a>
            @endforeach
        </div>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="languange" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="d-flex align-items-center">
                    @if (app()->getLocale() == 'id')
                    <img src="{{ asset('assets/id.png') }}" style="width: 20px; margin-right: 5px">Indonesia
                    @elseif (app()->getLocale() == 'en')
                    <img src="{{ asset('assets/en.png') }}" style="width: 20px; margin-right: 5px">English
                    @else
                    <img src="{{ asset('assets/ar.png') }}" style="width: 20px; margin-right: 5px">Arabic
                    @endif
                </div>
            </button>
            <div class="dropdown-menu" aria-labelledby="languange">
                <a class="dropdown-item" href="{{ url('id') }}"><img src="{{ asset('assets/id.png') }}"> Indonesia</a>
                <a class="dropdown-item" href="{{ url('en') }}"><img src="{{ asset('assets/en.png') }}"> English</a>
                <a class="dropdown-item" href="{{ url('ar') }}"><img src="{{ asset('assets/ar.png') }}"> Arabic</a>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-main">
        <div class="top">
            <a class="navbar-brand shadow" href="{{ url('') }}">
                <img src="{{ asset(data_get($setting, 'icon', '-')) }}" alt="{{ data_get($setting, 'name', '-') }}">
            </a>
        </div>
        <div class="scroll">
            <a class="navbar-brand" href="{{ url('') }}">
                <img src="{{ asset(data_get($setting, 'logo', '-')) }}" alt="{{ data_get($setting, 'name', '-') }}">
            </a>
        </div>
        <div class="d-flex" style="padding: 11px 0;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main" aria-controls="navbar-main" aria-expanded="false" aria-label="Toggle navigation" onclick="closeNavbarSecond()">
                <i class="fas fa-bars"></i>
            </button>
            <button class="btn navbar-second-toggler" onclick="openNavbarSecond()">
                <i class="fas fa-ellipsis-v"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar-main">
            <ul class="navbar-nav">
                 @foreach($mainmenus as $mainmenu)
                    @if($mainmenu->type == 'dropdown')
                        <div class="nav-item dropdown">
                            <a class="nav-link dropbtn" href="{{ generateUrl($mainmenu->slug) }}" role="button" id="dropdown{{ $mainmenu->title }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ $mainmenu->title }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdown{{ $mainmenu->title }}">
                                @foreach($submenus as $submenu)
                                    @if($submenu->parent_id == $mainmenu->id)
                                        <a class="dropdown-item nav-link" href="{{ generateUrl($submenu->slug) }}">{{ $submenu->title }}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $mainmenu->type == 'menu' ? generateUrl($mainmenu->slug) : $mainmenu->link }}">{{ $mainmenu->title }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <form action="{{ generateUrl(trans('route.search')) }}" method="GET" accept-charset="utf-8" class="form-inline">
                <input class="form-control search-input" type="search" name="keyword" placeholder="{{ __('search.placeholder') }}" aria-label="Search" value="{{ request('keyword') }}">
                <i class="fas fa-search search-icon"></i>
            </form>
        </div>
    </nav>
    <div class="mt-87"></div>
    
    @yield('content')
    
    {{-- <div class="mt-87">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/N5rUS2hSSL8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/O0mP6g3VAts" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div> --}}
    
    <footer>
        <div class="container-fluid">
            <div class="row footer">
                <div class="col-md-5 mb-2">
                    <div class="d-flex align-items-center">
                        <div class="img">
                            <img src="{{ asset(data_get($setting, 'icon', '-')) }}" class="">
                        </div>
                        <div class="ml-3 text-left">
                            <p class="address text-light">{{ data_get($setting, 'address', '-') }}</p>
                            <div class="d-flex flex-column">
                                @if(data_get($setting, 'phone'))
                                <a href="tel:{{ data_get($setting, 'phone', '-') }}"><i class="fas fa-phone"></i> {{ data_get($setting, 'phone', '-') }}</a>
                                @endif
                                @if(data_get($setting, 'fax'))
                                <a href="fax:{{ data_get($setting, 'fax', '-') }}"><i class="fas fa-fax"></i> {{ data_get($setting, 'fax', '-') }}</a>
                                @endif
                                @if(data_get($setting, 'email'))
                                <a href="mailto:{{ data_get($setting, 'email', '-') }}"><i class="far fa-envelope"></i> {{ data_get($setting, 'email', '-') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <h3 class="text-light">Maps</h3>
                    @if(data_get($setting, 'maps'))
                    {!! data_get($setting, 'maps', '-') !!}
                    @endif
                </div>
                <div class="col-md-3">
                    <h3 class="text-light">{{ __('footer.follow_us') }}</h3>
                    <div class="d-flex flex-column">
                        @foreach($social_media as $sm)
                        <a class="mb-1" href="{{ $sm->link }}"><i class="{{ $sm->icon }}"></i> {{ $sm->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <p class="text-light copyright">© {{ date('Y') }} {{ data_get($setting, 'name', '-') }}</p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
    <script type="text/javascript" src="{{asset('js/script.js?ver=' . strtotime(date('Y-m-d H:i:s')))}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('script')
</body>

</html>