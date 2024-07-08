<?php

namespace App\Http\View\Composers;

use App\Menu;
use Illuminate\View\View;

class CpLayoutComposer {

    public function __construct() {
        
    }

    public function compose(View $view) {
        $view->with([
            'menu' => Menu::where('parent_id', 0)->get(),
        ]);
    }

}
