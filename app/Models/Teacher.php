<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'department_id',
        'employee_id',
        'gender',
        'date_of_birth',
        'phone',
        'address',
        'qualification',
        'specialization',
        'hire_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'hire_date' => 'date',
        ];
    }

    /**
     * Get the user account linked to this teacher.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department this teacher belongs to.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Generate the next unique employee ID for a given department and hire year.
     *
     * Format: WSPTC-EMP-{DEPT_CODE}-{YEAR}-{SEQUENCE}
     * Example: WSPTC-EMP-CS-2026-0001
     */
    public static function generateEmployeeId(Department $department, int $year): string
    {
        $count = static::whereYear('hire_date', $year)
            ->where('department_id', $department->id)
            ->count();

        $sequence = str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);

        return "WSPTC-EMP-{$department->code}-{$year}-{$sequence}";
    }
}
