<?php

namespace App\Http\Controllers;

use App\Slider;
use App\Post;
use App\Menu;
use App\File;
use App\Repositories\BreadcrumbRepository;
use App\Repositories\CoverRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{

    private $breadcrumbRepository;
    private $coverRepository;

    function __construct(BreadcrumbRepository $breadcrumbRepository, CoverRepository $coverRepository)
    {
        $this->breadcrumbRepository = $breadcrumbRepository;
        $this->coverRepository = $coverRepository;
    }

    public function index()
    {
        return view('index', [
            'sliders' => Slider::order()->get(),
            'running_texts' => Post::isActive()->isRunningText()->get(),
            'footer_post' => Post::where('menu_id', 6)->take(2)->get()
        ]);
    }

    public function show($slug)
    {
        $post = Post::isActive()
            ->whereTranslation('slug', $slug)
            ->first();
        $menu = Menu::isActive()
            ->whereTranslation('slug', $slug)
            ->first();
        if ($post) {
            $downloadable_files = File::where('post_id', $post->id)
                ->isDownloadable()
                ->get();
            if ($post->external_link) {
                return redirect($post->external_link);
            }
            if ($post->template == 'templates.post.about') {
                $menu = Menu::isActive()
                    ->where('id', $post->menu->id)
                    ->with([
                        'posts' => function ($query) {
                            $query->isActive();
                        },
                        'submenus' => function ($query) {
                            $query->isActive();
                        },
                        'submenus.posts' => function ($query) {
                            $query->isActive();
                        }
                    ])
                    ->first();
            }
            return view($post->template, [
                'post' => $post,
                'downloadable_files' => $downloadable_files,
                'menu' => $menu,
                'breadcrumbs' => $this->breadcrumbRepository->generateByPostId($post->id),
                // 'sidebars' => Menu::with('posts')->findOrFail($post->menu->id),
                // 'cover' => $this->coverRepository->getByPostId($post->id)
            ]);
        } elseif ($menu) {
            $posts = Post::isActive()->where('menu_id', $menu->id)->latest()->paginate(9);
            if (count($posts) == 0) {
                $submenus = Menu::isActive()->where('parent_id', $menu->id)->with([
                    'posts' => function ($query) {
                        $query->isActive();
                    }
                ])->paginate(9);
            } else {
                $submenus = Menu::isActive()->where('parent_id', $menu->id)->with([
                    'posts' => function ($query) {
                        $query->isActive();
                    }
                ])->get();
            }
            return view($menu->template, [
                'menu' => $menu,
                'submenus' => $submenus,
                'posts' => $posts,
                'breadcrumbs' => $this->breadcrumbRepository->generateByMenuId($menu->id),
                // 'sidebars' => Menu::with('posts')->findOrFail($menu->id),
                // 'cover' => $this->coverRepository->getByMenuId($menu->id)
            ]);
        } else {
            abort(404);
        }
    }
}
