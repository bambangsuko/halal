<?php

namespace App\Http\Controllers\Cp;

use App\Post;
use App\Slider;
use File;
use App\Http\Controllers\Controller;

class PostController extends Controller
{

    public function toSlider($id)
    {
        $post = Post::findOrFail($id);
        if ($post->cover) {
            $image_name = explode('/', $post->cover)[3];
            $image = 'files/slider/' . $image_name;
            File::copy(public_path($post->cover), public_path($image));
        }
        $slider = Slider::create([
            'image' => isset($image) ? $image : '',
            'caption' => $post->title,
            'link' => generateUrl($post->slug)
        ]);
        $slider->update([
            'order' => $slider->id
        ]);
        return redirect(route('cp.sliders.edit', $slider))
            ->with('success', 'Slider added.');
    }
}
