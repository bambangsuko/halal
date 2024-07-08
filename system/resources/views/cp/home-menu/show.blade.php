@extends('layouts.cp')

@section('title')
<div class="section-header-back">
    <a href="{{ route('cp.home-menus.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Detail Menu</h1>
<div class="section-header-breadcrumb">
    <div class="breadcrumb-item"><a href="{{ url('cp') }}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{ route('cp.home-menus.index') }}">Home Menu</a></div>
    <div class="breadcrumb-item active">{{ $menu->title }}</div>
</div>
@endsection

@section('content')
<div class="card d-flex" style="height: 100%; background: linear-gradient(to left, rgba(255,255,255,0),
              rgba(255,255,255,1) 70%), url({{ asset($menu->cover) }}), url({{ asset('files/no-image.jpg') }}); background-size: cover; background-repeat: no-repeat; background-position: center">
    <div class="card-wrap">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2">
                <h2 class="text-dark mb-0 mr-2">{{ $menu->title }}</h2>
                <span class="badge badge-{{ $menu->is_published == 1 ? 'primary' : 'warning' }}">{{ $menu->is_published == 1 ? 'Published' : 'Draft' }}</span>
            </div>
            @if($menu->type == 'link')
            <div class="mb-2">
                <a href="{{ $menu->link }}" target="_blank">{{ $menu->link }}</a>
            </div>
            @endif
            <div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="id-tab" data-toggle="tab" href="#id" role="tab" aria-controls="id" aria-selected="true">Indonesia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="false">English</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="ar-tab" data-toggle="tab" href="#ar" role="tab" aria-controls="ar" aria-selected="false">Arabic</a>
                    </li>
                </ul>
                <div class="tab-content px-3" id="myTabContent">
                    <div class="tab-pane fade active show" id="id" role="tabpanel" aria-labelledby="id-tab">
                        <dl class="meta">
                            <dt>Judul</dt>
                            <dd>{{ $menu->translate('id')->title }}</dd>

                            <dt>Deskripsi</dt>
                            <dd>
                                {!! $menu->translate('id')->description !!}
                            </dd>
                        </dl>
                    </div>
                    <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                        <dl class="meta">
                            <dt>Judul</dt>
                            <dd>{{ $menu->translate('en')->title }}</dd>

                            <dt>Deskripsi</dt>
                            <dd>
                                {!! $menu->translate('en')->description !!}
                            </dd>
                        </dl>
                    </div>
                    <div class="tab-pane fade" id="ar" role="tabpanel" aria-labelledby="ar-tab">
                        <dl class="meta">
                            <dt>Judul</dt>
                            <dd>{{ $menu->translate('ar')->title }}</dd>

                            <dt>Deskripsi</dt>
                            <dd>
                                {!! $menu->translate('ar')->description !!}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <a href="{{ route('cp.home-menus.edit', $menu) }}" class="btn btn-sm btn-light" style="position: absolute; right: 10px; top: 10px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                <i class="fa fa-pencil-alt"></i>
            </a>
        </div>
    </div>
</div>
@if($menu->type == 'menu')
<div class="d-flex justify-content-between align-items-center mb-2">
    <h2 class="section-title m-0">
        Submenu
    </h2>
    <a href="{{ route('cp.home-menus.submenus.create', $menu) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Submenu</a>
</div>
<div class="row">
    @forelse($submenus as $submenu)
    <div class="col-md-4">
        <div class="article">
            <div class="article-header">
                <div class="position-absolute" style="top: 10px; left: 10px">
                    @if (!$loop->first)
                    <button type="button" id="{{ $submenu->id }}" data-type="up" class="btn btn-sm btn-light move">
                        <i class="fa fa-arrow-circle-left"></i> Move up
                    </button>
                    @endif
                    @if (!$loop->last)
                    <button type="button" id="{{ $submenu->id }}" data-type="down" class="btn btn-sm btn-light move">
                        Move down <i class="fa fa-arrow-circle-right"></i>
                    </button>
                    @endif
                </div>
                <a href="{{ route('cp.home-menus.submenus.edit', [$menu, $submenu]) }}" class="btn btn-sm btn-primary" style="position: absolute; top: 10px; right: 45px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-alt"></i></a>
                <form id="form-action" method="POST" action="{{ route('cp.home-menus.submenus.destroy', [$menu, $submenu]) }}" accept-charset="UTF-8">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger" style="position: absolute; top: 10px; right: 10px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus" onclick="return confirm('Are you sure want to delete it ?');">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
                <span class="badge badge-{{ $submenu->is_published == 0 ? 'warning' : 'primary' }}" style="position: absolute; left:5px; bottom: 55px">{{ $submenu->is_published == 0 ? 'Draft' : 'Published' }}</span>
                <div class="article-image d-flex justify-content-center align-items-center">
                    <img src="{{ $submenu->cover ? asset($submenu->cover) : asset('files/no-image.jpg') }}" class="w-100" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
                </div>
                <div class="article-title">
                    <h2 class="text-white">{{ $submenu->title }}</h2>
                </div>
            </div>
            <div class="card-footer bg-whitesmoke px-2">
                <a href="{{ route('cp.home-menus.submenus.show', [$menu, $submenu]) }}" class="btn btn-sm btn-warning w-100"><i class="fa fa-eye"></i> Detail</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <p class="text-center">Tidak ada data</p>
    </div>
    @endforelse
</div>
{{ $submenus->links('cp.components.pagination') }}
<div class="d-flex justify-content-between align-items-center mb-2">
    <h2 class="section-title m-0">
        Post
    </h2>
    <a href="{{ route('cp.home-menus.posts.create', $menu) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Post</a>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="table-fit">#</th>
                            <th>Judul</th>
                            <th class="table-fit text-center">Tanggal Post</th>
                            <th class="table-fit text-center">Status</th>
                            <th class="table-fit text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $rowNumber = ($posts->currentpage()-1) * $posts->perpage() + 1;
                        @endphp
                        @forelse($posts as $post)
                        <tr>
                            <td class="table-fit">{{ $rowNumber++ }}</td>
                            <td>{{ $post->title }}</td>
                            <td class="table-fit">{{ $post->created_at->format('d F Y') }}</td>
                            <td class="table-fit">
                                <span class="badge badge-{{ $post->is_published == 1 ? 'primary' : 'warning' }}">{{ $post->is_published == 1 ? 'Publish' : 'Draft' }}</span>
                            </td>
                            <td class="table-fit">
                                <form id="form-action" method="POST" action="{{ route('cp.home-menus.posts.destroy', [$menu, $post]) }}" accept-charset="UTF-8">
                                    @method('DELETE')
                                    @csrf

                                    <div class="table-links">
                                        <a href="{{ route('cp.posts.to-slider', $post) }}">Add to Slider</a>
                                        <div class="bullet"></div>
                                        <a href="{{ route('cp.home-menus.posts.show', [$menu, $post]) }}">Detail</a>
                                        <div class="bullet"></div>
                                        <a href="{{ route('cp.home-menus.posts.edit', [$menu, $post]) }}">Edit</a>
                                        <div class="bullet"></div>
                                        <button type="submit" class="btn text-danger btn-link" onclick="return confirm('Anda yakin akan menghapus data ?');">
                                            Delete
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ $posts->links('cp.components.pagination') }}
    </div>
</div>
@endif
@endsection
@push('script')
<script>
    $('.move').click(function(event) {
        $.get('{{ route('cp.move-menu') }}', {
                type: $(this).attr('data-type'),
                id: $(this).attr('id')
            },
            function(data, textStatus, xhr) {
                window.location.reload();
            });
    });
</script>
@endpush