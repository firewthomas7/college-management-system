<x-layouts.dashboard title="Teacher Dashboard">
    <x-slot:sidebar>
        <li class="nav-item">
            <a href="{{ route('teacher.dashboard') }}" class="nav-link active">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-journal-text me-2"></i> My Subjects
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-clipboard-check-fill me-2"></i> Attendance
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-award-fill me-2"></i> Submit Grades
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-file-earmark-text-fill me-2"></i> Assignments
            </a>
        </li>
    </x-slot:sidebar>

    <div class="row">
        <x-stat-card label="My Courses" value="0" icon="bi-journal-bookmark-fill" color="primary" />
        <x-stat-card label="My Students" value="0" icon="bi-people-fill" color="success" />
        <x-stat-card label="Pending Grades" value="0" icon="bi-award-fill" color="warning" />
        <x-stat-card label="Assignments Due" value="0" icon="bi-file-earmark-text-fill" color="danger" />
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title fw-bold">Welcome, {{ auth()->user()->name }}</h5>
            <p class="text-muted mb-0">
                This is your Teacher dashboard. Your assigned subjects and classes will appear here once courses are set up.
            </p>
        </div>
    </div>
</x-layouts.dashboard>
