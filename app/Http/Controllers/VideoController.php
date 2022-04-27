<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Store a new video in the database.
     */
    public function store(Request $request)
    {
        $uid = uniqid(true);

        $channel = $request->user()->channels()->first();

        $video = $channel->videos()->create([
            'uid' => $uid,
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'visibility' => $request->get('visibility'),
            'video_filename' => "{$uid}.{$request->get('extension')}",
            'title' => $request->get('title'),
        ]);

        return response()->json([
            'data' => [
                'uid' => $uid
            ]
        ]);
    }
}
