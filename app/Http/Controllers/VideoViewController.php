<?php
namespace App\Http\Controllers;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VideoViewController extends Controller
{
    const BUFFER = 30;

    /**
     * Store a new video view.
     */
    public function store(Request $request, Video $video)
    {
        if (!$video->canBeAccessed($request->user())) {
            return;
        }

        if ($request->user()) {
            $lastUserView = $video->views()->latestByUser($request->user())->first();

            if ($this->withinBuffer($lastUserView)) {
                return;
            }
        }

        $lastIpView = $video->views()->latestByIp($request->ip())->first();

        if ($this->withinBuffer($lastIpView)) {
            return;
        }

        $video->views()->create([
            'user_id' => $request->user() ? $request->user()->id : null,
            'ip' => $request->ip()
        ]);

        return response()->json(null, 200);
    }

    /**
     * Determine whether a view is within a given buffer.
     */
    protected function withinBuffer($view)
    {
        return $view && $view->created_at->diffInSeconds(Carbon::now()) < self::BUFFER;
    }
}
