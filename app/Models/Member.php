<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'position_id',
        'full_name',
        'name',
        'member_number',
        'nik',
        'email',
        'phone',
        'birth_place',
        'birth_date',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'address',
        'member_status',
        'status',
        'joined_at',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'date_of_birth' => 'date',
        'joined_at' => 'date',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function letters(): HasMany
    {
        return $this->hasMany(Letter::class);
    }

    public function meetingNotes(): HasMany
    {
        return $this->hasMany(MeetingNote::class);
    }

    public function cashTransactions(): HasMany
    {
        return $this->hasMany(CashTransaction::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
