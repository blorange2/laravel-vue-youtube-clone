<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateVideoCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Video;

class VideoCommentController extends Controller
{
    /**
     * Return a listing of comments for a given video
     */
    public function index(Video $video)
    {
        return new CommentCollection($video->comments()->get());
    }

    /**
     * Create a new comment on a video.
     */
    public function store(CreateVideoCommentRequest $request, Video $video)
    {
        $this->authorize('comment', $video);

        $comment = $video->comments()->create([
            'body' => $request->get('body'),
            'reply_id' => $request->get('reply_id', null),
            'user_id' => $request->user()->id
        ]);

        return new CommentResource($comment);
    }

    /**
     * Delete an existing comment on a video.
     */
    public function delete(Video $video, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json(null, 200);
    }
}
