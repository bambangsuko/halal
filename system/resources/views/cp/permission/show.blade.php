@extends('layouts.cp')

@section('title')
<div class="section-header-back">
    <a href="{{ route('cp.permissions.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Detail Permission</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <dl class="meta">  
                    <dt>Nama Role</dt>
                    <dd>{{ $role->name }}</dd>

                    <dt>Permission</dt>
                    <dd>
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($role->permissions as $permission)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $permission->privilegecode->name }}</td>
                                    <td>{{ $permission->privilegecode->description }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </dd>                    
                </dl>
            </div>
            <div class="card-footer bg-whitesmoke">
                <a href="{{ route('cp.permissions.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
