<?php

namespace App\Http\Controllers\Cp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller {

    public function edit() {
        return view('cp.changepassword.edit', [
            'user' => user()
        ]);
    }

    public function update(Request $request) {
        $user = user();
        $request->validate([
            'new_password' => 'required|string|min:8',
            'new_confirm_password' => 'required|same:new_password'
        ]);
        
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect(route('cp.passwords.edit'))
                        ->with('success', 'Password changed.');
    }

}
