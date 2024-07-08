<?php

namespace App\Http\Controllers\Cp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $uploadedFile = $file->move('files/upload', $file->getClientOriginalName());
        }

        return response()->json([
            'uploaded' => 1,
            'fileName' => $uploadedFile,
            'url' => asset($uploadedFile)
        ]);
    }
}
