<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $students = Student::with(['user', 'program.department'])->latest()->paginate(10);

        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $programs = Program::with('department')->where('status', 'active')->orderBy('name')->get();

        return view('admin.students.create', compact('programs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'program_id' => ['required', 'exists:programs,id'],
            'gender' => ['required', 'in:Male,Female'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'admission_date' => ['required', 'date'],
            'current_year_level' => ['required', 'integer', 'min:1', 'max:7'],
        ]);

        $program = Program::with('department')->findOrFail($validated['program_id']);
        $admissionYear = (int) date('Y', strtotime($validated['admission_date']));

        DB::transaction(function () use ($validated, $program, $admissionYear) {
            $studentRole = Role::where('name', 'student')->firstOrFail();

            $temporaryPassword = Str::password(10);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($temporaryPassword),
                'role_id' => $studentRole->id,
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            Student::create([
                'user_id' => $user->id,
                'program_id' => $validated['program_id'],
                'student_id_number' => Student::generateStudentIdNumber($program, $admissionYear),
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'admission_date' => $validated['admission_date'],
                'current_year_level' => $validated['current_year_level'],
                'status' => 'active',
            ]);

            session()->flash('temporary_password', $temporaryPassword);
            session()->flash('student_email', $user->email);
        });

        return redirect()->route('admin.students.index')
            ->with('success', 'Student created successfully. Share the temporary password shown below with the student securely.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {
        $student->load('user', 'program');
        $programs = Program::with('department')->where('status', 'active')->orderBy('name')->get();

        return view('admin.students.edit', compact('student', 'programs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $student->user_id],
            'program_id' => ['required', 'exists:programs,id'],
            'gender' => ['required', 'in:Male,Female'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'admission_date' => ['required', 'date'],
            'current_year_level' => ['required', 'integer', 'min:1', 'max:7'],
            'status' => ['required', 'in:active,graduated,suspended,withdrawn'],
        ]);

        DB::transaction(function () use ($validated, $student) {
            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'status' => $validated['status'] === 'active' ? 'active' : 'inactive',
            ]);

            $student->update([
                'program_id' => $validated['program_id'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'admission_date' => $validated['admission_date'],
                'current_year_level' => $validated['current_year_level'],
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->user->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }
}
