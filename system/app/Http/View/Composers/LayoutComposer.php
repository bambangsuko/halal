<?php

namespace App\Http\View\Composers;

use App\SocialMedia;
use App\Setting;
use App\Menu;
use Illuminate\View\View;

class LayoutComposer
{

    public function compose(View $view)
    {
        $view->with([
            'social_media' => SocialMedia::all(),
            'setting' => Setting::pluck('value', 'key'),
            'mainmenus' => Menu::where('parent_id', 0)
                ->isMainMenu()
                ->isActive()
                ->order()
                ->get(),
            'sidemenus' => Menu::where('parent_id', 0)
                ->isSecondaryMenu()
                ->isActive()
                ->order()
                ->get(),
            'submenus' => Menu::where('parent_id', '!=', 0) // Adjust the condition based on your data structure
                ->isActive()
                ->order()
                ->get(),
        ]);
    }
}
