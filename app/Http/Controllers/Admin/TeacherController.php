<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $teachers = Teacher::with(['user', 'department'])->latest()->paginate(10);

        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $departments = Department::where('status', 'active')->orderBy('name')->get();

        return view('admin.teachers.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'department_id' => ['required', 'exists:departments,id'],
            'gender' => ['required', 'in:Male,Female'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'hire_date' => ['required', 'date'],
        ]);

        $department = Department::findOrFail($validated['department_id']);
        $hireYear = (int) date('Y', strtotime($validated['hire_date']));

        DB::transaction(function () use ($validated, $department, $hireYear) {
            $teacherRole = Role::where('name', 'teacher')->firstOrFail();

            $temporaryPassword = Str::password(10);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($temporaryPassword),
                'role_id' => $teacherRole->id,
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'department_id' => $validated['department_id'],
                'employee_id' => Teacher::generateEmployeeId($department, $hireYear),
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'qualification' => $validated['qualification'] ?? null,
                'specialization' => $validated['specialization'] ?? null,
                'hire_date' => $validated['hire_date'],
                'status' => 'active',
            ]);

            session()->flash('temporary_password', $temporaryPassword);
            session()->flash('teacher_email', $user->email);
        });

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher created successfully. Share the temporary password shown below with the teacher securely.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher): View
    {
        $teacher->load('user', 'department');
        $departments = Department::where('status', 'active')->orderBy('name')->get();

        return view('admin.teachers.edit', compact('teacher', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $teacher->user_id],
            'department_id' => ['required', 'exists:departments,id'],
            'gender' => ['required', 'in:Male,Female'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'hire_date' => ['required', 'date'],
            'status' => ['required', 'in:active,on_leave,terminated'],
        ]);

        DB::transaction(function () use ($validated, $teacher) {
            $teacher->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'status' => $validated['status'] === 'active' ? 'active' : 'inactive',
            ]);

            $teacher->update([
                'department_id' => $validated['department_id'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'qualification' => $validated['qualification'] ?? null,
                'specialization' => $validated['specialization'] ?? null,
                'hire_date' => $validated['hire_date'],
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher): RedirectResponse
    {
        $teacher->user->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}
