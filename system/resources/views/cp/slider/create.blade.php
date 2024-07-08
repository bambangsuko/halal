@extends('layouts.cp')

@section('title')
    <div class="section-header-back">
      <a href="{{ route('cp.sliders.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Slider</h1>
@endsection

@section('content')
<form action="{{ route('cp.sliders.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-black-50">Konten</h4>
                </div>
                <div class="card-body">
                    <div class="form-group row align-items-center">
                        <label for="image" class="col-sm-3 col-form-label text-right">Image</label>
                        <div class="col-sm-6">
                            <div class="mb-2">
                                <img src="" class="img-fluid" alt="" id="upload-img-preview" style="display: none;">
                                <a href="#" class="text-danger" id="upload-img-delete" style="display: none;">Delete Cover Image</a>
                            </div>
                            <div class="custom-file">
                                <input type="file" accept="image/*" name="image" id="image" class="custom-file-input js-upload-image form-control{{ $errors->has('image') ? ' is-invalid' : '' }}">
                                <label class="custom-file-label " for="image">Choose file</label>
                                @include('cp.components.form-error', ['field' => 'image'])
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="link" class="col-sm-3 col-form-label text-right">Link</label>
                        <div class="col-sm-6">
                            <input type="text" id="link" class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" name="link" value="{{ old('link') }}">
                            @include('cp.components.form-error', ['field' => 'link'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="caption" class="col-sm-3 col-form-label text-right">Caption</label>
                        <div class="col-sm-6">
                            <textarea id="caption" cols="30" rows="5" class="form-control{{ $errors->has('caption') ? ' is-invalid' : '' }}" style="height: auto;" name="caption">{{ old('caption') }}</textarea>
                            @include('cp.components.form-error', ['field' => 'caption'])
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <div class="col-sm-6 offset-sm-3">
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                        <a href="{{ route('cp.sliders.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
