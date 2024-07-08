@extends('layouts.cp')

@section('title', 'User')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-2">
    <h2 class="section-title m-0 mb-4">
        Data User
    </h2>
    <a href="{{ route('cp.users.create') }}" class="btn btn-primary">Add New</a>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="table-fit">#</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th class="table-fit">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $rowNumber = ($users->currentpage()-1) * $users->perpage() + 1;
                            @endphp
                            @forelse ($users as $user)
                                <tr>
                                    <td class="table-fit">{{ $rowNumber++  }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td class="table-fit">{{ $user->role->name }}</td>
                                    <td class="table-fit">
                                        <form id="form-action" method="POST" action="{{ route('cp.users.destroy', $user) }}" accept-charset="UTF-8">
                                            @method('DELETE')
                                            @csrf

                                            <div class="table-links">
                                                <a href="{{ route('cp.users.show', $user) }}">Detail</a>
                                                <div class="bullet"></div>
                                                <a href="{{ route('cp.users.edit', $user) }}">Edit</a>
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
        {{ $users->links() }}
    </div>
</div>
@endsection
