<?php
// app/Models/SavedEmail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SavedEmail extends Model
{
    protected $fillable = [
        'email_address',
        'access_token',
        'expires_at',
        'email_count',
        'status'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    // Generate unique access token
    public static function generateToken()
    {
        do {
            $token = Str::random(32);
        } while (self::where('access_token', $token)->exists());
        
        return $token;
    }

    // Check if saved email is expired
    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    // Get access URL
    public function getAccessUrlAttribute()
    {
        return config('app.url') . '/saved/' . $this->access_token;
    }
}
