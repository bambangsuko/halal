<?php

namespace App\Http\Controllers\Cp;

use App\Menu;
use App\Post;
use App\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BreadcrumbRepository;
use Illuminate\Support\Facades\Auth;

class MenuSubmenuController extends Controller {

    private $breadcrumbRepository;

    function __construct(BreadcrumbRepository $breadcrumbRepository) {
        $this->breadcrumbRepository = $breadcrumbRepository;
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            checkPermission($this->user, 'menus');
            return $next($request);
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Menu $menu) {
        return view('cp.submenu.create', [
            'menu' => $menu,
            'templates' => Template::menu(),
            'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($menu->id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Menu $menu, Request $request) {
        $this->validate($request, [
            'title_id' => 'required',
            'is_published' => 'required',
            'cover' => 'image',
            'template' => 'required',
        ]);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $coverImage = $file->move('files/cover/', generateFileName($request->title_id, $file));
        }

        $submenu = new Menu();
        $submenu->cover = !empty($coverImage) ? $coverImage : null;
        $submenu->is_published = $request->is_published;
        $submenu->template = $request->template;
        $submenu->parent_id = $menu->id;
        $submenu->is_hidden = $menu->is_hidden;

        foreach (['id', 'en'] as $locale) {
            $submenu->translateOrNew($locale)->title = $request->{"title_{$locale}"} ?? $request->title_id;
            $submenu->translateOrNew($locale)->description = $request->{"description_{$locale}"} ?? $request->description_id;
        }

        $submenu->save();
        if ($menu->parent_id == 0) {
            return redirect(route('cp.menus.show', $menu->id))
                            ->with('success', 'Submenu added.');
        } else {
            return redirect(route('cp.menus.submenus.show', [$menu->parent_id, $menu->id]))
                            ->with('success', 'Submenu added.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu, Menu $submenu) {
        $get = Menu::where('id', $submenu->id)
                ->where('parent_id', $menu->id)
                ->firstOrFail();
        return view('cp.submenu.show', [
            'parent' => $menu,
            'menu' => $submenu,
            'submenus' => Menu::where('parent_id', $submenu->id)->get(),
            'posts' => Post::where('menu_id', $submenu->id)->paginate(10),
            'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($submenu->id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu, Menu $submenu) {
        return view('cp.submenu.edit', [
            'parent' => $menu,
            'menu' => $submenu,
            'templates' => Template::menu(),
            'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($menu->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Menu $menu, Menu $submenu, Request $request) {
        $this->validate($request, [
            'title_id' => 'required',
            'is_published' => 'required',
            'cover' => 'image',
            'template' => 'required',
        ]);

        if ($request->hasFile('cover')) {
            removeFile($submenu->cover);
            $file = $request->file('cover');
            $coverImage = $file->move('files/cover/', generateFileName($request->title_id, $file));
        }

        $submenu->cover = !empty($coverImage) ? $coverImage : $submenu->cover;
        $submenu->is_published = $request->is_published;
        $submenu->template = $request->template;
        $submenu->parent_id = $menu->id;

        foreach (['id', 'en'] as $locale) {
            $oldTitle = $submenu->translate($locale)->title;
            $submenu->translateOrNew($locale)->title = $request->{"title_{$locale}"} ?? $request->title_id;
//            if ($request->{"title_{$locale}"} != $oldTitle) {
//                $menu->translateOrNew($locale)->slug        = $request->{"slug_{$locale}"} ?? $request->slug_id;
//            }
            $submenu->translateOrNew($locale)->description = $request->{"description_{$locale}"} ?? $request->description_id;
        }

        $submenu->save();

        if ($menu->parent_id == 0) {
            return redirect(route('cp.menus.show', $menu->id))
                            ->with('success', 'Submenu updated.');
        } else {
            return redirect(route('cp.menus.submenus.show', [$menu->parent_id, $menu->id]))
                            ->with('success', 'Submenu updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu, Menu $submenu) {
        $isHaveChild = Menu::where('parent_id', $submenu->id)->get();
        $isHavePost = Post::where('menu_id', $submenu->id)->get();
        if (count($isHaveChild) != 0 || count($isHavePost) != 0) {
            if ($menu->parent_id == 0) {
                return redirect(route('cp.menus.show', $menu->id))
                                ->with('error', 'Cannot delete Submenu, still have child / post.');
            } else {
                return redirect(route('cp.menus.submenus.show', [$menu->parent_id, $menu->id]))
                                ->with('error', 'Cannot delete Submenu, still have child / post.');
            }
        } elseif ($submenu->id == 8 || $submenu->id == 9 || $submenu->id == 10 || $submenu->id == 11 || $submenu->id == 39 || $submenu->id == 40 || $submenu->id == 42 || $submenu->id == 43) {
            if ($menu->parent_id == 0) {
                return redirect(route('cp.menus.show', $menu->id))
                                ->with('error', 'Submenu cannot be deleted.');
            } else {
                return redirect(route('cp.menus.submenus.show', [$menu->parent_id, $menu->id]))
                                ->with('error', 'Submenu cannot be deleted.');
            }
        } else {
            $submenu->delete();
            if ($menu->parent_id == 0) {
                return redirect(route('cp.menus.show', $menu->id))
                                ->with('success', 'Submenu deleted.');
            } else {
                return redirect(route('cp.menus.submenus.show', [$menu->parent_id, $menu->id]))
                                ->with('success', 'Submenu deleted.');
            }
        }
    }

}
