@extends('layouts.cp')

@section('title')
<div class="section-header-back">
    <a href="{{ route('cp.permissions.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Edit Permission</h1>
@endsection

@section('content')
<form action="{{ route('cp.permissions.update', $role) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-black-50">Role {{ $role->name }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Deskripsi</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($codes as $code)
                            @php
                            $checked = NULL;
                            @endphp
                            <tr>
                                <td class="table-fit text-center">{{ $loop->iteration }}</td>
                                <td>{{ $code->name }}</td>
                                <td>{{ $code->description }}</td>
                                <td>
                                    @foreach($role->permissions as $permission)
                                    @if($permission->privilege_code_id == $code->id)
                                    @php
                                    $checked = 'checked';
                                    @endphp
                                    @break
                                    @endif
                                    @endforeach
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="permissions[{{ $code->id }}]" class="custom-switch-input" {{ $checked ? $checked : '' }}>
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                    <a href="{{ route('cp.permissions.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection