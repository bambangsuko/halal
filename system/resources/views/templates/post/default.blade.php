@extends('layouts.base')

@section('content')
<div class="container">
    <div class="detail-post">
        @include('components.breadcrumb', [
        'breadcrumbs' => $breadcrumbs
        ])
        <span>{{ $post->formatted_published_at }}</span>
        <h1>{{ $post->title }}</h1>
        <div class="row">
            <div class="col-md-8">
                {!! $post->description !!}
                @if(count($post->files) != 0)
                @foreach($post->files as $key => $file)
                @if(getFileExtension($file->file) == 'pdf')
                <h3>{{ $file->title }}</h3>
                <iframe src="{{ asset($file->file) }}#toolbar=0" width="100%" height="500px" class="mb-2"></iframe>
                @elseif(getFileExtension($file->file) == 'csv')
                <h3>{{ $file->title }}</h3>
                <div id="{{ $key }}" class="mb-3 table-responsive"></div>
                @endif
                @endforeach
                @endif
                @if(count($downloadable_files) != 0)
                <div class="download">
                    <h2>Download</h2>
                    @foreach($downloadable_files as $f)
                    <a href="{{ asset($f->file) }}" target="_blank"><i class="far fa-file"></i> {{ $f->title }}</a>
                    @endforeach
                </div>
                @endif
            </div>
            @if(isset($post->cover))
            <div class="col-md-4">
                <img src="{{ asset($post->cover) }}" alt="{{ $post->title }}" class="w-100">
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@if(count($post->files) != 0)
@push('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endpush
@push('script')
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        @foreach($post->files as $key => $file)
        @if(getFileExtension($file->file) == 'csv')
        $.ajax({
            type: "get",
            url: "{{ route('ajax-datatable') }}",
            data: {
                id : {{$file->id}},
                file : "{{$file->file}}"
            },
            success: function(data) {
                if (data.success === true) {
                    $({!!"'#".$key."'"!!}).html(data.html);
                }
            }
        });
        @endif
        @endforeach
    });
</script>
@endpush
@endif