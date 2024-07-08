<?php

namespace App\Jobs;

use App;
use App\PostTranslation;
use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class GenerateSitemapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // $site = App::make('sitemap');

        // $site->add(URL::to('/'), date("Y-m-d h:i:s"), 1, 'daily');

        // $post = PostTranslation::all();
        // foreach ($post as $key => $pt) {
        //     $site->add(URL::to($pt->slug), 1, 'daily');
        // }

        $site = App::make('sitemap');
        $site->add(URL::to('/'), date("Y-m-d h:i:s"), 1, 'daily');
        $posts = Post::with('translations')->get();
        foreach ($posts as $post) {
            foreach ($post->translations as $translation) {
                $site->add(
                    URL::to($translation->slug),
                    $post->updated_at->format('Y-m-d h:i:s'),
                    0.8,
                    'daily'
                );
            }
        }
        $site->store('xml', 'sitemap');
    }
}
