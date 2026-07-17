<x-layouts.dashboard title="Admin Dashboard">
    <x-slot:sidebar>
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.departments.index') }}" class="nav-link">
                <i class="bi bi-building-fill me-2"></i> Manage Departments
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.programs.index') }}" class="nav-link">
                <i class="bi bi-mortarboard-fill me-2"></i> Manage Programs
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.subjects.index') }}" class="nav-link">
                <i class="bi bi-journal-text me-2"></i> Manage Subjects
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.students.index') }}" class="nav-link">
                <i class="bi bi-people-fill me-2"></i> Manage Students
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.teachers.index') }}" class="nav-link">
                <i class="bi bi-person-badge-fill me-2"></i> Manage Teachers
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-cash-coin me-2"></i> Manage Fees
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-gear-fill me-2"></i> Website Settings
            </a>
        </li>
    </x-slot:sidebar>

    <div class="row">
        <x-stat-card label="Total Students" value="{{ $stats['total_students'] }}" icon="bi-people-fill" color="primary" />
        <x-stat-card label="Total Teachers" value="{{ $stats['total_teachers'] }}" icon="bi-person-badge-fill" color="success" />
        <x-stat-card label="Active Programs" value="{{ $stats['total_courses'] }}" icon="bi-journal-bookmark-fill" color="warning" />
        <x-stat-card label="Pending Admissions" value="{{ $stats['pending_admissions'] }}" icon="bi-file-earmark-text-fill" color="danger" />
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Recently Added Students</h6>
                    @forelse ($recentStudents as $student)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <div class="fw-semibold">{{ $student->user->name }}</div>
                                <div class="text-muted small">{{ $student->program->name }}</div>
                            </div>
                            <span class="badge bg-secondary">{{ $student->student_id_number }}</span>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No students added yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Recently Added Teachers</h6>
                    @forelse ($recentTeachers as $teacher)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <div class="fw-semibold">{{ $teacher->user->name }}</div>
                                <div class="text-muted small">{{ $teacher->department->name }}</div>
                            </div>
                            <span class="badge bg-secondary">{{ $teacher->employee_id }}</span>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No teachers added yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title fw-bold">Welcome, {{ auth()->user()->name }}</h5>
            <p class="text-muted mb-0">
                This is your Admin dashboard. Use the sidebar to manage departments, programs, students, and teachers.
            </p>
        </div>
    </div>
</x-layouts.dashboard>
