<?php
namespace App\Jobs;

use App\Models\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $channel;

    public $fileId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Channel $channel, $fileId)
    {
        $this->channel = $channel;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Setup default variables
        $path = storage_path() . '/uploads/' . $this->fileId;
        $fileName = $this->fileId . '.png';

        // Resize image
        Image::make($path)->encode('png')->fit(40, 40, function ($constraint) {
            $constraint->upsize();
        })->save();

        // Upload image to s3
        if (Storage::disk('s3')->put('profile/' . $fileName, fopen($path, 'r+'))) {
            File::delete($path);
        }

        $this->channel->image_filename = $fileName;

        $this->channel->save();
    }
}
