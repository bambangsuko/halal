@extends('layouts.cp')

@section('title', 'Aplikasi Eksternal')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
    <h2 class="section-title m-0">
        Data Aplikasi Eksternal
    </h2>
    <a href="{{ route('cp.external-apps.create') }}" class="btn btn-primary">Add New</a>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="table-fit">#</th>
                                <th>Judul</th>
                                <th class="table-fit">Link</th>
                                <th class="table-fit">Logo</th>
                                <th class="table-fit">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $rowNumber = ($apps->currentpage()-1) * $apps->perpage() + 1;
                            @endphp
                            @forelse ($apps as $item)
                            <tr>
                                <td class="table-fit">{{ $rowNumber++ }}</td>
                                <td>{{ $item->title }}</td>
                                <td class="table-fit text-center">
                                    @if($item->link)
                                    <a class="table-link" href="{{ $item->link }}" target="_blank">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    @endif
                                </td>
                                <td class="table-fit"><img style="width: 100px;" src="{{ asset($item->logo) }}"></td>
                                <td class="table-fit">
                                    <form id="form-action" method="POST" action="{{ route('cp.external-apps.destroy', $item) }}" accept-charset="UTF-8">
                                        @method('DELETE')
                                        @csrf

                                        <div class="table-links">
                                            <a href="{{ route('cp.external-apps.edit', $item) }}">Edit</a>
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
        </div>
        {{ $apps->links('cp.components.pagination') }}
    </div>
</div>
@endsection