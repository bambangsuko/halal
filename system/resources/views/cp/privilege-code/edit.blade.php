@extends('layouts.cp')

@section('title')
<div class="section-header-back">
    <a href="{{ route('cp.privilege-codes.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Edit Privilege Code</h1>
@endsection

@section('content')
<form action="{{ route('cp.privilege-codes.update', $code) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-black-50">Konten</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" autofocus="" value="{{ $code->name }}">
                        @include('cp.components.form-error', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                        <label for="url">Url</label>
                        <input type="text" id="url" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" autofocus="" value="{{ $code->url }}">
                        @include('cp.components.form-error', ['field' => 'url'])
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea rows="3" style="height: auto" type="text" id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" autofocus>{{ $code->description }}</textarea>
                        @include('cp.components.form-error', ['field' => 'description'])
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                    <a href="{{ route('cp.roles.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection