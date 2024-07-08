@extends('layouts.cp')

@section('title', 'Change Password')

@section('content')
<form action="{{ route('cp.passwords.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" name="new_password" autofocus="">
                        @include('cp.components.form-error', ['field' => 'new_password'])
                    </div>                
                    <div class="form-group">
                        <label for="new_confirm_password">New Password Confirmation</label>
                        <input type="password" id="new_confirm_password" class="form-control{{ $errors->has('new_confirm_password') ? ' is-invalid' : '' }}" name="new_confirm_password" autofocus="">
                        @include('cp.components.form-error', ['field' => 'new_confirm_password'])
                    </div>                    
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
