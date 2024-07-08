@extends('layouts.cp')

@section('title')
<div class="section-header-back">
    <a href="{{ route('cp.users.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Detail User</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <dl class="meta">       
                    <dt>Nama</dt>
                    <dd>{{ $user->name }}</dd>
                    
                    <dt>Username</dt>
                    <dd>{{ $user->username }}</dd>                  
                    
                    <dt>Email</dt>
                    <dd>{{ $user->email }}</dd>  
                    
                    <dt>Role</dt>
                    <dd>{{ $user->role->name }}</dd> 
                    
                    <dt>Created At</dt>
                    <dd>{{ $user->created_at->format('d F Y') }}</dd>
                    
                    <dt>Updated At</dt>
                    <dd>{{ $user->updated_at->format('d F Y') }}</dd>
                </dl>
            </div>
            <div class="card-footer bg-whitesmoke">
                <a href="{{ route('cp.users.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
