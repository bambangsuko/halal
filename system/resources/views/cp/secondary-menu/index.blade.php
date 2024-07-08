@extends('layouts.cp')

@section('title')
<h1>Secondary Menu</h1>
<div class="section-header-breadcrumb">
    <div class="breadcrumb-item"><a href="{{ url('cp') }}">Dashboard</a></div>
    <div class="breadcrumb-item active">Secondary Menu</div>
</div>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
    <h2 class="section-title m-0">
        Menu
    </h2>
    <a href="{{ route('cp.secondary-menus.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Menu</a>
</div>
<div class="row">
    @forelse($menus as $menu)
    <div class="col-md-4">
        <div class="article">
            <div class="article-header">
                <div class="position-absolute" style="top: 10px; left: 10px">
                    @if (!$loop->first)
                    <button type="button" id="{{ $menu->id }}" data-type="up" class="btn btn-sm btn-light move">
                        <i class="fa fa-arrow-circle-left"></i> Move up
                    </button>
                    @endif
                    @if (!$loop->last)
                    <button type="button" id="{{ $menu->id }}" data-type="down" class="btn btn-sm btn-light move">
                        Move down <i class="fa fa-arrow-circle-right"></i>
                    </button>
                    @endif
                </div>
                <a href="{{ route('cp.secondary-menus.edit',$menu) }}" class="btn btn-sm btn-primary" style="position: absolute; top: 10px; right: 45px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-pencil-alt"></i></a>
                <form id="form-action" method="POST" action="{{ route('cp.secondary-menus.destroy', $menu) }}" accept-charset="UTF-8">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger" style="position: absolute; top: 10px; right: 10px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hapus" onclick="return confirm('Are you sure want to delete it ?');">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
                <span class="badge badge-{{ $menu->is_published == 0 ? 'warning' : 'primary' }}" style="position: absolute; left:5px; bottom: 55px">{{ $menu->is_published == 0 ? 'Draft' : 'Published' }}</span>
                <div class="article-image d-flex justify-content-center align-items-center">
                    <img src="{{ $menu->cover ? asset($menu->cover) : asset('files/no-image.jpg') }}" class="w-100" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
                </div>
                <div class="article-title">
                    <h2 class="text-white">{{ $menu->title }}</h2>
                </div>
            </div>
            <div class="card-footer bg-whitesmoke px-2">
                <a href="{{ route('cp.secondary-menus.show',$menu) }}" class="btn btn-sm btn-warning w-100"><i class="fa fa-eye"></i> Detail</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <p class="text-center">Tidak ada data</p>
    </div>
    @endforelse
</div>
{{ $menus->links('cp.components.pagination') }}
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