<?php

namespace App\Http\Controllers\Cp;

use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            checkPermission($this->user, 'sliders');
            return $next($request);
        });
    }

    public function index() {
        return view('cp.slider.index', [
            'sliders' => Slider::order()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('cp.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'image' => 'required|image',
            // 'caption' => 'required'
        ]);

        $file = $request->file('image');
        $sliderImage = $file->move('files/slider/', generateFileName($request->caption, $file));

        $slider = Slider::create([
                    'image' => $sliderImage,
                    'caption' => $request->caption,
                    'link' => $request->link,
        ]);

        $slider->update([
            'order' => $slider->id
        ]);

        return redirect(route('cp.sliders.index'))
                        ->with('success', 'Slider berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider) {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider) {
        return view('cp.slider.edit', [
            'slider' => $slider
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider) {
        $this->validate($request, [
            'image' => 'image',
            // 'caption' => 'required'
        ]);

        if ($request->hasFile('image')) {
            removeFile($slider->image);
            $file = $request->file('image');
            $sliderImage = $file->move('files/slider/', generateFileName($request->caption, $file));
        }

        $slider->update([
            'image' => !empty($sliderImage) ? $sliderImage : $slider->image,
            'caption' => $request->caption,
            'link' => $request->link,
        ]);

        return redirect(route('cp.sliders.index'))
                        ->with('success', 'Slider berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider) {
        $slider->delete();

        return redirect(route('cp.sliders.index'))
                        ->with('success', 'Slider berhasil dihapus.');
    }

}
