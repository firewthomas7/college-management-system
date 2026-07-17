<x-layouts.dashboard title="Student Dashboard">
    <x-slot:sidebar>
        <li class="nav-item">
            <a href="{{ route('student.dashboard') }}" class="nav-link active">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-journal-bookmark-fill me-2"></i> My Courses
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-clipboard-check-fill me-2"></i> Attendance
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-award-fill me-2"></i> Grades &amp; CGPA
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-cash-coin me-2"></i> Fee Status
            </a>
        </li>
    </x-slot:sidebar>

    <div class="row">
        <x-stat-card label="Enrolled Courses" value="0" icon="bi-journal-bookmark-fill" color="primary" />
        <x-stat-card label="Attendance Rate" value="0%" icon="bi-clipboard-check-fill" color="success" />
        <x-stat-card label="Current CGPA" value="0.00" icon="bi-award-fill" color="warning" />
        <x-stat-card label="Fee Balance" value="0 ETB" icon="bi-cash-coin" color="danger" />
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title fw-bold">Welcome, {{ auth()->user()->name }}</h5>
            <p class="text-muted mb-0">
                This is your Student dashboard. Your enrolled courses, attendance, and grades will appear here once academic data is connected.
            </p>
        </div>
    </div>
</x-layouts.dashboard>
