<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'member_id',
        'activity_id',
        'created_by',
        'letter_number',
        'type',
        'letter_type',
        'subject',
        'category',
        'sender',
        'recipient',
        'letter_date',
        'received_date',
        'received_or_sent_date',
        'file_path',
        'status',
        'notes',
        'description',
    ];

    protected $casts = [
        'letter_date' => 'date',
        'received_date' => 'date',
        'received_or_sent_date' => 'date',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
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
