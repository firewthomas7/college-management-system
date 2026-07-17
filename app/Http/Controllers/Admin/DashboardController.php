<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Program;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $stats = [
            'total_students' => Student::where('status', 'active')->count(),
            'total_teachers' => Teacher::where('status', 'active')->count(),
            'total_courses' => Program::where('status', 'active')->count(),
            'pending_admissions' => 0, // wired up once the Admissions module is built
        ];

        $recentStudents = Student::with(['user', 'program'])->latest()->take(5)->get();
        $recentTeachers = Teacher::with(['user', 'department'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentStudents', 'recentTeachers'));
    }
}
