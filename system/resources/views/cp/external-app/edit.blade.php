@extends('layouts.cp')

@section('title')
<div class="section-header-back">
    <a href="{{ route('cp.external-apps.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Edit Aplikasi Eksternal</h1>
@endsection

@section('content')
<form action="{{ route('cp.external-apps.update', $app) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" autofocus="" value="{{ $app->title }}">
                        @include('cp.components.form-error', ['field' => 'title'])
                    </div>
                    <div class="form-group">
                        <label for="link">Link</label>
                        <input type="text" id="link" class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" name="link" autofocus="" value="{{ $app->link }}">
                        @include('cp.components.form-error', ['field' => 'link'])
                    </div>
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <br>
                        <div class="mb-2">
                            <img src="{{ asset($app->logo) }}" class="w-100" alt="" id="upload-img-preview">
                            <a href="#" class="text-danger" id="upload-img-delete" style="display: none;">Delete Logo</a>
                        </div>
                        <div class="custom-file">
                            <input type="file" accept="image/*" name="logo" id="logo" class="custom-file-input js-upload-image form-control{{ $errors->has('logo') ? ' is-invalid' : '' }}">
                            <label class="custom-file-label " for="logo">Choose file</label>
                            @include('cp.components.form-error', ['field' => 'logo'])
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                    <a href="{{ route('cp.external-apps.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection