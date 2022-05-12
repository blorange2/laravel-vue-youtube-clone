<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uid',
        'title',
        'description',
        'is_processed',
        'encoding_service_video_id',
        'video_filename',
        'visibility',
        'allow_votes',
        'allow_comments',
        'processed_percentage'
    ];

    protected $appends = [
        'url'
    ];

    /**
     * The key name to use with route model binding.
     */
    public function getRouteKeyName()
    {
        return 'uid';
    }

    /**
     * A video belongs to a channel via channel_id.
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }

    public function getUrlAttribute()
    {
        return !is_null($this->uid)
            ? 'https://google.co.uk'
            : null;
    }

    /**
     * Helper function to determine if a video is processed.
     */
    public function isProcessed()
    {
        return $this->processed;
    }

    /**
     * Getter for processed percentage.
     */
    public function processedPercentage()
    {
        return $this->processed_percentage;
    }

    /**
     * Retrieve the video thumbnail.
     */
    public function getThumbnail()
    {
        if (!$this->isProcessed()) {
            return 'http://placekitten.com/200/120';
        }

        return 'http://placekitten.com/200/300';
    }

    /**
     * Are votes allowed.
     */
    public function votesAllowed()
    {
        return $this->allow_votes ? true : false;
    }

    /**
     * Are comments allowed.
     */
    public function commentsAllowed()
    {
        return $this->allow_comments ? true : false;
    }

    public function isPrivate()
    {
        return $this->visibility === 'private';
    }

    public function ownedByUser(User $user)
    {
        return $this->channel->user->id === $user->id;
    }

    public function canBeAccessed(User $user = null)
    {
        if (!$user && $this->isPrivate()) {
            return false;
        }

        if ($user && $this->isPrivate() && ($user->id !== $this->channel->user->id)) {
            return false;
        }

        return true;
    }

    /**
     * Scope to order by newest first.
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
