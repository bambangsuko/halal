<?php

namespace App\Http\Controllers\Cp;

use App\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller {

    public function update(Request $request) {
        $currentFile = File::findOrFail($request->id);
        $currentFileOrder = $currentFile->order;
        if ($request->type == 'up') {
            $previousFile = File::where('post_id', $currentFile->post_id)
                    ->where('order', '>', $currentFile->order)
                    ->orderBy('order', 'asc')
                    ->first();
            $currentFile->update([
                'order' => $previousFile->order
            ]);
            $previousFile->update([
                'order' => $currentFileOrder
            ]);
        }

        if ($request->type == 'down') {
            $nextFile = File::where('post_id', $currentFile->post_id)
                    ->where('order', '<', $currentFile->order)
                    ->orderBy('order', 'desc')
                    ->first();
            $currentFile->update([
                'order' => $nextFile->order
            ]);
            $nextFile->update([
                'order' => $currentFileOrder
            ]);
        }

        return response()->json([
                    'status' => 'Success'
        ]);
    }

    public function destroy(Request $request) {
        File::findOrFail($request->id)->delete();
        echo TRUE;
    }

    public function downloadable(Request $request){
        $file = File::findOrFail($request->id);
        $file->update([
            'is_downloadable' => $file->is_downloadable == 1 ? 0 : 1
        ]);
        return response()->json([
            'status' => 'Success'
        ]);
    }

}
