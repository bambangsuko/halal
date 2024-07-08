@extends('layouts.cp')

@section('title')
<div class="section-header-back">
    <a href="{{ route('cp.users.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Edit User</h1>
@endsection

@section('content')
<form action="{{ route('cp.users.update', $user) }}" method="POST" enctype="multipart/form-data">
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
                        <label for="role_id">Role</label>
                        <select class="form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}" name="role_id" @if($user->id == 1) disabled @endif>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @include('cp.components.form-error', ['field' => 'role_id'])
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ? old('name') : $user->name }}" required>
                        @include('cp.components.form-error', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') ? old('username') : $user->username }}" required>
                        @include('cp.components.form-error', ['field' => 'username'])
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') ? old('email') : $user->email }}" required>
                        @include('cp.components.form-error', ['field' => 'email'])
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                        @include('cp.components.form-error', ['field' => 'password'])
                        <span class="text-danger" style="font-size: 12px">* kosongkan jika tidak ingin mengganti password</span>
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
