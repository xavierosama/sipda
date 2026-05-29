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
        'letter_number',
        'type',
        'subject',
        'sender',
        'recipient',
        'letter_date',
        'received_date',
        'file_path',
        'description',
    ];

    protected $casts = [
        'letter_date' => 'date',
        'received_date' => 'date',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
