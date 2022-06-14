<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateVoteRequest;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoVoteController extends Controller
{
    /**
     * Store a new vote against a video.
     * Note that tis also deletes previously set votes.
     */
    public function store(CreateVoteRequest $request, Video $video)
    {
        $this->authorize('vote', $video);

        $video->voteFromUser(auth()->user())->delete();

        $video->votes()->create([
            'type' => $request->get('type'),
            'user_id' => $request->user()->id
        ]);

        return response()->json(null, 200);
    }

    /**
     * Remove a vote against a video.
     */
    public function destroy(Request $request, Video $video)
    {
        $this->authorize('vote', $video);

        $video->voteFromUser(auth()->user())->delete();

        return response()->json(null, 200);
    }

    /**
     * Display votes cast for a given video.
     * Sets some sensible defaults and then builds a response.
     */
    public function show(Request $request, Video $video)
    {
        $response = [
            'up' => null,
            'down' => null,
            'canVote' => $video->votesAllowed(),
            'userVote' => null,
        ];

        if ($video->votesAllowed()) {
            $response['up'] = $video->upVotes()->count();
            $response['down'] = $video->downVotes()->count();
        }

        if ($request->user()) {
            $voteFromUser = $video->voteFromUser($request->user())->first();
            $response['userVote'] = $voteFromUser ? $voteFromUser->type : null;
        }

        return response()->json([
            'data' => $response
        ], 200);
    }
}
