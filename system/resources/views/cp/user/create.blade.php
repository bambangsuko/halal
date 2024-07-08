@extends('layouts.cp')

@section('title')
<div class="section-header-back">
    <a href="{{ route('cp.users.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Tambah User</h1>
@endsection

@section('content')
<form action="{{ route('cp.users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-black-50">Konten</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select class="form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}" name="role_id">
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @include('cp.components.form-error', ['field' => 'role_id'])
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                        @include('cp.components.form-error', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>
                        @include('cp.components.form-error', ['field' => 'username'])
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                        @include('cp.components.form-error', ['field' => 'email'])
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required>
                        @include('cp.components.form-error', ['field' => 'password'])
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                    <a href="{{ route('cp.users.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
