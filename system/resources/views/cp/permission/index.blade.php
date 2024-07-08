@extends('layouts.cp')

@section('title', 'Permission')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-2">
    <h2 class="section-title m-0 mb-4">
        Data Permission
    </h2>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="table-fit">#</th>
                                <th>Nama Role</th>
                                <th class="table-fit">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $rowNumber = ($roles->currentpage()-1) * $roles->perpage() + 1;
                            @endphp
                            @forelse ($roles as $item)
                            <tr>
                                <td class="table-fit">{{ $rowNumber++ }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="table-fit">
                                    <div class="table-links">
                                        <a href="{{ route('cp.permissions.show', $item) }}">Detail</a>
                                        <div class="bullet"></div>
                                        <a href="{{ route('cp.permissions.edit', $item) }}">Edit</a>
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
        {{ $roles->links() }}
    </div>
</div>
@endsection
