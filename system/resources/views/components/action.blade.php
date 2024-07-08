<div class="main-border">
    <div class="red"></div>
    <div class="blue"></div>
    @if(isset($post->menu->parent) && $post->menu->parent->is_hidden == 1)
    @else
    <div class="action-button">
        <a href="{{ url('') }}">
            <div class="blue-icon">                
                <img src="{{ asset('assets/img/back.png')}}">
            </div>
        </a>
        <a href="javascript:void(0)" onclick="printPage()">
            <div class="red-icon">                
                <img src="{{ asset('assets/img/print.png')}}">
            </div>
        </a>
        <a href="javascript:void(0)" onclick="shareBtn()">
            <div class="blue-icon">                
                <img src="{{ asset('assets/img/share.png')}}">
            </div>
        </a>
    </div>
    @endif
</div>
<div id="shr"></div>