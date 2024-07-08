@extends('layouts.cp')

@section('title')
<h1>{{$menu->title}}</h1>&nbsp;<span class="badge badge-{{ $menu->is_published == 1 ? 'primary' : 'warning'  }}">{{ $menu->is_published == 1 ? 'Published' : 'Draft'  }}</span>
@include('cp.components.breadcrumb', [
'breadcrumbs' => $breadcrumbs
])
@endsection

@section('content')
<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-header py-0">
                <h4 class="text-black-50">Content</h4>
            </div>
            <div class="card-body py-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ app()->getLocale() == 'id' ? 'active' : ''}}" id="id-tab" data-toggle="tab" href="#id" role="tab" aria-controls="id" aria-selected="true">Indonesia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ app()->getLocale() == 'en' ? 'active' : ''}}" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="false">English</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade {{ app()->getLocale() == 'id' ? 'show active' : ''}}" id="id" role="tabpanel" aria-labelledby="id-tab">
                        <dl class="meta">
                            <dt>Title</dt>
                            <dd>{{$menu->translate('id')->title}}</dd>

                            <dt>Description</dt>
                            <dd>{!!$menu->translate('id')->description!!}</dd>
                        </dl>    
                    </div>
                    <div class="tab-pane fade {{ app()->getLocale() == 'en' ? 'show active' : ''}}" id="en" role="tabpanel" aria-labelledby="en-tab">
                        <dl class="meta">
                            <dt>Title</dt>
                            <dd>{{$menu->translate('en')->title}}</dd>

                            <dt>Description</dt>
                            <dd>{!!$menu->translate('en')->description!!}</dd>
                        </dl>       
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header py-0">
                <h4 class="text-black-50">Meta</h4>
            </div>
            <div class="card-body py-0">
                <dl class="meta">
                    <dt>Cover</dt>
                    <dd>
                        @if($menu->cover)
                        <img src="{{asset($menu->cover)}}" class="img-fluid" onerror="this.style.display = 'none'">
                        @else
                        None
                        @endif
                    </dd>

                    <dt>Template Page</dt>
                    <dd>{{$menu->template}}</dd>
                </dl> 
            </div>
        </div>
    </div>
</div>
@if($menu->id < 5 || $menu->id == 41)
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 class="section-title m-0">
                Submenu
            </h2>
            <a href="{{route('cp.menus.submenus.create',$menu)}}" class="btn btn-primary">Add New Submenu</a>
        </div>
    </div>
    @forelse($submenus as $submenu)
    <div class="col-md-4">
        <div class="article">
            <div class="article-header">
                {{--
                <div class="position-absolute" style="top: 5px; right: 5px">
                    @if (!$loop->first)
                    <button type="button" id="{{ $submenu->id }}" data-type="up" class="btn btn-sm btn-outline-dark move">
                <i class="fa fa-arrow-circle-left"></i> Move up
                </button>
                @endif
                @if (!$loop->last)
                <button type="button" id="{{ $submenu->id }}" data-type="down" class="btn btn-sm btn-outline-dark move">
                    Move down <i class="fa fa-arrow-circle-right"></i>
                </button>
                @endif
            </div>
            --}}
            <div class="article-image d-flex justify-content-center align-items-center">
                <img src="{{asset($submenu->cover)}}" class="w-100" onerror="this.src='{{ asset('assets/img/nocover.png') }}';">
            </div>
            <div class="article-title">
                <h2 class="text-light">{{$submenu->title}}</h2>
            </div>
        </div>
        <div class="card-footer bg-whitesmoke">
            <div class="row align-items-center justify-content-between">
                <div class="col-4 text-center"><a href="{{ route('cp.menus.submenus.show',[$menu, $submenu])}}" class="btn btn-sm btn-outline-success"><i class="fa fa-eye"></i> Detail</a></div>
                <div class="col-4 text-center"><a href="{{ route('cp.menus.submenus.edit', [$menu, $submenu]) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-pencil-alt"></i> Edit</a></div>
                <div class="col-4 text-center">
                    <form id="form-action" method="POST" action="{{ route('cp.menus.submenus.destroy', [$menu, $submenu]) }}" accept-charset="UTF-8">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure want to delete it ?');">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12 text-center">  
    <div class="card card-primary">            
        <p class="m-0 py-3">No Data</p>
    </div>
</div>
@endforelse
</div>
@endif
@if($menu->id != 41)
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2 class="section-title m-0">
                Post
            </h2>
            <a href="{{route('cp.menus.posts.create', $menu)}}" class="btn btn-primary">Add New Post</a>
        </div>
        <div class="card card-primary">         
            <div class="card-body p-0">
                <table class="table table-striped table-md table-responsive">
                    <thead>
                        <tr>
                            <th class="table-fit">#</th>
                            <th>Title</th>
                            <th class="table-fit">Published At</th>
                            <th></th>
                            <th class="table-fit">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $rowNumber = ($posts->currentpage()-1) * $posts->perpage() + 1;
                        @endphp
                        @forelse ($posts as $post)
                        <tr>
                            <td class="table-fit">{{ $rowNumber++ }}</td>
                            <td>{{ $post->title }} </td>
                            <td class="table-fit">{{ $post->created_at->format('d F Y') }}</td>
                            <td class="table-fit">
                                <span class="badge badge-{{ $post->is_published == 1 ? 'primary' : 'warning'  }}">{{ $post->is_published == 1 ? 'Published' : 'Draft'  }}</span>
                                @if($post->is_running_text == 1)
                                <span class="badge badge-info">Running Text</span>
                                @endif
                                @if($post->is_featured_product == 1)
                                <span class="badge badge-danger">Featured Product</span>
                                @endif
                            </td>
                            <td class="table-fit">
                                <form id="form-action" method="POST" action="{{ route('cp.menus.posts.destroy', [$menu, $post]) }}" accept-charset="UTF-8">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">

                                    <div class="table-links">
                                        <a href="{{ route('cp.menus.posts.show',[$menu, $post]) }}">Detail</a>
                                        <div class="bullet"></div>
                                        <a href="{{ route('cp.menus.posts.edit',[$menu, $post]) }}">Edit</a>
                                        <div class="bullet"></div>
                                        <button type="submit" class="btn text-danger btn-link" onclick="return confirm('Are you sure want to delete it ?');">
                                            Delete
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-2">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('script')
{{--<script>
        $('.move').click(function(event) {
            $.post('{{ route('cp.move-submenu') }}', {
type: $(this).attr('data-type'),
id: $(this).attr('id')
}, function(data, textStatus, xhr) {
window.location.reload();
});
});
</script>--}}
@endpush