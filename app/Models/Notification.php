<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
        'related_id',
        'related_type',
        'read_at',
    ];

    // Relationship to User.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scope to get user notifications.
    public function scopeGetUserNotifications($query, $userId)
    {
        return $query->where('user_id', $userId)->orderBy('created_at', 'desc')->take(10);
    }

    // Mark the notification as read.
    public function markAsRead()
    {
        $this->update(['is_read' => true, 'read_at' => now()]);
    }
}
