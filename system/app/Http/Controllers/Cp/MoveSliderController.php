<?php

namespace App\Http\Controllers\Cp;

use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MoveSliderController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            checkPermission($this->user, 'sliders');
            return $next($request);
        });
    }

    public function update(Request $request) {
        $currentSlider = Slider::findOrFail($request->id);
        $currentSliderOrder = $currentSlider->order;
        if ($request->type == 'up') {
            $previousSlider = $currentSlider->previous();
            $currentSlider->update([
                'order' => $previousSlider->order
            ]);
            $previousSlider->update([
                'order' => $currentSliderOrder
            ]);
        }

        if ($request->type == 'down') {
            $nextSlider = $currentSlider->next();
            $currentSlider->update([
                'order' => $nextSlider->order
            ]);
            $nextSlider->update([
                'order' => $currentSliderOrder
            ]);
        }

        return response()->json([
                    'status' => 'Success'
        ]);
    }

}
