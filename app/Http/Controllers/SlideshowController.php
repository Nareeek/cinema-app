<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class SlideshowController extends Controller
{
    /**
     * Fetch all images in the public/images folder
     */
    public function getSlideshowImages()
    {
        $imageFiles = File::files(public_path('images'));
        $images = [];

        foreach ($imageFiles as $file) {
            $images[] = '/images/' . $file->getFilename(); // Include file path
        }

        return response()->json($images);
    }
}
