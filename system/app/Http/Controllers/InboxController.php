<?php

namespace App\Http\Controllers;

use App\Inbox;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Mail\SendInbox;

class InboxController extends Controller
{

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|numeric',
            'message' => 'required',
        ];
        if (config('app.recapcha_secret')) {
            $rules = array_merge($rules, [
                'g-recaptcha-response' => 'required|recaptcha'
            ]);
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $inbox = Inbox::create($request->all());
        
        $email = Setting::where('key', 'email_destination')->first();
        Mail::to($email->value)->send(new SendInbox($inbox));

        return redirect()
            ->back()
            ->with('success', [
                'page' => 'info',
            ]);
    }
}
