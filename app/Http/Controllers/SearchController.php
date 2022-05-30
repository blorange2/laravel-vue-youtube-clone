<?php
namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if (!$request->get('q')) {
            return redirect('/');
        }

        $channels = Channel::search($request->get('q'))->take(3)->get();
        $videos = Video::search($request->get('q'))->take(3)->get();

        return view('search.index', [
            'channels' => $channels,
            'videos' => $videos
        ]);
    }
}
