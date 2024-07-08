<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            [
                'layouts.base',
                'layouts.cp',
                'layouts.auth',
                'auth.login',
                'index',
                'submenu.show',
                'post.show',
                'pages.show',
                'components.meta',
                'program-pensiun.index',
            ],
            'App\Http\View\Composers\LayoutComposer'
        );
        view()->composer(
            [
                'layouts.cp'
            ],
            'App\Http\View\Composers\CpLayoutComposer'
        );
        view()->composer(
            [
                'templates.location.index',
                'program-pensiun.index',
            ],
            'App\Http\View\Composers\LocationComposer'
        );
    }
}
