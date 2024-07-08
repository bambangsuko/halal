@extends('layouts.cp')

@section('title', 'Media Sosial')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-2">
    <h2 class="section-title m-0 mb-4">
        Data Media Sosial
    </h2>
    <a href="{{ route('cp.social-media.create') }}" class="btn btn-primary">Add New</a>
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
                        <th>Nama Sosial Media</th>
                        <th class="table-fit">Link</th>
                        <th class="table-fit">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($socialMedia as $item)
                        <tr>
                            <td class="table-fit">{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="{{ $item->icon }} mr-2"></i>
                                    <a href="{{ $item->link }}" target="_blank">{{ $item->link }}</a>
                                </div>
                            </td>
                            <td class="table-fit">
                                <form id="form-action" method="POST" action="{{ route('cp.social-media.destroy', $item) }}" accept-charset="UTF-8">
                                    @method('DELETE')
                                    @csrf

                                    <div class="table-links">
                                        <a href="{{ route('cp.social-media.edit', $item) }}">Edit</a>
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
  </div>
</div>
@endsection
