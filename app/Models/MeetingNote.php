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
        'created_by',
        'title',
        'meeting_date',
        'start_time',
        'end_time',
        'meeting_at',
        'location',
        'leader_id',
        'note_taker_id',
        'participants',
        'agenda',
        'content',
        'discussion',
        'decisions',
        'conclusion',
        'follow_up',
        'follow_up_pic_id',
        'follow_up_deadline',
        'follow_up_status',
        'archived_at',
    ];

    protected $casts = [
        'meeting_date' => 'date',
        'meeting_at' => 'datetime',
        'follow_up_deadline' => 'date',
        'archived_at' => 'datetime',
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

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'leader_id');
    }

    public function noteTaker(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'note_taker_id');
    }

    public function followUpPic(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'follow_up_pic_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
