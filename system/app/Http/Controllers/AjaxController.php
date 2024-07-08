<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{

    public function datatable(Request $request)
    {
        $string = file_get_contents(asset($request->file));
        $array = array_map("str_getcsv", explode("\n", $string));
        // $array = array_map("str_getcsv", explode(PHP_EOL, $string));
        $titles = $array[0];
        // unset($array[1]);
        $json = json_encode($array);
        // dd($request->file);
        $returnHTML = view('ajax.datatable', [
            'titles' => $titles,
            'json' => $json,
            'id' => $request->id
        ])->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }
}
