<?php

namespace App\Http\Controllers\Cp;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            checkPermission($this->user, 'settings');
            return $next($request);
        });
    }

    public function edit()
    {
        return view('cp.setting.edit', [
            'setting' => Setting::pluck('value', 'key')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'setting.logo' => 'image',
            'setting.icon' => 'image',
            'setting.video' => 'mimes:mp4'
        ], [
            'setting.logo.image' => 'Logo website must be an image.',
            'setting.icon.image' => 'Icon website must be an image.',
            // 'setting.video.video' => 'Video banner must be an video.',
            'setting.video.mimes' => 'Video banner must be an mp4 format.',
        ]);

        collect($request->setting)
            ->each(function ($value, $key) use ($request) {
                if ($key == 'logo') {
                    if ($request->hasFile('setting.logo')) {
                        $setting = Setting::where('key', $key)->firstOrFail();
                        removeFile($setting->value);
                        $file = $request->file('setting.logo');
                        $value = $file->move('files/', generateFileName('logo', $file));
                    }
                }
                if ($key == 'icon') {
                    if ($request->hasFile('setting.icon')) {
                        $setting = Setting::where('key', $key)->firstOrFail();
                        removeFile($setting->value);
                        $file = $request->file('setting.icon');
                        $value = $file->move('files/', generateFileName('icon', $file));
                    }
                }
                if ($key == 'video') {
                    if ($request->hasFile('setting.video')) {
                        $setting = Setting::where('key', $key)->firstOrFail();
                        removeFile($setting->value);
                        $file = $request->file('setting.video');
                        $value = $file->move('files/', generateFileName('video', $file));
                    }
                }

                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            });

        return redirect(route('cp.settings.edit'))
            ->with('success', 'Setting saved.');
    }
}
