@extends('layouts.cp')

@section('title', 'Slider')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-2">
    <h2 class="section-title m-0 mb-4">
        Data Slider
    </h2>
    <a href="{{ route('cp.sliders.create') }}" class="btn btn-primary">Add New</a>
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
                                <th>Order</th>
                                <th style="width: 175px;">Image</th>
                                <th>Caption</th>
                                <th>Link</th>
                                <th class="table-fit">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sliders as $slider)
                                <tr>
                                    <td class="table-fit">{{ $loop->iteration }}</td>
                                    <td class="table-fit">
                                        @if (!$loop->first)
                                            <button type="button" id="{{ $slider->id }}" data-type="up" class="btn btn-sm btn-light move">
                                                Move up <i class="fa fa-arrow-circle-up"></i>
                                            </button>
                                        @endif
                                        @if (!$loop->last)
                                            <button type="button" id="{{ $slider->id }}" data-type="down" class="btn btn-sm btn-light move">
                                                Move down <i class="fa fa-arrow-circle-down"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <img src="{{ asset($slider->image) }}" class="img-fluid my-2">
                                    </td>
                                    <td>{!! $slider->caption !!}</td>
                                    <td>
                                        @if ($slider->link)
                                            <a href="{{ url($slider->link) }}" target="_blank">
                                                {{ $slider->link }} <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="table-fit">
                                        <form id="form-action" method="POST" action="{{ route('cp.sliders.destroy', $slider) }}" accept-charset="UTF-8">
                                            @method('DELETE')
                                            @csrf

                                            <div class="table-links">
                                                <a href="{{ route('cp.sliders.edit', $slider) }}">Edit</a>
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
                                    <td colspan="6" class="text-center">Tidak ada data.</td>
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

@push('script')
    <script>
        $('.move').click(function(event) {
            $.post('{{ route('cp.move-slider') }}', {
                type: $(this).attr('data-type'),
                id: $(this).attr('id')
            }, function(data, textStatus, xhr) {
                window.location.reload();
            });
        });
    </script>
@endpush
