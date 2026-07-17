<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $courses = Course::with(['subject.program', 'teacher.user', 'semester.academicYear'])->latest()->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $subjects = Subject::with('program')->where('status', 'active')->orderBy('name')->get();
        $teachers = Teacher::with('user')->where('status', 'active')->get()->sortBy('user.name');
        $semesters = Semester::with('academicYear')->orderBy('start_date', 'desc')->get();

        return view('admin.courses.create', compact('subjects', 'teachers', 'semesters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'semester_id' => ['required', 'exists:semesters,id'],
            'section' => ['required', 'string', 'max:5'],
            'max_students' => ['required', 'integer', 'min:1', 'max:500'],
        ]);

        $exists = Course::where('subject_id', $validated['subject_id'])
            ->where('semester_id', $validated['semester_id'])
            ->where('section', $validated['section'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'section' => 'This subject already has a course offering for this semester and section.',
            ]);
        }

        $validated['status'] = 'active';

        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course offering created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): View
    {
        $subjects = Subject::with('program')->where('status', 'active')->orderBy('name')->get();
        $teachers = Teacher::with('user')->where('status', 'active')->get()->sortBy('user.name');
        $semesters = Semester::with('academicYear')->orderBy('start_date', 'desc')->get();

        return view('admin.courses.edit', compact('course', 'subjects', 'teachers', 'semesters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'semester_id' => ['required', 'exists:semesters,id'],
            'section' => ['required', 'string', 'max:5'],
            'max_students' => ['required', 'integer', 'min:1', 'max:500'],
            'status' => ['required', 'in:active,completed,cancelled'],
        ]);

        $exists = Course::where('subject_id', $validated['subject_id'])
            ->where('semester_id', $validated['semester_id'])
            ->where('section', $validated['section'])
            ->where('id', '!=', $course->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'section' => 'This subject already has a course offering for this semester and section.',
            ]);
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course offering updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course offering deleted successfully.');
    }
}
