<?php
namespace App\Http\Controllers;

use App\Http\Requests\UpdateVideoRequest;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $videos = $request->user()->videos()->latestFirst()->paginate(10);

        return view('videos.index', [
            'videos' => $videos
        ]);
    }

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
        ]);

        return response()->json([
            'data' => [
                'uid' => $uid
            ]
        ]);
    }

    /**
     * Show the form to edit a video.
     */
    public function edit(Video $video)
    {
        $this->authorize('update', $video);

        return view('videos.edit', [
            'video' => $video
        ]);
    }

    /**
     * Update an existing video.
     */
    public function update(UpdateVideoRequest $request, Video $video)
    {
        $this->authorize('update', $video);

        $attributes = $request->validated();

        $video->fill([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'visibility' => $request->get('visibility'),
            'allow_votes' => $request->has('allow_votes'),
            'allow_comments' => $request->has('allow_comments'),
        ])->save();

        if ($request->ajax()) {
            return response()->json(null, 200);
        }

        return redirect()->back();
    }

    public function delete(Video $video)
    {
        $this->authorize('update', $video);

        $video->delete();

        return redirect()->back();
    }
}
