<?php

namespace App\Repositories;

use App\Menu;

class MenuRepository {

    public function getMainMenu() {
        // $menus = Menu::with([
        //             'submenu',
        //             'posts',
        //             'submenu.submenu',
        //             'submenu.posts',
        //             'submenu.submenu.submenu',
        //             'submenu.submenu.posts',
        //             'submenu.submenu.submenu.submenu',
        //             'submenu.submenu.submenu.posts',
        //         ])
        //         ->isActive()
        //         ->where('id', '<', 5)
        //         ->get();
        // return $menus;
    }

    function buildTree(array $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

}
