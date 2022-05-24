<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip'
    ];

    public function scopeByUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeLatestByUser($query, User $user)
    {
        return $query->byUser($user)->orderBy('created_at', 'desc')->take(1);
    }

    public function scopeByIp($query, string $ip)
    {
        return $query->where('ip', $ip);
    }

    public function scopeLatestByIp($query, string $ip)
    {
        return $query->byIp($ip)->orderBy('created_at', 'desc')->take(1);
    }
}
