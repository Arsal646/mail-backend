<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FakeEmail extends Model
{
   protected $fillable = [
    'from_email','to_email','subject',
    'body_text','body_html','bucket','object_key'
];

}

