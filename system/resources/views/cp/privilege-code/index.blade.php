@extends('layouts.cp')

@section('title', 'Privilege Code')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-2">
    <h2 class="section-title m-0 mb-4">
        Data Privilege Code
    </h2>
    <a href="{{ route('cp.privilege-codes.create') }}" class="btn btn-primary">Add New</a>
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
                                <th>Deskripsi</th>
                                <th class="table-fit">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $rowNumber = ($codes->currentpage()-1) * $codes->perpage() + 1;
                            @endphp
                            @forelse ($codes as $item)
                            <tr>
                                <td class="table-fit">{{ $rowNumber++  }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="table-fit">{{ $item->description }}</td>
                                <td class="table-fit">
                                    <form id="form-action" method="POST" action="{{ route('cp.privilege-codes.destroy', $item) }}" accept-charset="UTF-8">
                                        @method('DELETE')
                                        @csrf

                                        <div class="table-links">
                                            <a href="{{ route('cp.privilege-codes.edit', $item) }}">Edit</a>
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
        {{ $codes->links() }}
    </div>
</div>
@endsection
