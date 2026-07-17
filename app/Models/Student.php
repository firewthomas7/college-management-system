<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'program_id',
        'student_id_number',
        'gender',
        'date_of_birth',
        'phone',
        'address',
        'admission_date',
        'current_year_level',
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
            'admission_date' => 'date',
        ];
    }

    /**
     * Get the user account linked to this student.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the program this student is enrolled in.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Generate the next unique student ID number for a given program's department and year.
     *
     * Format: WSPTC-{DEPT_CODE}-{YEAR}-{SEQUENCE}
     * Example: WSPTC-CS-2026-0001
     */
    public static function generateStudentIdNumber(Program $program, int $year): string
    {
        $deptCode = $program->department->code;

        $count = static::whereYear('admission_date', $year)
            ->whereHas('program', function ($query) use ($program) {
                $query->where('department_id', $program->department_id);
            })
            ->count();

        $sequence = str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);

        return "WSPTC-{$deptCode}-{$year}-{$sequence}";
    }
}
