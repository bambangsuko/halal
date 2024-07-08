<?php

namespace App\Http\Controllers\Cp;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            checkPermission($this->user, 'roles');
            return $next($request);
        });
    }

    public function index() {
        return view('cp.role.index', [
            'roles' => Role::paginate(10)
        ]);
    }

    public function create() {
        return view('cp.role.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required'
        ]);
        Role::create([
            'name' => $request->name
        ]);
        return redirect(route('cp.roles.index'))
                        ->with('success', 'Role berhasil ditambahkan.');
    }

    public function show(Role $role) {
        return view('cp.role.show', [
            'role' => $role
        ]);
    }

    public function edit(Role $role) {
        if ($role->id == 1) {
            return redirect(route('cp.roles.index'))
                            ->with('error', 'Not Allowed !');
        } else {
            return view('cp.role.edit', [
                'role' => $role
            ]);
        }
    }

    public function update(Request $request, Role $role) {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $role->update([
            'name' => $request->name
        ]);
        return redirect(route('cp.roles.index'))
                        ->with('success', 'Role berhasil diubah.');
    }

    public function destroy(Role $role) {
        if ($role->id == 1) {
            return redirect(route('cp.roles.index'))
                            ->with('error', 'Not Allowed !');
        } else {
            $role->delete();
            return redirect(route('cp.roles.index'))
                            ->with('success', 'Role berhasil dihapus.');
        }
    }

}
