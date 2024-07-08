<?php

namespace App\Http\Controllers\Cp;

use App\ExternalApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExternalAppController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            checkPermission($this->user, 'external-apps');
            return $next($request);
        });
    }

    public function index()
    {
        return view('cp.external-app.index', [
            'apps' => ExternalApp::orderBy('created_at', 'DESC')->paginate(10)
        ]);
    }

    public function create()
    {
        return view('cp.external-app.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'link' => 'required',
                'logo' => 'required',
                'title' => 'required',
            ],
            [
                'link.required' => 'Link harus diisi !',
                'title.required' => 'Judul harus diisi !',
                'logo.required' => 'Logo harus diisi !',
            ]
        );
        $app = ExternalApp::create([
            'title' => $request->title,
            'link' => $request->link,
        ]);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logo = $file->move('files/apps/', generateFileName('logo', $file));
            $app->update(['logo' => $logo]);
        }
        return redirect(route('cp.external-apps.index'))
            ->with('success', 'Aplikasi Eksternal berhasil ditambahkan.');
    }

    public function show()
    {
        abort(404);
    }

    public function edit(ExternalApp $external_app)
    {
        return view('cp.external-app.edit', [
            'app' => $external_app
        ]);
    }

    public function update(Request $request, ExternalApp $external_app)
    {
        $request->validate(
            [
                'title' => 'required',
                'link' => 'required',
            ],
            [
                'title.required' => 'Judul harus diisi !',
                'link.required' => 'Link harus diisi !',
            ]
        );
        $external_app->update([
            'title' => $request->title,
            'link' => $request->link,
        ]);
        if ($request->hasFile('logo')) {
            removeFile($external_app->logo);
            $file = $request->file('logo');
            $logo = $file->move('files/apps/', generateFileName('logo', $file));
            $external_app->update(['logo' => $logo]);
        }
        return redirect(route('cp.external-apps.index'))
            ->with('success', 'Aplikasi Eksternal berhasil diubah.');
    }

    public function destroy(ExternalApp $external_app)
    {
        $external_app->delete();
        return redirect(route('cp.external-apps.index'))
            ->with('success', 'Aplikasi Eksternal berhasil dihapus.');
    }
}
