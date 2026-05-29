<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'member_id',
        'attendance_date',
        'status',
        'checked_in_at',
        'notes',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'checked_in_at' => 'datetime:H:i',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
