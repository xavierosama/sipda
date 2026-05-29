<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetingNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'department_id',
        'member_id',
        'title',
        'meeting_at',
        'location',
        'agenda',
        'content',
        'conclusion',
    ];

    protected $casts = [
        'meeting_at' => 'datetime',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
