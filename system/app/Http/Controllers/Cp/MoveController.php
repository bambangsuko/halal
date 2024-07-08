<?php

namespace App\Http\Controllers\Cp;

use App\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MoveController extends Controller
{

    public function menu(Request $request) {
        $currentMenu = Menu::findOrFail($request->id);
        $currentMenuOrder = $currentMenu->order;
        if ($request->type == 'up') {
            $previousMenu = $currentMenu->previous($currentMenu->type);
            $currentMenu->update([
                'order' => $previousMenu->order
            ]);
            $previousMenu->update([
                'order' => $currentMenuOrder
            ]);
        }

        if ($request->type == 'down') {
            $nextMenu = $currentMenu->next($currentMenu->type);
            $currentMenu->update([
                'order' => $nextMenu->order
            ]);
            $nextMenu->update([
                'order' => $currentMenuOrder
            ]);
        }

        return response()->json([
                    'status' => 'Success'
        ]);
    }

    public function submenu(Request $request) {
        $currentMenu = Menu::findOrFail($request->id);
        $currentMenuOrder = $currentMenu->order;
        if ($request->type == 'up') {
            $previousMenu = $currentMenu->previoussub();
            $currentMenu->update([
                'order' => $previousMenu->order
            ]);
            $previousMenu->update([
                'order' => $currentMenuOrder
            ]);
        }

        if ($request->type == 'down') {
            $nextMenu = $currentMenu->nextsub();
            $currentMenu->update([
                'order' => $nextMenu->order
            ]);
            $nextMenu->update([
                'order' => $currentMenuOrder
            ]);
        }

        return response()->json([
                    'status' => 'Success'
        ]);
    }
}
