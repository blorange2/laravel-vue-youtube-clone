<?php
namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes, Orderable;

    protected $fillable = [
        'body',
        'user_id',
        'reply_id'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * The replies that relate to this comment.
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_id', 'id');
    }

    /**
     * The user who posted the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
