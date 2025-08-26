<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FakeEmail;

// app/Http/Controllers/FakeEmailController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FakeEmail;

class FakeEmailController extends Controller
{

    public function index(Request $request)
{
    $email = $request->query('email');

    if ($email) {
        return FakeEmail::where('to_email', 'LIKE', "%$email%")->get();
    }

    return FakeEmail::all();
}

public function store(Request $r)
{
    $data = $r->validate([
        'from_email' => 'nullable|string',
        'to_email'   => 'nullable|string',
        'subject'    => 'nullable|string',
        'body_text'  => 'nullable|string',
        'body_html'  => 'nullable|string',
        'bucket'     => 'nullable|string',
        'object_key' => 'nullable|string',
    ]);

    return FakeEmail::create($data);
}

public function getTotalCount(Request $request)
{
    $date = $request->query('date') ? $request->query('date') : today();
    
    $count = FakeEmail::whereDate('created_at', $date)->count();
    
    return response()->json([
        'count' => $count,
        'date' => is_string($date) ? $date : $date->format('Y-m-d')
    ]);
}

}
