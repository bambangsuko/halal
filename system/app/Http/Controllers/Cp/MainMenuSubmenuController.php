<?php

namespace App\Http\Controllers\Cp;

use App\Menu;
use App\Post;
use App\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BreadcrumbRepository;
use Illuminate\Support\Facades\Auth;

class MainMenuSubmenuController extends Controller
{

    private $breadcrumbRepository;

    function __construct(BreadcrumbRepository $breadcrumbRepository)
    {
        $this->breadcrumbRepository = $breadcrumbRepository;
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            checkPermission($this->user, 'main-menus');
            return $next($request);
        });
    }

    public function create($menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        return view('cp.main-menu.submenu.create', [
            'menu' => $menu,
            'templates' => Template::menu(),
            'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($menu->id)
        ]);
    }

    public function store(Request $request, $menu_id)
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
            $file = $request->file('cover');
            $coverImage = $file->move('files/cover/', generateFileName($request->title_id, $file));
        }

        $submenu = Menu::create([
            'is_published' => $request->is_published,
            'cover' => !empty($coverImage) ? $coverImage : null,
            'template' => $request->template,
            'type' => $request->type,
            'parent_id' => $menu_id,
            'place' => 'mainmenu',
            'link' => $request->link,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'email' => $request->email,
            'website' => $request->website,
        ]);

        foreach (['id', 'en', 'ar'] as $locale) {
            $submenu->translateOrNew($locale)->title = $request->{"title_{$locale}"} ?? $request->title_id;
            $submenu->translateOrNew($locale)->description = $request->{"description_{$locale}"} ?? $request->description_id;
        }

        $submenu->update([
            'order' => $submenu->id
        ]);

        if ($menu->parent_id == 0) {
            return redirect(route('cp.main-menus.show', $menu->id))
                ->with('success', 'Submenu berhasil ditambahkan!');
        } else {
            return redirect(route('cp.main-menus.submenus.show', [$menu->parent_id, $menu->id]))
                ->with('success', 'Submenu berhasil ditambahkan!');
        }
    }

    public function show($menu_id, $submenu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        $submenu = Menu::where('id', $submenu_id)
            ->where('parent_id', $menu_id)
            ->firstOrFail();
        return view('cp.main-menu.submenu.show', [
            'parent' => $menu,
            'menu' => $submenu,
            'submenus' => Menu::where('parent_id', $submenu->id)->order()->paginate(9),
            'posts' => Post::where('menu_id', $submenu->id)->latest()->paginate(10),
            'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($submenu->id)
        ]);
    }

    public function edit($menu_id, $submenu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        $submenu = Menu::where('id', $submenu_id)
            ->where('parent_id', $menu_id)
            ->firstOrFail();
        return view('cp.main-menu.submenu.edit', [
            'parent' => $menu,
            'menu' => $submenu,
            'templates' => Template::menu(),
            'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($menu->id)
        ]);
    }

    public function update($menu_id, $submenu_id, Request $request)
    {
        $menu = Menu::findOrFail($menu_id);
        $submenu = Menu::where('id', $submenu_id)
            ->where('parent_id', $menu_id)
            ->firstOrFail();
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
            removeFile($submenu->cover);
            $file = $request->file('cover');
            $coverImage = $file->move('files/cover/', generateFileName($request->title_id, $file));
        }

        $submenu->update([
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
            $submenu->translateOrNew($locale)->title = $request->{"title_{$locale}"} ?? $request->title_id;
            $submenu->translateOrNew($locale)->description = $request->{"description_{$locale}"} ?? $request->description_id;
        }

        $submenu->save();

        // if ($menu->parent_id == 0) {
        //     return redirect(route('cp.main-menus.show', $menu->id))
        //         ->with('success', 'Submenu berhasil diubah!');
        // } else {
        return redirect(route('cp.main-menus.submenus.show', [$submenu->parent_id, $submenu->id]))
            ->with('success', 'Submenu berhasil diubah!');
        // }
    }

    public function destroy($menu_id, $submenu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        $submenu = Menu::where('id', $submenu_id)
            ->where('parent_id', $menu_id)
            ->firstOrFail();
        if ($submenu->id == 3 || $submenu->id == 4 || $submenu->id == 5) {
            return redirect()
                ->back()
                ->with('error', 'Menu tidak dapat dihapus!');
        }
        if ($menu->parent_id == 0) {
            $route = route('cp.main-menus.show', $menu->id);
        } else {
            $route = route('cp.main-menus.submenus.show', [$menu->parent_id, $menu->id]);
        }
        if (count($submenu->submenus) != 0) {
            return redirect($route)
                ->with('error', 'Submenu tidak dapat dihapus! Masih mempunyai submenu');
        }
        if (count($submenu->posts) != 0) {
            return redirect($route)
                ->with('error', 'Submenu tidak dapat dihapus! Masih mempunyai post');
        }
        $submenu->delete();
        return redirect($route)
            ->with('success', 'Submenu berhasil dihapus!');
    }
}
