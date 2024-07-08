<?php

namespace App\Http\Controllers\Cp;

use App\Menu;
use App\Post;
use App\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BreadcrumbRepository;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller {

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('cp.menu.index', [
            'menus' => Menu::where('parent_id', 0)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu) {
        $get = Menu::where('id', $menu->id)
                ->where('parent_id', 0)
                ->firstOrFail();
        return view('cp.menu.show', [
            'menu' => $menu,
            'submenus' => Menu::where('parent_id', $menu->id)->get(),
            'posts' => Post::where('menu_id', $menu->id)->paginate(10),
            'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($menu->id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu) {
        return view('cp.menu.edit', [
            'menu' => $menu,
            'templates' => Template::menu()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu) {
        $this->validate($request, [
            'title_id' => 'required',
            'is_published' => 'required',
            'cover' => 'image',
            'template' => 'required',
        ]);

        if ($request->hasFile('cover')) {
            removeFile($menu->cover);
            $file = $request->file('cover');
            $coverImage = $file->move('files/cover/', generateFileName($request->title_id, $file));
        }

        $menu->cover = !empty($coverImage) ? $coverImage : $menu->cover;
        $menu->is_published = $request->is_published;
        $menu->template = $request->template;
        $menu->parent_id = 0;

        foreach (['id', 'en'] as $locale) {
            $oldTitle = $menu->translate($locale)->title;
            $menu->translateOrNew($locale)->title = $request->{"title_{$locale}"} ?? $request->title_id;
//            if ($request->{"title_{$locale}"} != $oldTitle) {
//                $menu->translateOrNew($locale)->slug        = $request->{"slug_{$locale}"} ?? $request->slug_id;
//            }
            $menu->translateOrNew($locale)->description = $request->{"description_{$locale}"} ?? $request->description_id;
        }

        $menu->save();

        return redirect(route('cp.menus.index'))
                        ->with('success', 'Menu updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu) {
        abort(404);
    }

}
