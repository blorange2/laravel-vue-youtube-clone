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
}
