<?php

namespace App\Http\Controllers;

use App\Calculation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CalculateController extends Controller
{

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'company' => 'required',
            'birth_date' => 'required',
            'location' => 'required',
            'phone' => 'required|numeric',
            'salary' => 'required',
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

        $age = getAge($request->birth_date);
        if (checkAge($age)) {
            $max_loan = countMaxLoan($age, $request->salary);
            $calculation = Calculation::create([
                'name' => $request->name,
                'company' => $request->company,
                'birth_date' => $request->birth_date,
                'location' => $request->location == 'Other' ? $request->location_other : $request->location,
                'location_other' => $request->location == 'Other' ? 1 : 0,
                'phone' => $request->phone,
                'salary' => $request->salary,
                'email' => $request->email,
                'max_loan' => $max_loan,
            ]);

            return redirect()
                ->back()
                ->with('success', [
                    'calculation' => $calculation,
                    'page' => 'calculation',
                ]);
        } else {
            return redirect()
                ->back()
                ->with('error', 'error');
        }
    }
}
