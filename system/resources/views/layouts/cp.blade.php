<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <!--To prevent most search engine web crawlers from indexing a page on your site-->
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">

    <title>{{ data_get($setting, 'name', '-') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset(data_get($setting, 'icon', '-')) }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">

    @stack('style')
</head>
<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="{{ asset('admin/avatar-1.png') }}" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">{{ Auth::user()->name }}</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            {{-- <div class="dropdown-title">Logged in 5 min ago</div> --}}
                            <a href="{{ url('') }}" target="_blank" class="dropdown-item has-icon">
                                <i class="fas fa-external-link-alt"></i> View Site
                            </a>
                            {{-- <a href="features-profile.html" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a> --}}
                            {{--<a href="{{ route('cp.settings.edit') }}" class="dropdown-item has-icon">
                            <i class="fas fa-cog"></i> Settings
                            </a>--}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item has-icon text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ url('/cp') }}">Control Panel</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="{{ url('/cp') }}">CP</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Dashboard</li>
                        <li class="{{ activeLink('cp.dashboard', false) }}">
                            <a class="nav-link" href="{{ url('cp') }}">
                                <i class="fas fa-fire"></i><span>Dashboard</span>
                            </a>
                        </li>
                        @if(getSidebar('main-menus') || getSidebar('secondary-menus') || getSidebar('home-menus'))
                        <li class="menu-header">Manage</li>
                        @endif
                        @if(getSidebar('main-menus'))
                        <li class="{{ activeLinkUriSegment('main-menus') }}">
                            <a class="nav-link" href="{{ route('cp.main-menus.index') }}">
                                <i class="fas fa-bars"></i> <span>Main Menu</span>
                            </a>
                        </li>
                        @endif
                        @if(getSidebar('secondary-menus'))
                        <li class="{{ activeLinkUriSegment('secondary-menus') }}">
                            <a class="nav-link" href="{{ route('cp.secondary-menus.index') }}">
                                <i class="fas fa-bars"></i> <span>Secondary Menu</span>
                            </a>
                        </li>
                        @endif
                        @if(getSidebar('home-menus'))
                        <li class="{{ activeLinkUriSegment('home-menus') }}">
                            <a class="nav-link" href="{{ route('cp.home-menus.index') }}">
                                <i class="fas fa-bars"></i> <span>Homepage Menu</span>
                            </a>
                        </li>
                        @endif
                        {{--
                        @if(getSidebar('contacts'))
                        <li class="menu-header">Transactions</li>
                        <li class="{{ activeLink('cp.contacts') }}">
                            <a class="nav-link" href="{{ route('cp.contacts.index') }}">
                                <i class="far fa-paper-plane"></i> <span>Kontak Kami</span>
                            </a>
                        </li>
                        @endif
                        --}}
                        @if(getSidebar('external-apps') || getSidebar('social-media') || getSidebar('settings'))
                        <li class="menu-header">Configure</li>
                        @endif
                        @if(getSidebar('external-apps'))
                        <li class="{{ activeLink('cp.external-apps') }}">
                            <a class="nav-link" href="{{ route('cp.external-apps.index') }}">
                                <i class="fas fa-link"></i> <span>Aplikasi Eksternal</span>
                            </a>
                        </li>
                        @endif
                        @if(getSidebar('sliders'))
                        <li class="{{ activeLink('cp.sliders') }}">
                            <a class="nav-link" href="{{ route('cp.sliders.index') }}">
                                <i class="fas fa-images"></i> <span>Slider</span>
                            </a>
                        </li>
                        @endif
                        @if(getSidebar('social-media'))
                        <li class="{{ activeLink('cp.social-media') }}">
                            <a class="nav-link" href="{{ route('cp.social-media.index') }}">
                                <i class="fas fa-hashtag"></i> <span>Media Sosial</span>
                            </a>
                        </li>
                        @endif
                        @if(getSidebar('settings'))
                        <li class="{{ activeLink('cp.settings.edit', false) }}">
                            <a class="nav-link" href="{{ route('cp.settings.edit') }}">
                                <i class="fas fa-cog"></i> <span>Settings</span>
                            </a>
                        </li>         
                        @endif
                        @if(getSidebar('users') || getSidebar('roles') || getSidebar('permissions'))
                        <li class="menu-header">User Management</li>
                        @endif
                        @if(getSidebar('users'))
                        <li class="{{ activeLink('cp.users') }}">
                            <a class="nav-link" href="{{ route('cp.users.index') }}">
                                <i class="fas fa-users"></i> <span>User</span>
                            </a>
                        </li>                        
                        @endif
                        @if(getSidebar('roles'))
                        <li class="{{ activeLink('cp.roles') }}">
                            <a class="nav-link" href="{{ route('cp.roles.index') }}">
                                <i class="fas fa-lock"></i> <span>Role</span>
                            </a>
                        </li>                        
                        @endif
                        @if(getSidebar('permissions'))
                        <li class="{{ activeLink('cp.permissions') }}">
                            <a class="nav-link" href="{{ route('cp.permissions.index') }}">
                                <i class="fas fa-tasks"></i> <span>Permission</span>
                            </a>
                        </li>               
                        @endif
                        @if(getSidebar('privilege-codes'))
                        <li class="{{ activeLink('cp.privilege-codes') }}">
                            <a class="nav-link" href="{{ route('cp.privilege-codes.index') }}">
                                <i class="fas fa-code"></i> <span>Privilege Code</span>
                            </a>
                        </li>               
                        @endif
                        <li class="menu-header">Profile</li>
                        <li class="{{ activeLink('cp.passwords.edit', false) }}">
                            <a class="nav-link" href="{{ route('cp.passwords.edit') }}">
                                <i class="fas fa-key"></i> <span>Change Password</span>
                            </a>
                        </li>     
                    </ul>
                </aside>
            </div>
            
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>@yield('title')</h1>
                    </div>
                    @include('cp.components.flash-message')
                    @yield('content')
                </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; {{ date('Y') }}
                    <div class="bullet"></div> <a href="{{ url('') }}">{{ data_get($setting, 'name', '-') }}</a>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="{{ asset('admin/js/stisla.js') }}"></script>
    <script src="{{ asset('admin/js/scripts.js') }}"></script>
    <script src="{{ asset('admin/js/ckeditor.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $('.js-upload-image').change(function(event) {
            makePreview(this);
            $('#upload-img-preview').show();
            $('#upload-img-delete').show();
        });

        function makePreview(input){
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#upload-img-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#upload-img-delete').click(function(event) {
            event.preventDefault();

            $('#upload-img-preview').attr('src', '').hide();
            $('.custom-file-input').val(null);
            $(this).hide();
        });

        var config = {
            extraPlugins: 'uploadimage,image2,button,panelbutton,colorbutton',
            height: '30em',

            filebrowserBrowseUrl: '{{ url('elfinder/ckeditor') }}',
            filebrowserUploadUrl: '{{ route('cp.upload',['_token' => csrf_token()]) }}',

            stylesSet: [{
                name: 'Narrow image',
                type: 'widget',
                widget: 'image',
                attributes: {
                    'class': 'image-narrow'
                }
            },{
                name: 'Wide image',
                type: 'widget',
                widget: 'image',
                attributes: {
                    'class': 'image-wide'
                }
            }],

            contentsCss: [
                'https://cdn.ckeditor.com/4.11.3/full-all/contents.css',
            ],

            image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],
            image2_disableResizer: true,
            removeDialogTabs: 'link:upload;image:upload',
            allowedContent: true
        };
        CKEDITOR.replace('description_id', config);
        CKEDITOR.replace('description_en', config);
        CKEDITOR.replace('description_ar', config);
    </script>
    @stack('script')
</body>

</html>