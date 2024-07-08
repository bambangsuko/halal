@extends('layouts.cp')

@section('title', 'Menu')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped table-md table-responsive">
                    <thead>
                        <tr>
                            <th class="table-fit">#</th>
                            <th>Title</th>
                            <th class="table-fit">Publising Status</th>
                            <th class="table-fit">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($menus as $menu)
                        <tr>
                            <td class="table-fit">{{ $loop->iteration }}</td>
                            <td>{{ $menu->title }}</td>
                            <td><span class="badge badge-{{ $menu->is_published == 1 ? 'primary' : 'warning'  }}">{{ $menu->is_published == 1 ? 'Published' : 'Draft'  }}</span></td>
                            <td class="table-fit">
                                <div class="table-links">
                                    <a href="{{ route('cp.menus.edit', $menu) }}">Edit</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data.</td>
                        </tr>
                        @endforelse                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
