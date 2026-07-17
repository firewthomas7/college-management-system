<x-layouts.dashboard title="Manage Students">
    <x-slot:sidebar>
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
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
            <a href="{{ route('admin.students.index') }}" class="nav-link active">
                <i class="bi bi-people-fill me-2"></i> Manage Students
            </a>
        </li>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('temporary_password'))
        <div class="alert alert-warning">
            <strong>Temporary password for {{ session('student_email') }}:</strong>
            <code class="fs-6">{{ session('temporary_password') }}</code>
            <div class="small mt-1">Share this securely with the student. It will not be shown again.</div>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">All Students</h5>
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Student
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Program</th>
                            <th>Year</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $student->student_id_number }}</span></td>
                                <td>
                                    {{ $student->user->name }}
                                    <div class="text-muted small">{{ $student->user->email }}</div>
                                </td>
                                <td>{{ $student->program->name }}</td>
                                <td>Year {{ $student->current_year_level }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'active' => 'success',
                                            'graduated' => 'primary',
                                            'suspended' => 'warning',
                                            'withdrawn' => 'secondary',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$student->status] ?? 'secondary' }}">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this student? This will also delete their login account.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No students yet. Add your first one.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $students->links() }}
        </div>
    </div>
</x-layouts.dashboard>
