<?php

namespace App\Http\Controllers\Cp;

use App\Menu;
use App\Post;
use App\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BreadcrumbRepository;
use Illuminate\Support\Facades\Auth;

class HomeMenuController extends Controller
{

    private $breadcrumbRepository;

    function __construct(BreadcrumbRepository $breadcrumbRepository)
    {
        $this->breadcrumbRepository = $breadcrumbRepository;
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            checkPermission($this->user, 'home-menus');
            return $next($request);
        });
    }

    public function index()
    {
        return view('cp.home-menu.index', [
            'menus' => Menu::where('parent_id', 0)
                ->isHomepageMenu()
                ->order()
                ->paginate(9)
        ]);
    }

    public function create()
    {
        return view('cp.home-menu.create', [
            'templates' => Template::menu()
        ]);
    }

    public function store(Request $request)
    {
        if ($request->type == 'menu') {
            if ($request->template == 'templates.menu.faculty') {
                $this->validate($request, [
                    'title_id' => 'required',
                    'is_published' => 'required',
                    'cover' => 'image',
                    'template' => 'required',
                    'type' => 'required',
                    'address' => 'required',
                    'phone' => 'required',
                    'fax' => 'required',
                    'email' => 'required',
                    'website' => 'required',
                ]);
            } else {
                $this->validate($request, [
                    'title_id' => 'required',
                    'is_published' => 'required',
                    'cover' => 'image',
                    'template' => 'required',
                    'type' => 'required',
                ]);
            }
        } else {
            $this->validate($request, [
                'title_id' => 'required',
                'is_published' => 'required',
                'cover' => 'image',
                'template' => 'required',
                'type' => 'required',
                'link' => 'required'
            ]);
        }

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $coverImage = $file->move('files/cover/', generateFileName($request->title_id, $file));
        }

        $menu = Menu::create([
            'is_published' => $request->is_published,
            'cover' => !empty($coverImage) ? $coverImage : null,
            'template' => $request->template,
            'type' => $request->type,
            'parent_id' => 0,
            'place' => 'homepage',
            'link' => $request->link,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'email' => $request->email,
            'website' => $request->website,
        ]);

        foreach (['id', 'en', 'ar'] as $locale) {
            $menu->translateOrNew($locale)->title = $request->{"title_{$locale}"} ?? $request->title_id;
            $menu->translateOrNew($locale)->description = $request->{"description_{$locale}"} ?? $request->description_id;
        }

        $menu->update([
            'order' => $menu->id
        ]);

        return redirect(route('cp.home-menus.index'))
            ->with('success', 'Menu berhasil dibuat!');
    }

    public function show($menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        return view('cp.home-menu.show', [
            'menu' => $menu,
            'submenus' => Menu::where('parent_id', $menu->id)->order()->paginate(9),
            'posts' => Post::where('menu_id', $menu->id)->latest()->paginate(10),
            'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($menu->id)
        ]);
    }

    public function edit($menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        return view('cp.home-menu.edit', [
            'menu' => $menu,
            'templates' => Template::menu()
        ]);
    }

    public function update(Request $request, $menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        if ($request->type == 'menu') {
            if ($request->template == 'templates.menu.faculty') {
                $this->validate($request, [
                    'title_id' => 'required',
                    'is_published' => 'required',
                    'cover' => 'image',
                    'template' => 'required',
                    'type' => 'required',
                    'address' => 'required',
                    'phone' => 'required',
                    'fax' => 'required',
                    'email' => 'required',
                    'website' => 'required',
                ]);
            } else {
                $this->validate($request, [
                    'title_id' => 'required',
                    'is_published' => 'required',
                    'cover' => 'image',
                    'template' => 'required',
                    'type' => 'required',
                ]);
            }
        } else {
            $this->validate($request, [
                'title_id' => 'required',
                'is_published' => 'required',
                'cover' => 'image',
                'template' => 'required',
                'type' => 'required',
                'link' => 'required'
            ]);
        }

        if ($request->hasFile('cover')) {
            removeFile($menu->cover);
            $file = $request->file('cover');
            $coverImage = $file->move('files/cover/', generateFileName($request->title_id, $file));
        }

        $menu->update([
            'is_published' => $request->is_published,
            'cover' => !empty($coverImage) ? $coverImage : null,
            'template' => $request->template,
            'type' => $request->type,
            'link' => $request->type == 'menu' ? NULL : $request->link,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'email' => $request->email,
            'website' => $request->website,
        ]);

        foreach (['id', 'en', 'ar'] as $locale) {
            $menu->translateOrNew($locale)->title = $request->{"title_{$locale}"} ?? $request->title_id;
            $menu->translateOrNew($locale)->description = $request->{"description_{$locale}"} ?? $request->description_id;
        }

        $menu->save();

        return redirect(route('cp.home-menus.show', $menu))
            ->with('success', 'Menu berhasil diubah!');
    }

    public function destroy($menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        if (count($menu->submenus) != 0) {
            return redirect(route('cp.home-menus.index'))
                ->with('error', 'Menu tidak dapat dihapus! Masih mempunyai submenu');
        }
        if (count($menu->posts) != 0) {
            return redirect(route('cp.home-menus.index'))
                ->with('error', 'Menu tidak dapat dihapus! Masih mempunyai post');
        }

        $menu->delete();
        return redirect(route('cp.home-menus.index'))
            ->with('success', 'Menu berhasil dihapus!');
    }
}
