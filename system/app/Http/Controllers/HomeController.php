<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Post;
use App\Setting;
use App\Slider;
use App\ExternalApp;

class HomeController extends Controller
{

        public function index()
        {
                $wp_posts = [];
                $is_wp_posts_on = Setting::select('value')
                        ->where('key', 'wp_posts')
                        ->first();
                if ($is_wp_posts_on->value == 1) {
                        $urls = [
                                'fit' => 'https://fit.iain-surakarta.ac.id/',
                                'fud' => 'https://fud.iain-surakarta.ac.id/',
                                'syariah' => 'https://syariah.iain-surakarta.ac.id/',
                                'febi' => 'https://febi.iain-surakarta.ac.id/',
                                'fab' => 'https://fab.iain-surakarta.ac.id/',
                                'pascasarjana' => 'https://pascasarjana.iain-surakarta.ac.id/',
                        ];
                        foreach ($urls as $key => $url) {
                                $categories = getJson($url . 'wp-json/wp/v2/categories');
                                if ($categories) {
                                        $id_category = getIdCategory($categories, 'kegiatan-terbaru');
                                        if ($id_category) {
                                                $posts = getJson($url . 'wp-json/wp/v2/posts?per_page=2&categories=' . $id_category);
                                                // dd(explode('/',$posts[0]->link)[2]);
                                                // dd(getJson($url.'wp-json/wp/v2/media/'.$posts[0]->featured_media)->source_url);
                                                // array_push($wp_posts, $posts);
                                                $wp_posts += [
                                                        $key => $posts
                                                ];
                                        }
                                }
                        }
                }
                // dd($wp_posts);
                // $userIp = $request->ip();
                // $locationData = Location::get($userIp);

                // dd($locationData);
                return view('index', [
                        'latestnews' => Post::where('menu_id', 1)
                                ->isActive()
                                ->orderBy('created_at', 'DESC')
                                ->take(4)
                                ->get(),
                        'onhomemenus' => Menu::isActive()
                                ->isOnHomepage()
                                ->with([
                                        'posts' => function ($query) {
                                                $query->isActive()
                                                        ->get();
                                        },
                                        'submenus' => function ($query) {
                                                $query->isActive()
                                                        ->get();
                                        }
                                ])
                                ->get(),
                        'homemenus' => Menu::where('parent_id', 0)
                                ->isHomepageMenu()
                                ->isActive()
                                ->order()
                                ->with(['posts' => function ($query) {
                                        $query->isActive()
                                                ->orderBy('created_at', 'DESC')
                                                ->take(6)
                                                ->get();
                                }])
                                ->get(),
                        'education' => [],
                        'faculties' => [],
                        'external_apps' => ExternalApp::get(),
                        'wp_posts' => $wp_posts,
                        'pinned_posts' => Post::isActive()
                                ->isPinned()
                                ->get(),
                        'sliders' => Slider::order()->get()
                ]);
        }
}
