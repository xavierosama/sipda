<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
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

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
