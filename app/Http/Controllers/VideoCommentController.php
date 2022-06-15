<?php
namespace App\Http\Controllers;

use App\Http\Resources\CommentCollection;
use App\Models\Video;

class VideoCommentController extends Controller
{
    public function index(Video $video)
    {
        return new CommentCollection($video->comments()->get());
    }
}
