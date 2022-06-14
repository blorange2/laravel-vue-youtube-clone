<?php
namespace App\Traits;

trait Orderable
{
    /**
     * Scope to order by newest first.
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
