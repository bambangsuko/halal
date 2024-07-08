@extends('layouts.cp')

@section('title')
    <div class="section-header-back">
      <a href="{{ route('cp.social-media.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Sosial Media</h1>
@endsection

@section('content')
<form action="{{ route('cp.social-media.update', $socialMedia) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-black-50">Konten</h4>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label text-right">Nama Sosial Media</label>
                        <div class="col-sm-6">
                            <input type="text" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" autofocus="" value="{{ $socialMedia->name }}">
                            @include('cp.components.form-error', ['field' => 'name'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="link" class="col-sm-3 col-form-label text-right">Link / URL</label>
                        <div class="col-sm-6">
                            <input type="text" id="link" class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" name="link" autofocus="" value="{{ $socialMedia->link }}" placeholder="https://twitter.com/weldon_wallpaint">
                            @include('cp.components.form-error', ['field' => 'link'])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="icon" class="col-sm-3 col-form-label text-right">
                            Icon Sosial Media
                            <a href="https://fontawesome.com/icons" target="_blank" title="List Sosial Media?">?</a>
                        </label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="text" id="icon" class="form-control{{ $errors->has('icon') ? ' is-invalid' : '' }}" name="icon" autofocus="" value="{{ $socialMedia->icon }}" placeholder="fab fa-facebook">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="{{ $socialMedia->icon }}"></i>
                                    </div>
                                </div>
                                @include('cp.components.form-error', ['field' => 'icon'])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <div class="col-sm-6 offset-sm-3">
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                        <a href="{{ route('cp.social-media.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('script')
    <script>
        $('#icon').keyup(function(event) {
            $(this).siblings('.input-group-append').find('i').removeClass().addClass($(this).val());
        });
    </script>
@endpush
