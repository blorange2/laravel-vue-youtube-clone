<?php
namespace App\Http\Controllers;

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
    }
}
