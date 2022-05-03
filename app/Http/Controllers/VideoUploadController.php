<?php
namespace App\Http\Controllers;

use App\Jobs\UploadVideo;
use Illuminate\Http\Request;

class VideoUploadController extends Controller
{
    /**
     * Display the video uploaad page.
     */
    public function index()
    {
        return view('videos.upload');
    }

    /**
     * Store an uploaded video.
     */
    public function store(Request $request)
    {
        $channel = $request->user()->channels()->first();

        $video = $channel->videos()->where('uid', $request->get('uid'))->firstOrFail();

        $request->file('video')->move(storage_path() . '/uploads', $video->video_filename);

        $this->dispatch(new UploadVideo(
            $video->video_filename
        ));

        return response()->json(null, 200);
    }
}
