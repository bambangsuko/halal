<?php

namespace App\Http\Controllers\Cp;

use App\Menu;
use App\Post;
use App\Template;
use App\File;
use App\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BreadcrumbRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use App\Jobs\GenerateSitemapJob;

class MenuPostController extends Controller
{

    private $breadcrumbRepository;

    function __construct(BreadcrumbRepository $breadcrumbRepository)
    {
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
    public function create(Menu $menu)
    {
        return view('cp.post.create', [
            'menu' => $menu,
            'templates' => Template::post(),
            'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($menu->id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Menu $menu, Request $request)
    {
        $this->validate($request, [
            'title_id' => 'required',
            'is_published' => 'required',
            'cover' => 'image|file|max:300',
            'thumbnail' => 'image|file|max:300',
            'template' => 'required',
        ]);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $coverImage = $file->move('files/post/cover', generateFileName($request->title_id, $file));
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $thumbnailImage = $file->move('files/post/thumbnail', generateFileName($request->title_id, $file));
        }

        $post = new Post();
        $post->menu_id = $menu->id;
        $post->cover = !empty($coverImage) ? $coverImage : null;
        $post->thumbnail = !empty($thumbnailImage) ? $thumbnailImage : null;
        $post->is_published = $request->is_published;
        $post->is_running_text = $request->has('is_running_text') ? 1 : 0;
        $post->is_featured_product = $request->has('is_featured_product') ? 1 : 0;
        $post->template = $request->template;

        foreach (['id', 'en', 'ar'] as $locale) {
            $post->translateOrNew($locale)->title = $request->{"title_{$locale}"} ?? $request->title_id;
            $post->translateOrNew($locale)->description = $request->{"description_{$locale}"} ?? $request->description_id;
        }

        $post->save();

        if ($request->hasFile('files')) {
            $title = $request->title_files;
            $is_downloadable = $request->is_downloadable;
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                $insertFile = File::create([
                    'post_id' => $post->id,
                    'title' => $title[$key],
                    'file' => $file->move('files/post/files/', generateFileName($title[$key], $file)),
                    'is_downloadable' => isset($is_downloadable[$key]) ? 1 : 0
                ]);
                $insertFile->update([
                    'order' => $insertFile->id
                ]);
            }
        }

        if ($menu->parent_id == 0) {
            $redirect = route('cp.menus.show', $menu->id);
        } else {
            $redirect = route('cp.menus.submenus.show', [$menu->parent_id, $menu->id]);
        }

        // Memulai pemrosesan antrian untuk menjalankan fungsi sitemap
        Bus::dispatch(new GenerateSitemapJob());


        return redirect($redirect)
            ->with('success', 'Post added.');
    }

    public function show(Menu $menu, Post $post)
    {
        return view('cp.post.show', [
            'menu' => $menu,
            'post' => Post::with('files')
                ->where('id', $post->id)
                ->firstOrFail(),
            'locations' => Location::with('area')->paginate(10),
            'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($menu->id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu, Post $post)
    {
        return view('cp.post.edit', [
            'menu' => $menu,
            'post' => Post::with('files')
                ->where('id', $post->id)
                ->firstOrFail(),
            'templates' => Template::post(),
            'locations' => Location::with('area')->paginate(10),
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
    public function update(Menu $menu, Post $post, Request $request)
    {
        $this->validate($request, [
            'title_id' => 'required',
            'is_published' => 'required',
            'cover' => 'image|file|max:300',
            'thumbnail' => 'image|file|max:300',
            'template' => 'required',
        ]);

        if ($request->hasFile('cover')) {
            removeFile($post->cover);
            $file = $request->file('cover');
            $coverImage = $file->move('files/post/cover', generateFileName($request->title_id, $file));
        }

        if ($request->hasFile('thumbnail')) {
            removeFile($post->thumbnail);
            $file = $request->file('thumbnail');
            $thumbnailImage = $file->move('files/post/thumbnail', generateFileName($request->title_id, $file));
        }

        $post->menu_id = $menu->id;
        $post->cover = !empty($coverImage) ? $coverImage : $post->cover;
        $post->thumbnail = !empty($thumbnailImage) ? $thumbnailImage : $post->thumbnail;
        $post->is_published = $request->is_published;
        $post->is_running_text = $request->has('is_running_text') ? 1 : 0;
        $post->is_featured_product = $request->has('is_featured_product') ? 1 : 0;
        $post->template = $request->template;

        foreach (['id', 'en'] as $locale) {
            $oldTitle = $post->translate($locale)->title;
            $post->translateOrNew($locale)->title = $request->{"title_{$locale}"} ?? $request->title_id;
            $post->translateOrNew($locale)->description = $request->{"description_{$locale}"} ?? $request->description_id;
        }

        $post->save();

        if ($request->hasFile('files')) {
            $title = $request->title_files;
            $is_downloadable = $request->is_downloadable;
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                $insertFile = File::create([
                    'post_id' => $post->id,
                    'title' => $title[$key],
                    'file' => $file->move('files/post/files/', generateFileName($title[$key], $file)),
                    'is_downloadable' => isset($is_downloadable[$key]) ? 1 : 0
                ]);
                $insertFile->update([
                    'order' => $insertFile->id
                ]);
            }
        }

        if ($menu->parent_id == 0) {
            $redirect = route('cp.menus.show', $menu->id);
        } else {
            $redirect = route('cp.menus.submenus.show', [$menu->parent_id, $menu->id]);
        }
        return redirect($redirect)
            ->with('success', 'Post updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu, Post $post)
    {
        if ($menu->parent_id == 0) {
            $redirect = route('cp.menus.show', $menu->id);
        } else {
            $redirect = route('cp.menus.submenus.show', [$menu->parent_id, $menu->id]);
        }
        $post->delete();
        $state = 'success';
        $message = 'Post deleted.';

        return redirect($redirect)
            ->with($state, $message);
    }
}
