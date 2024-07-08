{{--  
@foreach($main_menus as $menu)
<li class="nav-item {{ $menu->id == 4 ? '' : 'dropdown' }} {{ $loop->iteration < 3 ? 'right-position' : 'left-position' }}">
    <a href="{{ $menu->id == 4 ? generateUrl($menu->slug) : '#' }}" {{ $menu->id == 4 ? '' : 'data-toggle=dropdown' }} class="nav-link">{{ $menu->title }}</a>
    @if($menu->id != 4)
    <ul class="dropdown-menu">
        <div class="caret-up"></div>
        @foreach($menu->submenu as $submenu) 
        <li @if($submenu->id < 8 || $submenu->id > 11) {{ 'class=dropdown-submenu' }} @endif>
            <a href="@if($submenu->id < 8 || $submenu->id > 11) {{ '#' }} @else {{ generateUrl($submenu->slug) }} @endif" @if($submenu->id < 8 || $submenu->id > 11) {{ 'data-toggle=dropdown' }} @endif class="dropdown-item @if($submenu->id < 8 || $submenu->id > 11) {{ 'submenu-title' }} @endif">
                {{ $submenu->title }}
            </a>
            @if($submenu->id < 8 || $submenu->id > 11)
            <ul class="dropdown-menu">
                @foreach($submenu->submenu as $submenu1)
                <li @if($submenu1->id < 8 || $submenu1->id > 11) {{ 'class=dropdown-submenu' }} @endif>
                    <a href="@if($submenu1->id < 8 || $submenu1->id > 11) {{ '#' }} @else {{ generateUrl($submenu1->slug) }} @endif" @if($submenu1->id < 8 || $submenu1->id > 11) {{ 'data-toggle=dropdown' }} @endif class="dropdown-item @if($submenu1->id < 8 || $submenu1->id > 11) {{ 'submenu-title' }} @endif">
                        {{ $submenu1->title }}
                    </a>
                    @if($submenu1->id < 8 || $submenu1->id > 11)
                    <ul class="dropdown-menu">
                        @foreach($submenu1->submenu as $submenu2)
                        <li @if($submenu2->id < 8 || $submenu2->id > 11) {{ 'class=dropdown-submenu' }} @endif>
                            <a href="@if($submenu2->id < 8 || $submenu2->id > 11) {{ '#' }} @else {{ generateUrl($submenu2->slug) }} @endif" @if($submenu2->id < 8 || $submenu2->id > 11) {{ 'data-toggle=dropdown' }} @endif class="dropdown-item @if($submenu2->id < 8 || $submenu2->id > 11) {{ 'submenu-title' }} @endif">
                                {{ $submenu2->title }}
                            </a>
                            @if($submenu2->id < 8 || $submenu2->id > 11)
                            <ul class="dropdown-menu">
                                @foreach($submenu2->submenu as $submenu3)
                                <li>
                                    <a href="{{ generateUrl($submenu3->slug) }}" class="dropdown-item">
                                    {{ $submenu3->title }}
                                    </a>
                                </li>
                                @endforeach
                                @foreach($submenu2->posts as $post)
                                <li>
                                    <a href="{{ generateUrl($post->slug) }}" class="dropdown-item">
                                    {{ $post->title }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                        @foreach($submenu1->posts as $post)
                        <li>
                            <a href="{{ generateUrl($post->slug) }}" class="dropdown-item">
                            {{ $post->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
                @foreach($submenu->posts as $post)
                <li>
                    <a href="{{ generateUrl($post->slug) }}" class="dropdown-item">
                    {{ $post->title }}
                    </a>
                </li>
                @endforeach
            </ul>
            @endif
        </li>
        @endforeach
        @foreach($menu->posts as $post)
        <li>
            <a href="{{ generateUrl($post->slug) }}" class="dropdown-item">
                {{ $post->title }}
            </a>
        </li>
        @endforeach
    </ul>
    @endif
</li>
@endforeach
--}}
{{--  
@foreach($main_menus as $menu)
<li class="nav-item dropdown {{ $loop->iteration < 3 ? 'right-position' : 'left-position' }}">
    <a href="#" data-toggle="dropdown" class="nav-link">{{ $menu->title }}</a>
    <ul class="dropdown-menu">
        <div class="caret-up"></div>
        @foreach($menu->submenu as $submenu)
        <li @if($submenu->show_sub) {{ 'class=dropdown-submenu' }} @endif>
            <a href="@if($submenu->show_sub) {{ '#' }} @else {{ generateUrl($submenu->slug) }} @endif" @if($submenu->show_sub) {{ 'data-toggle=dropdown' }} @endif class="dropdown-item @if($submenu->show_sub) {{ 'submenu-title' }} @endif">
                {{ $submenu->title }}
            </a>
            @if($submenu->show_sub)
            <ul class="dropdown-menu">
                @foreach($submenu->submenu as $submenu1)
                <li @if($submenu1->show_sub) {{ 'class=dropdown-submenu' }} @endif>
                    <a href="@if($submenu1->show_sub) {{ '#' }} @else {{ generateUrl($submenu1->slug) }} @endif" @if($submenu1->show_sub) {{ 'data-toggle=dropdown' }} @endif class="dropdown-item @if($submenu1->show_sub) {{ 'submenu-title' }} @endif">
                        {{ $submenu1->title }}
                    </a>
                    @if($submenu1->show_sub)
                    <ul class="dropdown-menu">
                        @foreach($submenu1->submenu as $submenu2)
                        <li @if($submenu2->show_sub) {{ 'class=dropdown-submenu' }} @endif>
                            <a href="@if($submenu2->show_sub) {{ '#' }} @else {{ generateUrl($submenu2->slug) }} @endif" @if($submenu2->show_sub) {{ 'data-toggle=dropdown' }} @endif class="dropdown-item @if($submenu2->show_sub) {{ 'submenu-title' }} @endif">
                                {{ $submenu2->title }}
                            </a>
                            @if($submenu2->show_sub)
                            <ul class="dropdown-menu">
                                @foreach($submenu2->submenu as $submenu3)
                                <li>
                                    <a href="{{ generateUrl($submenu3->slug) }}" class="dropdown-item">
                                    {{ $submenu3->title }}
                                    </a>
                                </li>
                                @endforeach
                                @foreach($submenu2->posts as $post)
                                <li>
                                    <a href="{{ generateUrl($post->slug) }}" class="dropdown-item">
                                    {{ $post->title }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                        @foreach($submenu1->posts as $post)
                        <li>
                            <a href="{{ generateUrl($post->slug) }}" class="dropdown-item">
                            {{ $post->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
                @foreach($submenu->posts as $post)
                <li>
                    <a href="{{ generateUrl($post->slug) }}" class="dropdown-item">
                    {{ $post->title }}
                    </a>
                </li>
                @endforeach
            </ul>
            @endif
        </li>
        @endforeach
        @foreach($menu->posts as $post)
        <li>
            <a href="{{ generateUrl($post->slug) }}" class="dropdown-item">
                {{ $post->title }}
            </a>
        </li>
        @endforeach
    </ul>
</li>
@endforeach
--}}