<?php
namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Video extends Model
{
    use HasFactory, SoftDeletes, Searchable, Orderable;

    /**
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'videos_index';
    }

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

    /**
     * The views that belong to this video.
     */
    public function views()
    {
        return $this->hasMany(VideoView::class, 'video_id', 'id');
    }

    /**
     * Grab the view count.
     */
    public function viewCount()
    {
        return $this->views->count();
    }

    /**
     * The votes this video has.
     */
    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    /**
     * Upvotes for a video.
     */
    public function upVotes()
    {
        return $this->votes()->where('type', 'up');
    }

    /**
     * Downvotes for a video.
     */
    public function downVotes()
    {
        return $this->votes()->where('type', 'down');
    }

    /**
     * Retrieve votes from a specific user.
     */
    public function voteFromUser(User $user)
    {
        return $this->votes()->where('user_id', $user->id);
    }

    /**
     * The top level comments this video has.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('reply_id');
    }

    /**
     * Helper function to determine if a video is processed.
     */
    public function isProcessed()
    {
        return $this->is_processed ? true : false;
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

    /**
     * Is this video private?
     */
    public function isPrivate()
    {
        return $this->visibility === 'private';
    }

    public function ownedByUser(User $user)
    {
        return $this->channel->user->id === $user->id;
    }

    /**
     * Determine whether a given user can access a video.
     */
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

    public function getStreamUrl()
    {
        return Storage::disk('s3drop')->url($this->uid . '.mp4');
    }
}
