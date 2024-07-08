<?php

namespace App\Http\Controllers\Cp;

use App\Role;
use App\PrivilegeCode;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            checkPermission($this->user, 'permissions');
            return $next($request);
        });
    }

    public function index() {
        return view('cp.permission.index', [
            'roles' => Role::paginate(10)
        ]);
    }

    public function create() {
        abort(404);
    }

    public function store() {
        abort(404);
    }

    public function show($id) {
        if ($id != 1) {
            return view('cp.permission.show', [
                'role' => Role::with('permissions.privilegecode')->findOrFail($id)
            ]);
        } else {
            return redirect(route('cp.permissions.index'))
                            ->with('error', 'Not Allowed !');
        }
    }

    public function edit($id) {
        if ($id != 1) {
            return view('cp.permission.edit', [
                'role' => Role::with('permissions')->findOrFail($id),
                'codes' => PrivilegeCode::get()
            ]);
        } else {
            return redirect(route('cp.permissions.index'))
                            ->with('error', 'Not Allowed !');
        }
    }

    public function update(Request $request, $id) {
        $gets = Permission::where('role_id', $id)->get();
        foreach ($gets as $get) {
            $get->delete();
        }

        $this->validate($request, [
            'permissions' => 'required'
        ]);

        foreach ($request->permissions as $key => $permission) {
            Permission::create([
                'role_id' => $id,
                'privilege_code_id' => $key
            ]);
        }
        return redirect(route('cp.permissions.index'))
                        ->with('success', 'Permission updated.');
    }

    public function destroy() {
        abort(404);
    }

}
