@extends('layouts.cp')

@section('title')
<div class="section-header-back">
    <a href="{{ $menu->parent_id == 0 ? (route('cp.home-menus.show', $menu)) : (route('cp.home-menus.submenus.show', [$menu->parent_id, $menu])) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Tambah Submenu</h1>
<div class="section-header-breadcrumb">
    @if(count($breadcrumbs) > 2)
    <div class="breadcrumb-item"><a href="{{ url('cp') }}">...</a></div>
    @else
    <div class="breadcrumb-item"><a href="{{ url('cp') }}">Dashboard</a></div>
    <div class="breadcrumb-item"><a href="{{ route('cp.home-menus.index') }}">Home Menu</a></div>
    @endif
    @foreach($breadcrumbs as $breadcrumb)
    <div class="breadcrumb-item"><a href="{{ $breadcrumb->parent_id == 0 ? route('cp.home-menus.show', $breadcrumb->id) : route('cp.home-menus.submenus.show', [$breadcrumb->parent_id, $breadcrumb->id]) }}">{{ $breadcrumb->title }}</a></div>
    @endforeach
    <div class="breadcrumb-item active">Tambah Submenu</div>
</div>
@endsection

@section('content')
<form action="{{ route('cp.home-menus.submenus.store', $menu) }}" method="POST" enctype="multipart/form-data">
    @csrf

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
                        <div class="tab-pane fade active show" id="id" role="tabpanel" aria-labelledby="id-tab">
                            <div class="form-group">
                                <label for="title_id">Judul</label>
                                <input type="text" id="title_id" class="form-control{{ $errors->has('title_id') ? ' is-invalid' : '' }}" name="title_id" autofocus="" value="{{ old('title_id') }}" placeholder="Judul dalam bahasa Indonesia">
                                @include('cp.components.form-error', ['field' => 'title_id'])
                            </div>
                            <div class="form-group">
                                <label for="description_id">Deskripsi</label>
                                <textarea style="height: 100px;" id="description_id" class="form-control{{ $errors->has('description_id') ? ' is-invalid' : '' }}" name="description_id" autofocus="">{{ old('description_id') }}</textarea>
                                @include('cp.components.form-error', ['field' => 'description_id'])
                            </div>
                        </div>
                        <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                            <div class="form-group">
                                <label for="title_en">Judul</label>
                                <input type="text" id="title_en" class="form-control" name="title_en" autofocus="" value="{{ old('title_en') }}" placeholder="Judul dalam bahasa Inggris">
                            </div>
                            <div class="form-group">
                                <label for="description_en">Deskripsi</label>
                                <textarea style="height: 100px;" id="description_en" class="form-control{{ $errors->has('description_en') ? ' is-invalid' : '' }}" name="description_en" autofocus="">{{ old('description_en') }}</textarea>
                                @include('cp.components.form-error', ['field' => 'description_en'])
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ar" role="tabpanel" aria-labelledby="ar-tab">
                            <div class="form-group">
                                <label for="title_ar">Judul</label>
                                <input dir="rtl" type="text" id="title_ar" class="form-control" name="title_ar" autofocus="" value="{{ old('title_ar') }}" placeholder="Judul dalam bahasa Arab">
                            </div>
                            <div class="form-group">
                                <label for="description_ar">Deskripsi</label>
                                <textarea style="height: 100px;" id="description_ar" class="form-control{{ $errors->has('description_ar') ? ' is-invalid' : '' }}" name="description_ar" autofocus="">{{ old('description_ar') }}</textarea>
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
                    <div class="form-group{{ $errors->has('is_published') ? ' has-error' : '' }}">
                        <label for="is_published">Publishing Status</label>
                        <select id="is_published" name="is_published" class="form-control{{ $errors->has('is_published') ? ' is-invalid' : '' }}">
                            <option value="1" {{ old('is_published') ? (old('is_published') == 1 ? 'selected' : '') : '' }}>Published</option>
                            <option value="0" {{ old('is_published') ? (old('is_published') == 0 ? 'selected' : '') : '' }}>Draft</option>
                        </select>
                        @include('cp.components.form-error', ['field' => 'is_published'])
                    </div>
                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                        <label for="type">Tipe</label>
                        <select id="type" name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}">
                            <option value="menu" {{ old('type') ? (old('type') == 'menu' ? 'selected' : '') : '' }}>Menu</option>
                            <option value="link" {{ old('type') ? (old('type') == 'link' ? 'selected' : '') : '' }}>Link</option>
                        </select>
                        @include('cp.components.form-error', ['field' => 'type'])
                    </div>
                    <div id="cover" class="form-group">
                        <label for="cover">Cover</label>
                        <img src="" class="w-100" alt="" id="upload-img-preview">
                        <a href="#" class="text-danger" id="upload-img-delete" style="display: none;">Delete Cover</a>
                        <div class="custom-file mt-2">
                            <input type="file" accept="image/*" name="cover" id="cover" class="custom-file-input js-upload-image form-control{{ $errors->has('cover') ? ' is-invalid' : '' }}">
                            <label class="custom-file-label " for="cover">Choose file</label>
                            @include('cp.components.form-error', ['field' => 'cover'])
                        </div>
                    </div>
                    <div id="template" class="form-group{{ $errors->has('template') ? ' has-error' : '' }}">
                        <label for="template">Template Page</label>
                        <select id="template-select" name="template" class="form-control">
                            @foreach ($templates as $template)
                            <option value="{{ $template }}" {{ old('template') ? (old('template') == $template ? 'selected' : '') : ($template == 'templates.menu.default' ? 'selected' : '') }}>{{ $template }}</option>
                            @endforeach
                        </select>
                        @include('cp.components.form-error', ['field' => 'template'])
                    </div>
                    <div id="faculty-detail" style="display: none;">
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea style="height: auto;" rows="4" id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" autofocus="" placeholder="ex: Jl. Pandawa, Pucangan, Kartasura, Sukoharjo, Jawa Tengah, Indonesia.">{{ old('address') }}</textarea>
                            @include('cp.components.form-error', ['field' => 'address'])
                        </div>
                        <div class="form-group">
                            <label for="phone">Telepon</label>
                            <input type="text" id="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" autofocus="" value="{{ old('phone') }}" placeholder="ex: +62271 7815 16">
                            @include('cp.components.form-error', ['field' => 'phone'])
                        </div>
                        <div class="form-group">
                            <label for="fax">Fax</label>
                            <input type="text" id="fax" class="form-control{{ $errors->has('fax') ? ' is-invalid' : '' }}" name="fax" autofocus="" value="{{ old('fax') }}" placeholder="ex: +62271 7827 74">
                            @include('cp.components.form-error', ['field' => 'fax'])
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" autofocus="" value="{{ old('email') }}" placeholder="ex: info@iain-surakarta.ac.id">
                            @include('cp.components.form-error', ['field' => 'email'])
                        </div>
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="text" id="website" class="form-control{{ $errors->has('website') ? ' is-invalid' : '' }}" name="website" autofocus="" value="{{ old('website') }}" placeholder="ex: https://uinsaid.ac.id/">
                            @include('cp.components.form-error', ['field' => 'website'])
                        </div>
                    </div>
                    <div class="form-group" id="link" style="display: none;">
                        <label for="link">Link</label>
                        <input type="text" id="link" class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" name="link" autofocus="" value="{{ old('link') }}" placeholder="ex: https://uinsaid.ac.id/">
                        @include('cp.components.form-error', ['field' => 'link'])
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                    <a href="{{ $menu->parent_id == 0 ? (route('cp.home-menus.show', $menu)) : (route('cp.home-menus.submenus.show', [$menu->parent_id, $menu])) }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('script')
<script>
    // CKEDITOR.instances['description'].destroy();
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

    $(document).ready(function() {
        $('#type').trigger("change");
        $('#template-select').trigger("change");
    });

    document.getElementById("type").onchange = function() {
        var $val = $(this).val();
        var $template = $('#template-select').val();
        if ($val == 'link') {
            $('#link').show();
            $('#cover').hide();
            $('#template').hide();
            $('#faculty-detail').hide();
        } else {
            $('#link').hide();
            $('#cover').show();
            $('#template').show();
            if ($template.substr(15) == 'faculty') {
                $('#faculty-detail').show();
            }
        }
    };

    document.getElementById("template-select").onchange = function() {
        var $val = $(this).val();
        if ($val.substr(15) == 'faculty') {
            $('#faculty-detail').show();
        } else {
            $('#faculty-detail').hide();
        }
    };
</script>
@endpush