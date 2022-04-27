<?php
namespace App\Http\Controllers;

class VideoUploadController extends Controller
{
    public function index()
    {
        return view('videos.upload');
    }
}
