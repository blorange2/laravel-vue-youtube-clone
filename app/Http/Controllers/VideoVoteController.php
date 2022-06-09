<?php
namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoVoteController extends Controller
{
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
