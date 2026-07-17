<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'program_id',
        'name',
        'code',
        'credit_hours',
        'year_level',
        'semester_number',
        'description',
        'status',
    ];

    /**
     * Get the program this subject belongs to.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get all course offerings (teacher assignments) for this subject.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
