<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_filename'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The user who owns this channel through user_id in channel.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * The videos belonging to a channel via channel_id
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'channel_id', 'id');
    }

    /**
     * Retrieve the channel image that was uploaded to Amazon S3.
     */
    public function getImage()
    {
        if (!is_null($this->image_filename)) {
            return Storage::disk('s3')->url('profile/' . $this->image_filename);
        }

        return 'http://placekitten.com/200/300';
    }
}
