<?php

namespace App\Http\Controllers\Cp;

use App\Menu;
use App\Post;
use App\Template;
use App\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BreadcrumbRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use App\Jobs\GenerateSitemapJob;

class SecondaryMenuPostController extends Controller
{

    private $breadcrumbRepository;

    function __construct(BreadcrumbRepository $breadcrumbRepository)
    {
        $this->breadcrumbRepository = $breadcrumbRepository;
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            checkPermission($this->user, 'secondary-menus');
            return $next($request);
        });
    }

    public function create($menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        return view('cp.secondary-menu.post.create', [
            'menu' => $menu,
            'templates' => Template::post(),
            'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($menu->id)
        ]);
    }

    public function store(Request $request, $menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
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
        $post->is_published = $request->is_published;
        $post->template = $request->template;
        $post->external_link = $request->external_link;
        $post->created_at = $request->created_at;
        $post->is_pinned = isset($request->is_pinned) ? 1 : 0;

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
            $redirect = route('cp.secondary-menus.show', $menu->id);
        } else {
            $redirect = route('cp.secondary-menus.submenus.show', [$menu->parent_id, $menu->id]);
        }

        // Memulai pemrosesan antrian untuk menjalankan fungsi sitemap
        Bus::dispatch(new GenerateSitemapJob());


        return redirect($redirect)
            ->with('success', 'Post berhasil ditambahkan!');
    }

    public function show($menu_id, $post_id)
    {
        $menu = Menu::findOrFail($menu_id);
        $post = Post::where('id', $post_id)
            ->where('menu_id', $menu_id)
            ->firstOrFail();
        return view('cp.secondary-menu.post.show', [
            'menu' => $menu,
            'post' => $post,
            'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($menu->id)
        ]);
    }

    public function edit($menu_id, $post_id)
    {
        $menu = Menu::findOrFail($menu_id);
        $post = Post::where('id', $post_id)
            ->where('menu_id', $menu_id)
            ->firstOrFail();
        return view('cp.secondary-menu.post.edit', [
            'menu' => $menu,
            'post' => $post,
            'templates' => Template::post(),
            'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($menu->id)
        ]);
    }

    public function update($menu_id, $post_id, Request $request)
    {
        $menu = Menu::findOrFail($menu_id);
        $post = Post::where('id', $post_id)
            ->where('menu_id', $menu_id)
            ->firstOrFail();
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
        $post->is_published = $request->is_published;
        $post->template = $request->template;
        $post->external_link = $request->external_link;
        $post->created_at = $request->created_at;
        $post->is_pinned = isset($request->is_pinned) ? 1 : 0;

        foreach (['id', 'en', 'ar'] as $locale) {
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

        // if ($menu->parent_id == 0) {
        //     $redirect = route('cp.secondary-menus.show', $menu->id);
        // } else {
        $redirect = route('cp.secondary-menus.posts.show', [$menu, $post]);
        // }
        return redirect($redirect)
            ->with('success', 'Post berhasil diubah!');
    }

    public function destroy($menu_id, $post_id)
    {
        $menu = Menu::findOrFail($menu_id);
        $post = Post::where('id', $post_id)
            ->where('menu_id', $menu_id)
            ->firstOrFail();
        if ($menu->parent_id == 0) {
            $redirect = route('cp.secondary-menus.show', $menu->id);
        } else {
            $redirect = route('cp.secondary-menus.submenus.show', [$menu->parent_id, $menu->id]);
        }
        $post->delete();
        $state = 'success';
        $message = 'Post berhasil dihapus!';

        return redirect($redirect)
            ->with($state, $message);
    }
}
