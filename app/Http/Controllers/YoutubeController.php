<?php

namespace App\Http\Controllers;

use DevsWebDev\DevTube\Download;
use Illuminate\Http\Request;

class YoutubeController extends Controller
{
    public function download()
    {
        exec("rm /home/youtubex/public_html/public/music/* -rf && rm /home/youtubex/public_html/public/*.webm -rf");
        $videoId = request()->query('v');
        exec("/usr/local/bin/youtube-dl -o '%(artist)s|-|%(track)s|-|%(title)s.webm' -f bestaudio '$videoId' 2>&1",$downloading_video);
//        dd($downloading_video);
        $savedName = str_replace('[download] Destination: ','',$downloading_video[2]);
        $nameData = str_replace('.webm','',$savedName);
        $nameData = explode('|-|',$nameData);
        $fileName = $nameData[1] !== 'NA' ? "$nameData[0] - $nameData[1].mp3" : "$nameData[2].mp3";
        exec("/usr/local/bin/ffmpeg -i /home/youtubex/public_html/public/'$savedName' -b:a 320K -vn /home/youtubex/public_html/public/music/'$fileName' 2>&1",$converting_to_audio);
        exec("rm /home/youtubex/public_html/public/'$savedName' -f 2>&1", $deleting_video);

//        dd($downloading_video,$converting_to_audio);
        return response()->download(public_path("music/$fileName"),$fileName);
    }
}
