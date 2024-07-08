@extends('layouts.cp')

@section('title')
<div class="section-header-back">
    @if($menu->parent_id == 0)
    <a href="{{route('cp.secondary-menus.show',$menu->id)}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    @else
    <a href="{{route('cp.secondary-menus.submenus.show',[$menu->parent_id,$menu->id])}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    @endif
</div>
<h1>Edit Post</h1>
<div class="section-header-breadcrumb">
    @if(count($breadcrumbs) > 2)
    <div class="breadcrumb-item"><a href="{{ url('cp') }}">...</a></div>
    @else
    <div class="breadcrumb-item"><a href="{{ url('cp') }}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{ route('cp.secondary-menus.index') }}">Secondary Menu</a></div>
    @endif
    @foreach($breadcrumbs as $breadcrumb)
    <div class="breadcrumb-item"><a href="{{ $breadcrumb->parent_id == 0 ? route('cp.secondary-menus.show', $breadcrumb->id) : route('cp.secondary-menus.submenus.show', [$breadcrumb->parent_id, $breadcrumb->id]) }}">{{ $breadcrumb->title }}</a></div>
    @endforeach
    <div class="breadcrumb-item"><a href="{{ route('cp.secondary-menus.posts.show', [$menu, $post]) }}">{{ $post->title }}</a></div>
    <div class="breadcrumb-item active">Edit Post</div>
</div>
@endsection

