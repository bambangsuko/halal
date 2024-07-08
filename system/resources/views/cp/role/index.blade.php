@extends('layouts.cp')

@section('title', 'Role')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-2">
    <h2 class="section-title m-0 mb-4">
        Data Role
    </h2>
    <a href="{{ route('cp.roles.create') }}" class="btn btn-primary">Add New</a>
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
                                <th>Nama</th>
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
                                    <form id="form-action" method="POST" action="{{ route('cp.roles.destroy', $item) }}" accept-charset="UTF-8">
                                        @method('DELETE')
                                        @csrf

                                        <div class="table-links">
                                            <a href="{{ route('cp.roles.edit', $item) }}">Edit</a>
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
