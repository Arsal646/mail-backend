<?php
// app/Http/Controllers/SavedEmailController.php

namespace App\Http\Controllers;

use App\Models\SavedEmail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SavedEmailController extends Controller
{
    // Save email for 7-day access
    public function saveEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Check if email already saved and not expired
        $existing = SavedEmail::where('email_address', $request->email)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->first();

        if ($existing) {
            return response()->json([
                'success' => true,
                'message' => 'Email already saved',
                'data' => [
                    'access_token' => $existing->access_token,
                    'access_url' => $existing->access_url,
                    'expires_at' => $existing->expires_at->toISOString(),
                    'expires_at_formatted' => $existing->expires_at->format('l, F j, Y \a\t g:i A')
                ]
            ]);
        }

        // Create new saved email
        $savedEmail = SavedEmail::create([
            'email_address' => $request->email,
            'access_token' => SavedEmail::generateToken(),
            'expires_at' => now()->addDays(7),
            'email_count' => 0,
            'status' => 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Email saved successfully',
            'data' => [
                'access_token' => $savedEmail->access_token,
                'access_url' => $savedEmail->access_url,
                'expires_at' => $savedEmail->expires_at->toISOString(),
                'expires_at_formatted' => $savedEmail->expires_at->format('l, F j, Y \a\t g:i A')
            ]
        ]);
    }

    // Get saved email by token
    public function getSavedEmail($token)
    {
        $savedEmail = SavedEmail::where('access_token', $token)
            ->where('status', 'active')
            ->first();

        if (!$savedEmail) {
            return response()->json([
                'success' => false,
                'message' => 'Saved email not found'
            ], 404);
        }

        if ($savedEmail->isExpired()) {
            $savedEmail->update(['status' => 'expired']);
            return response()->json([
                'success' => false,
                'message' => 'Saved email has expired'
            ], 410);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'email_address' => $savedEmail->email_address,
                'expires_at' => $savedEmail->expires_at->toISOString(),
                'expires_at_formatted' => $savedEmail->expires_at->format('l, F j, Y \a\t g:i A'),
                'days_remaining' => $savedEmail->expires_at->diffInDays(now())
            ]
        ]);
    }

    // Check if email is saved
    public function checkSaved(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $savedEmail = SavedEmail::where('email_address', $request->email)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->first();

        return response()->json([
            'success' => true,
            'is_saved' => !!$savedEmail,
            'data' => $savedEmail ? [
                'access_token' => $savedEmail->access_token,
                'access_url' => $savedEmail->access_url,
                'expires_at' => $savedEmail->expires_at->toISOString()
            ] : null
        ]);
    }
}