@section('content')
<form action="{{ route('cp.secondary-menus.posts.update', [$menu, $post]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-4">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="id-tab" data-toggle="tab" href="#id" role="tab" aria-controls="id" aria-selected="true">Indonesia</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="false">English</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ar-tab" data-toggle="tab" href="#ar" role="tab" aria-controls="ar" aria-selected="false">Arabic</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="id" role="tabpanel" aria-labelledby="id-tab">
                            <div class="form-group">
                                <label for="title_id" class="col-form-label text-right">Judul</label>
                                <input type="text" id="title_id" class="form-control{{ $errors->has('title_id') ? ' is-invalid' : '' }}" name="title_id" autofocus="" value="{{ old('title_id') ? old('title_id') : $post->translate('id')->title }}">
                                @include('cp.components.form-error', ['field' => 'title_id'])
                            </div>
                            <div class="form-group">
                                <label for="description_id" class="col-form-label text-right">Deskripsi</label>
                                <textarea rows="4" type="text" id="description_id" class="form-control{{ $errors->has('description_id') ? ' is-invalid' : '' }}" name="description_id" autofocus="" style="height: auto">{{ old('description_id') ? old('description_id') : $post->translate('id')->description }}</textarea>
                                @include('cp.components.form-error', ['field' => 'description_id'])
                            </div>
                        </div>
                        <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                            <div class="form-group">
                                <label for="title_en" class="col-form-label text-right">Judul</label>
                                <input type="text" id="title_en" class="form-control{{ $errors->has('title_en') ? ' is-invalid' : '' }}" name="title_en" autofocus="" value="{{ old('title_en') ? old('title_en') : $post->translate('en')->title }}">
                                @include('cp.components.form-error', ['field' => 'title_en'])
                            </div>
                            <div class="form-group">
                                <label for="description_en" class="col-form-label text-right">Deskripsi</label>
                                <textarea rows="4" type="text" id="description_en" class="form-control{{ $errors->has('description_en') ? ' is-invalid' : '' }}" name="description_en" autofocus="" style="height: auto">{{ old('description_en') ? old('description_en') : $post->translate('en')->description }}</textarea>
                                @include('cp.components.form-error', ['field' => 'description_en'])
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ar" role="tabpanel" aria-labelledby="ar-tab">
                            <div class="form-group">
                                <label for="title_ar" class="col-form-label text-right">Judul</label>
                                <input dir='rtl' type="text" id="title_ar" class="form-control{{ $errors->has('title_ar') ? ' is-invalid' : '' }}" name="title_ar" autofocus="" value="{{ old('title_ar') ? old('title_ar') : $post->translate('ar')->title }}">
                                @include('cp.components.form-error', ['field' => 'title_ar'])
                            </div>
                            <div class="form-group">
                                <label for="description_ar" class="col-form-label text-right">Deskripsi</label>
                                <textarea rows="4" type="text" id="description_ar" class="form-control{{ $errors->has('description_ar') ? ' is-invalid' : '' }}" name="description_ar" autofocus="" style="height: auto">{{ old('description_ar') ? old('description_ar') : $post->translate('ar')->description }}</textarea>
                                @include('cp.components.form-error', ['field' => 'description_ar'])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <!-- <div class="form-group">
                        <label class="custom-switch p-0">
                            <input type="checkbox" name="is_running_text" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Set as running text</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="custom-switch p-0">
                            <input type="checkbox" name="is_featured_product" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Set as featured product in homepage</span>
                        </label>
                    </div> -->
                    <div class="form-group{{ $errors->has('is_published') ? ' has-error' : '' }}">
                        <label for="is_published">Publishing Status</label>
                        <select id="is_published" name="is_published" class="form-control">
                            <option value="1" {{ old('is_published') ? (old('is_published') == 1 ? 'selected' : '') : ($post->is_published == 1 ? 'selected' : '') }}>Published</option>
                            <option value="0" {{ old('is_published') ? (old('is_published') == 0 ? 'selected' : '') : ($post->is_published == 0 ? 'selected' : '') }}>Draft</option>
                        </select>
                        @include('cp.components.form-error', ['field' => 'is_published'])
                    </div>
                    <div class="form-group">
                        <label for="created_at" class="col-form-label text-right">Tanggal Post</label>
                        <input type="date" id="created_at" class="form-control{{ $errors->has('created_at') ? ' is-invalid' : '' }}" name="created_at" autofocus="" value="{{ old('created_at') ? old('created_at') : $post->created_at->format('Y-m-d') }}">
                        @include('cp.components.form-error', ['field' => 'created_at'])
                    </div>
                    <div class="form-group">
                        <label>Cover Image</label>
                        <div class="mb-2">
                            <img src="{{ asset($post->cover) }}" class="img-fluid" alt="" id="upload-img-preview" onerror="this.src='{{ asset('files/no-image.jpg') }}';">
                            <a href="#" class="text-danger" id="upload-img-delete" style="display: none;">Delete Cover Image</a>
                        </div>
                        <div class="custom-file">
                            <input type="file" accept="image/*" name="cover" id="cover" class="custom-file-input js-upload-image form-control{{ $errors->has('cover') ? ' is-invalid' : '' }}">
                            <label class="custom-file-label " for="cover">Choose file</label>
                            @include('cp.components.form-error', ['field' => 'cover'])
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('template') ? ' has-error' : '' }}">
                        <label for="template">Template Page</label>
                        <select name="template" class="form-control">
                            @foreach ($templates as $template)
                            <option value="{{ $template }}" {{ old('template') ? ($template == old('template') ? 'selected' : '') : ($template == $post->template ? 'selected' : '') }}>{{ $template }}</option>
                            @endforeach
                        </select>
                        @include('cp.components.form-error', ['field' => 'template'])
                    </div>
                    <div class="form-group">
                        <label for="external_link" class="col-form-label text-right">Link Eksternal</label>
                        <input type="text" id="external_link" class="form-control{{ $errors->has('external_link') ? ' is-invalid' : '' }}" name="external_link" autofocus="" value="{{ old('external_link') ? old('external_link') : $post->external_link }}">
                        @include('cp.components.form-error', ['field' => 'external_link'])
                    </div>
                    <div class="form-group">
                      <label class="custom-switch mt-2 pl-0">
                        <input type="checkbox" name="is_pinned" class="custom-switch-input" {{ $post->is_pinned == 1 ? 'checked' : (old('is_pinned') ? (old('is_pinned') == 'on' ? 'checked' : '') : '') }}>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Pinned Post</span>
                      </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-black-50">Files</h4>
                    <div class="card-header-action">
                        <button class="btn btn-primary tambah-file">
                            Add File
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Order</th>
                                <th scope="col">Title</th>
                                <th scope="col">File</th>
                                <th scope="col" class="table-fit">Downloadable</th>
                                <th scope="col" class="table-fit">Action</th>
                            </tr>
                        </thead>
                        <tbody id="body-table">
                        @foreach($post->files as $file)
                            <tr>
                                <td class="table-fit">
                                    @if (!$loop->first)
                                    <button type="button" id="{{ $file->id }}" data-type="up" class="btn btn-sm btn-light move">
                                        Move up <i class="fa fa-arrow-circle-up"></i>
                                    </button>
                                    @endif
                                    @if (!$loop->last)
                                    <button type="button" id="{{ $file->id }}" data-type="down" class="btn btn-sm btn-light move">
                                        Move down <i class="fa fa-arrow-circle-down"></i>
                                    </button>
                                    @endif
                                </td>
                                <td>
                                    {{ $file->title }}
                                </td>
                                <td>
                                    <span class="badge badge-secondary mb-2"><i class="fas fa-file"></i>&nbsp;
                                        <a class="text-white" href="{{ asset($file->file) }}" target="_blank">{{ $file->title }}</a>
                                    </span>
                                </td>
                                <td>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" class="custom-switch-input" onchange="changeDownloadable({{ $file->id }})" {{ $file->is_downloadable ? 'checked' : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </td>
                                <td>
                                    <button class="btn btn-danger delete-{{ $file->id }}" type="button" onclick="deleteFile({{ $file->id }})"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                    @if($menu->parent_id == 0)
                    <a href="{{route('cp.secondary-menus.show',$menu->id)}}" class="btn btn-secondary">
                        Batal
                    </a>
                    @else
                    <a href="{{route('cp.secondary-menus.submenus.show',[$menu->parent_id,$menu->id])}}" class="btn btn-secondary">
                        Batal
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
<div class="d-none">
    <table>
        <tbody id="table-row">
            <tr>
                <td></td>
                <td>
                    <input type="text" class="form-control" id="title_files" name="title_files[]" required="">
                </td>
                <td>
                    <input type="file" class="form-control" name="files[]" required="">
                </td>
                <td>
                    <button class="btn btn-danger hapus-file" type="button"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

