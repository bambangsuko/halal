<?php

namespace App\Http\Controllers\Cp;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            checkPermission($this->user, 'users');
            return $next($request);
        });
    }

    public function index() {
        return view('cp.user.index', [
            'users' => User::with('role')->paginate(10)
        ]);
    }

    public function create() {
        return view('cp.user.create', [
            'roles' => Role::get()
        ]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required',
        ]);
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'email_verified_at' => now(),
        ]);
        return redirect(route('cp.users.index'))
                        ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user) {
        return view('cp.user.show', [
            'user' => $user->load('role')
        ]);
    }

    public function edit(User $user) {
        return view('cp.user.edit', [
            'user' => $user->load('role'),
            'roles' => Role::get()
        ]);
    }

    public function update(Request $request, User $user) {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role_id' => $request->role_id ? $request->role_id : $user->role_id
        ]);

        return redirect(route('cp.users.index'))
                        ->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user) {
        if ($user->id == 1) {
            return redirect(route('cp.users.index'))
                            ->with('error', 'Not Allowed !');
        } else {
            $user->delete();
            return redirect(route('cp.users.index'))
                            ->with('success', 'User berhasil dihapus.');
        }
    }

}
