@extends('layouts.cp')

@section('title', 'Setting')

@section('content')
<div class="row">
    <div class="col-12">
        <form id="setting-form" action="{{ route('cp.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <p class="text-muted">General settings.</p>

            <div class="form-group row align-items-center">
                <label for="name" class="form-control-label col-sm-2 text-md-right">Nama Website</label>
                <div class="col-sm-6 col-md-6">
                    <input type="text" id="name" name="setting[name]" class="form-control" value="{{ data_get($setting, 'name') }}">
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="tagline" class="form-control-label col-sm-2 text-md-right">Tagline</label>
                <div class="col-sm-6 col-md-6">
                    <textarea type="text" id="tagline" name="setting[tagline]" rows="3" class="form-control" style="height: auto;">{{ data_get($setting, 'tagline') }}</textarea>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="deskripsi" class="form-control-label col-sm-2 text-md-right">Deskripsi Website</label>
                <div class="col-sm-6 col-md-6">
                    <textarea type="text" id="deskripsi" name="setting[description]" rows="3" class="form-control" style="height: auto;">{{ data_get($setting, 'description') }}</textarea>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="address" class="form-control-label col-sm-2 text-md-right">Alamat</label>
                <div class="col-sm-6 col-md-6">
                    <textarea type="text" id="address" name="setting[address]" rows="3" class="form-control" style="height: auto;">{{ data_get($setting, 'address') }}</textarea>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="phone" class="form-control-label col-sm-2 text-md-right">Embed Google Maps</label>
                <div class="col-sm-6 col-md-6">
                    <input type="text" id="maps" name="setting[maps]" class="form-control" value="{{ data_get($setting, 'maps') }}">
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="phone" class="form-control-label col-sm-2 text-md-right">Telepon</label>
                <div class="col-sm-6 col-md-6">
                    <input type="text" id="phone" name="setting[phone]" class="form-control" value="{{ data_get($setting, 'phone') }}">
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="fax" class="form-control-label col-sm-2 text-md-right">Fax</label>
                <div class="col-sm-6 col-md-6">
                    <input type="text" id="fax" name="setting[fax]" class="form-control" value="{{ data_get($setting, 'fax') }}">
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="email" class="form-control-label col-sm-2 text-md-right">Email</label>
                <div class="col-sm-6 col-md-6">
                    <input type="text" id="email" name="setting[email]" class="form-control" value="{{ data_get($setting, 'email') }}">
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label class="form-control-label col-sm-2 text-md-right">Logo Website</label>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-2">
                        <img src="{{ asset(data_get($setting, 'logo')) }}" class="img-fluid" alt="" id="upload-img-preview">
                        <a href="#" class="text-danger" id="upload-img-delete" style="display: none;">Delete Cover Image</a>
                    </div>
                    <div class="custom-file">
                        <input type="file" accept="image/*" name="setting[logo]" id="image" class="custom-file-input js-upload-image form-control{{ $errors->has('setting.logo') ? ' is-invalid' : '' }}">
                        <label class="custom-file-label " for="image">Choose file</label>
                        @include('cp.components.form-error', ['field' => 'setting.logo'])
                    </div>
                    <div class="form-text text-muted">The image must have a maximum size of 2MB</div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label class="form-control-label col-sm-2 text-md-right">Icon Website</label>
                <div class="col-sm-6 col-md-6">
                    <div class="mb-2">
                        <img src="{{ asset(data_get($setting, 'icon')) }}" class="img-fluid" alt="" id="upload-img-preview1">
                        <a href="#" class="text-danger" id="upload-img-delete1" style="display: none;">Delete Cover Image</a>
                    </div>
                    <div class="custom-file">
                        <input type="file" accept="image/*" name="setting[icon]" id="image" class="custom-file-input js-upload-image1 form-control{{ $errors->has('setting.icon') ? ' is-invalid' : '' }}">
                        <label class="custom-file-label" for="image">Choose file</label>
                        @include('cp.components.form-error', ['field' => 'setting.icon'])
                    </div>
                    <div class="form-text text-muted">The image must have a maximum size of 2MB</div>
                </div>
            </div>
            @if(data_get($setting, 'homepage_banner') == 'video')
            <div class="form-group row align-items-center">
                <label class="form-control-label col-sm-2 text-md-right">Video Banner</label>
                <div class="col-sm-6 col-md-6">
                    <video width="100%" controls style="display: {{ data_get($setting, 'icon') ? 'block' : 'none' }}; margin-bottom: 20px;" id="video-content">
                        <source src="{{ asset(data_get($setting, 'video')) }}" id="video-source">
                        Your browser does not support HTML5 video.
                    </video>
                    <a href="#" class="text-danger" id="upload-video-delete" style="display: none; margin-bottom: 20px">Delete Video</a>
                    <div class="custom-file">
                        <input type="file" accept="video/*" name="setting[video]" id="video" class="file-video custom-file-input form-control{{ $errors->has('setting.video') ? ' is-invalid' : '' }}">
                        <label class="custom-file-label" for="video">Choose file</label>
                        @include('cp.components.form-error', ['field' => 'setting.video'])
                    </div>
                    <div class="form-text text-muted">*mp4 format</div>
                </div>
            </div>
            @endif
            <div class="form-group row align-items-center">
                <div class="col-sm-6 col-md-6 offset-md-2">
                    <button class="btn btn-primary" id="save-btn">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).on("change", ".file-video", function(evt) {
        console.log(this.files);
        $('#video-content').show();
        $('#upload-video-delete').show();
        var $source = $('#video-source');
        $source[0].src = URL.createObjectURL(this.files[0]);
        $source.parent()[0].load();
    });

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

    $('.js-upload-image2').change(function(event) {
        makePreview2(this);
        $('#upload-img-preview2').show();
        $('#upload-img-delete2').show();
    });

    function makePreview2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#upload-img-preview2').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#upload-img-delete2').click(function(event) {
        event.preventDefault();

        $('#upload-img-preview2').attr('src', '').hide();
        $('.custom-file-input2').val(null);
        $(this).hide();
    });

    $('.js-upload-image3').change(function(event) {
        makePreview3(this);
        $('#upload-img-preview3').show();
        $('#upload-img-delete3').show();
    });

    function makePreview3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#upload-img-preview3').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#upload-img-delete3').click(function(event) {
        event.preventDefault();

        $('#upload-img-preview3').attr('src', '').hide();
        $('.custom-file-input3').val(null);
        $(this).hide();
    });
</script>
@endpush