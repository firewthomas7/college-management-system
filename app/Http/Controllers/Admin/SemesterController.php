<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $semesters = Semester::with('academicYear')->latest('start_date')->paginate(10);

        return view('admin.semesters.index', compact('semesters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->get();

        return view('admin.semesters.create', compact('academicYears'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'semester_number' => ['required', 'integer', 'in:1,2'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_current' => ['sometimes', 'boolean'],
        ]);

        $validated['is_current'] = $request->boolean('is_current');

        $exists = Semester::where('academic_year_id', $validated['academic_year_id'])
            ->where('semester_number', $validated['semester_number'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'semester_number' => 'This semester already exists for the selected academic year.',
            ]);
        }

        DB::transaction(function () use ($validated) {
            if ($validated['is_current']) {
                Semester::where('is_current', true)->update(['is_current' => false]);
            }

            Semester::create($validated);
        });

        return redirect()->route('admin.semesters.index')
            ->with('success', 'Semester created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Semester $semester): View
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->get();

        return view('admin.semesters.edit', compact('semester', 'academicYears'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Semester $semester): RedirectResponse
    {
        $validated = $request->validate([
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'semester_number' => ['required', 'integer', 'in:1,2'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_current' => ['sometimes', 'boolean'],
        ]);

        $validated['is_current'] = $request->boolean('is_current');

        $exists = Semester::where('academic_year_id', $validated['academic_year_id'])
            ->where('semester_number', $validated['semester_number'])
            ->where('id', '!=', $semester->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'semester_number' => 'This semester already exists for the selected academic year.',
            ]);
        }

        DB::transaction(function () use ($validated, $semester) {
            if ($validated['is_current']) {
                Semester::where('is_current', true)->where('id', '!=', $semester->id)->update(['is_current' => false]);
            }

            $semester->update($validated);
        });

        return redirect()->route('admin.semesters.index')
            ->with('success', 'Semester updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semester $semester): RedirectResponse
    {
        if ($semester->courses()->exists()) {
            return redirect()->route('admin.semesters.index')
                ->with('error', 'Cannot delete a semester that still has courses assigned to it.');
        }

        $semester->delete();

        return redirect()->route('admin.semesters.index')
            ->with('success', 'Semester deleted successfully.');
    }
}