@push('script')
<script type="text/javascript">
    $('.js-upload-image1').change(function(event) {
        makePreview1(this);
        $('#upload-img-preview1').show();
        $('#upload-img-delete1').show();
    });

    function makePreview1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#upload-img-preview1').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#upload-img-delete1').click(function(event) {
        event.preventDefault();

        $('#upload-img-preview1').attr('src', '').hide();
        $('.custom-file-input1').val(null);
        $(this).hide();
    });

    $('body').on('click', '.tambah-file', function(event) {
        event.preventDefault();

        var numItems = ($('.files').length);
        // var template = $('#table-row').html();
        var template = '<tr><td></td><td><input type="text" class="form-control files" id="title_files" name="title_files['+numItems+']" required=""></td><td><input type="file" class="form-control" name="files['+numItems+']" required=""></td><td><label class="custom-switch mt-2"><input type="checkbox" name="is_downloadable['+numItems+']" class="custom-switch-input" value="1"><span class="custom-switch-indicator"></span></label></td><td><button class="btn btn-danger hapus-file" type="button"><i class="fa fa-trash"></i></button></td></tr>';
        
        $('#body-table').append(template);
    });
    $('body').on('click', '.hapus-file', function(event) {
        event.preventDefault();

        var tableParent = $(this).closest('table');
        var trParent = $(this).closest('tr');
        trParent.remove();
    });

    function deleteFile(id) {
        var done = confirm('Are you sure want to delete it ?');
        if (done) {
            $.ajax({
                type: "DELETE",
                url: "{{ url('cp/delete-file') }}",
                data: {id: id},
                success: function (result) {
                    if (result) {
                        var tableParent = $('.delete-' + id).closest('table');
                        var trParent = $('.delete-' + id).closest('tr');
                        trParent.remove();
                        alert('file deleted !');
                    } else {
                        alert('failed to delete file');
                    }
                }
            });
        }
    }

    $('.move').click(function(event) {
            $.post('{{ route('cp.move-file') }}', {
                type: $(this).attr('data-type'),
                id: $(this).attr('id')
            }, function(data, textStatus, xhr) {
                window.location.reload();
            });
        });

    function changeDownloadable(id){
        $.ajax({
                type: "POST",
                url: "{{ route('cp.change-downloadable-file') }}",
                data: {
                    id: id
                }
            });
    }
</script>
@endpush