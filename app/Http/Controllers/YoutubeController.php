<?php

namespace App\Http\Controllers;

use DevsWebDev\DevTube\Download;
use Illuminate\Http\Request;

class YoutubeController extends Controller
{
    public function download()
    {
        $url = request()->query('url');
        $dl = new Download($url, $format = "mp3", $download_path = "music" );

        //Saves the file to specified directory
        $media_info = $dl->download();
        dd($media_info);
        $media_info = $media_info->first();

        // Return as a download
        return response()->download($media_info['file']->getPathname());

    }
}
