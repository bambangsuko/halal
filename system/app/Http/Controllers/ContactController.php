<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller {

    public function store(Request $request) {
        $rules = [
            'name' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'message' => 'required',
        ];
        if (config('app.recapcha_secret')) {
            $rules = array_merge($rules, [
                'g-recaptcha-response' => 'required|recaptcha'
            ]);
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect(url($request->slug))
                            ->withErrors($validator)
                            ->withInput();
        }

        Contact::create($request->all());

        return redirect(url($request->slug))
                        ->with('success', '<p>Kami akan segera menindak lanjuti pesan Anda</p><p>Jika belum ada kabar dari kami selama 24 jam, silahkan hubungi call center kami</p>');
    }

}
