@extends('layouts.cp')

@section('title')
<div class="section-header-back">
    <a href="{{ route('cp.menus.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Edit Menu</h1>
@endsection

@section('content')
<form action="{{ route('cp.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-black-50">Content</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="id-tab" data-toggle="tab" href="#id" role="tab" aria-controls="id" aria-selected="true">Indonesia</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="false">English</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="id" role="tabpanel" aria-labelledby="id-tab">
                            <div class="form-group">
                                <label for="title_id" class="col-form-label text-right">Title</label>
                                <input type="text" id="title_id" class="form-control{{ $errors->has('title_id') ? ' is-invalid' : '' }}" name="title_id" autofocus="" value="{{ $menu->translate('id')->title }}">
                                @include('cp.components.form-error', ['field' => 'title_id'])
                            </div>
                            <div class="form-group">
                                <label for="description_id" class="col-form-label text-right">Description</label>
                                <textarea rows="4" type="text" id="description_id" class="form-control{{ $errors->has('description_id') ? ' is-invalid' : '' }}" name="description_id" autofocus="" style="height: auto">{{ $menu->translate('id')->description }}</textarea>
                                @include('cp.components.form-error', ['field' => 'description_id'])
                            </div>         
                        </div>
                        <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                            <div class="form-group">
                                <label for="title_en" class="col-form-label text-right">Title</label>
                                <input type="text" id="title_en" class="form-control{{ $errors->has('title_en') ? ' is-invalid' : '' }}" name="title_en" autofocus="" value="{{ $menu->translate('en')->title }}">
                                @include('cp.components.form-error', ['field' => 'title_en'])
                            </div>
                            <div class="form-group">
                                <label for="description_en" class="col-form-label text-right">Description</label>
                                <textarea rows="4" type="text" id="description_en" class="form-control{{ $errors->has('description_en') ? ' is-invalid' : '' }}" name="description_en" autofocus="" style="height: auto">{{ $menu->translate('en')->description }}</textarea>
                                @include('cp.components.form-error', ['field' => 'description_en'])
                            </div>         
                        </div>
                    </div>
                </div>                
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-black-50">Meta</h4>
                </div>
                <div class="card-body">
                    <div class="form-group{{ $errors->has('is_published') ? ' has-error' : '' }}">
                        <label for="is_published">Publishing Status</label>
                        <select id="is_published" name="is_published" class="form-control">
                            <option value="1" {{ $menu->is_published == 1 ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ $menu->is_published == 0 ? 'selected' : '' }}>Draft</option>
                        </select>
                        @include('cp.components.form-error', ['field' => 'is_published'])
                    </div>
                    <div class="form-group">
                        <label for="image" class="col-form-label text-right">Cover</label>
                        <div class="mb-2">
                            <img src="{{ asset($menu->cover) }}" class="img-fluid" alt="" id="upload-img-preview">
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
                            <option value="{{ $template }}" {{ $template == $menu->template ? 'selected' : '' }}>{{ $template }}</option>
                            @endforeach
                        </select>
                        @include('cp.components.form-error', ['field' => 'template'])
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                    <a href="{{ route('cp.menus.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection