<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',   // receiver
        'type',      // 'like', 'comment', etc.
        'data',      // JSON payload
        'read',
    ];

    protected $casts = [
        'data' => 'array',   // uses $notification->data as an array
        'read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // receiver
    }
}