<?php

namespace App\Models;

use Database\Factories\WatchedVideoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchedVideo extends Model
{
    /** @use HasFactory<WatchedVideoFactory> */
    use HasFactory;
}
