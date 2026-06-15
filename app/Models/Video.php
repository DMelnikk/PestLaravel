<?php

namespace App\Models;

use Database\Factories\VideoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    /** @use HasFactory<VideoFactory> */
    use HasFactory;

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function getReadableDuration(): string
    {
        return "{$this->duration_in_min}min";
    }

    public function alreadyWatchedByCurrentUser(): bool
    {
        return (bool) auth()->user()->watchedVideos()->where('video_id', $this->id)->exists();
    }
}
