<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The channels this user has via user_id in channels
     * SELECT * FROM channels WHERE user_id = ?
     */
    public function channels()
    {
        return $this->hasMany(Channel::class, 'user_id', 'id');
    }

    /**
     * The videos a user owns through their channels.
     */
    public function videos()
    {
        return $this->hasManyThrough(Video::class, Channel::class);
    }

    /**
     * The subscriptions a user has.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id', 'id');
    }

    public function subscribedChannels()
    {
        return $this->belongsToMany(Channel::class, 'subscriptions');
    }

    public function isSubscribedTo(Channel $channel)
    {
        return (bool) $this->subscriptions->where('channel_id', $channel->id)->count();
    }
}
