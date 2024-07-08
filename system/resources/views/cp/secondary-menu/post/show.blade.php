@extends('layouts.cp')

@section('title')
<div class="section-header-back">
    @if($menu->parent_id == 0)
    <a href="{{route('cp.secondary-menus.show',$menu->id)}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    @else
    <a href="{{route('cp.secondary-menus.submenus.show',[$menu->parent_id,$menu->id])}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    @endif
</div>
<h1>Detail Post</h1>
<div class="section-header-breadcrumb">
    @if(count($breadcrumbs) > 2)
    <div class="breadcrumb-item"><a href="{{ url('cp') }}">...</a></div>
    @else
    <div class="breadcrumb-item"><a href="{{ url('cp') }}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{ route('cp.secondary-menus.index') }}">Secondary Menu</a></div>
    @endif
    @foreach($breadcrumbs as $breadcrumb)
    <div class="breadcrumb-item"><a href="{{ $breadcrumb->parent_id == 0 ? route('cp.secondary-menus.show', $breadcrumb->id) : route('cp.secondary-menus.submenus.show', [$breadcrumb->parent_id, $breadcrumb->id]) }}">{{ $breadcrumb->title }}</a></div>
    @endforeach
    <div class="breadcrumb-item active">Detail Post</div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <a href="{{ route('cp.secondary-menus.posts.edit', [$menu, $post]) }}" class="btn btn-sm btn-primary" style="position: absolute; top: 8px; right: 8px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-alt"></i></a>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ app()->getLocale() == 'id' ? 'active' : ''}}" id="id-tab" data-toggle="tab" href="#id" role="tab" aria-controls="id" aria-selected="true">Indonesia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ app()->getLocale() == 'en' ? 'active' : ''}}" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="false">English</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ app()->getLocale() == 'ar' ? 'active' : ''}}" id="ar-tab" data-toggle="tab" href="#ar" role="tab" aria-controls="ar" aria-selected="false">Arabic</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="p-0 tab-pane fade {{ app()->getLocale() == 'id' ? 'show active' : ''}}" id="id" role="tabpanel" aria-labelledby="id-tab">
                    <div class="card-header flex-column align-items-start">
                        <h2 class="section-title my-0">
                            {{ $post->translate('id')->title }}
                        </h2>
                        <a class="mt-2" href="{{ url('id/'.$post->translate('id')->slug) }}" target="_blank" style="font-size: 11px; line-height: 11px">{{ url('id/'.$post->translate('id')->slug) }} <i class="fa fa-external-link-alt"></i></a>
                    </div>
                    <div class="card-body">
                        {!!$post->translate('id')->description!!}
                    </div>
                </div>
                <div class="p-0 tab-pane fade {{ app()->getLocale() == 'en' ? 'show active' : ''}}" id="en" role="tabpanel" aria-labelledby="en-tab">
                    <div class="card-header flex-column align-items-start">
                        <h2 class="section-title my-0">
                            {{ $post->translate('en')->title }}
                        </h2>
                        <a class="mt-2" href="{{ url('en/'.$post->translate('en')->slug) }}" target="_blank" style="font-size: 11px; line-height: 11px">{{ url('en/'.$post->translate('en')->slug) }} <i class="fa fa-external-link-alt"></i></a>
                    </div>
                    <div class="card-body">
                        {!!$post->translate('en')->description!!}
                    </div>
                </div>
                <div class="p-0 tab-pane fade {{ app()->getLocale() == 'ar' ? 'show active' : ''}}" id="ar" role="tabpanel" aria-labelledby="ar-tab">
                    <div class="card-header flex-column align-items-start">
                        <h2 class="section-title my-0">
                            {{ $post->translate('ar')->title }}
                        </h2>
                        <a class="mt-2" href="{{ url('ar/'.$post->translate('ar')->slug) }}" target="_blank" style="font-size: 11px; line-height: 11px">{{ url('ar/'.$post->translate('ar')->slug) }} <i class="fa fa-external-link-alt"></i></a>
                    </div>
                    <div class="card-body">
                        {!!$post->translate('ar')->description!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <dl class="meta">
                    <dd>
                        <span style="font-size: 11px" class="badge badge-{{ $post->is_published == 1 ? 'primary' : 'warning'  }} px-2 py-1">{{ $post->is_published == 1 ? 'Published' : 'Draft'  }}</span>
                        @if($post->is_pinned)
                        <span style="font-size: 11px" class="badge badge-info px-2 py-1">Pinned Post</span>
                        @endif
                    </dd>

                    <dt>Published At</dt>
                    <dd>{{ $post->created_at->format('d F Y') }}</dd>

                    <dt>Cover Image</dt>
                    <dd>
                        <img src="{{ asset($post->cover) }}" class="img-fluid" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
                    </dd>

                    <dt>Template Page</dt>
                    <dd>{{$post->template}}</dd>
                </dl>
            </div>
        </div>
        @if(count($post->files) != 0)
        <div class="card">
            <div class="card-header">
                <h4 class="text-black-50">Files</h4>
            </div>
            <div class="card-body d-flex flex-column">
                @foreach($post->files as $file)
                <span class="badge badge-secondary mb-2"><i class="fas fa-file"></i>&nbsp;
                    <a class="text-white" href="{{ asset($file->file) }}" target="_blank">{{ $file->title }}</a>
                </span>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection