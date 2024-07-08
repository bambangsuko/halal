<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller {

    public function search(Request $request) {
        $id = ($request->id == '*') ? null : $request->id;
        $locations = Location::with('area')
                ->when($id, function ($query, $id) {
                    return $query->where('area_id', $id);
                })
                ->get();
        return response()->json(view('templates.location.table', [
                            'locations' => $locations
                        ])->render());
    }

}
