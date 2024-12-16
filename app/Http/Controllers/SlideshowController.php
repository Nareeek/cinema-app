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
        $imageFiles = File::files(public_path('posters'));
        $images = [];

        foreach ($imageFiles as $file) {
            $images[] = '/posters/' . $file->getFilename(); // Include file path
        }

        return response()->json($images);
    }
}
