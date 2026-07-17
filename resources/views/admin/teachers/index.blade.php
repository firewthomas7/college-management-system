<x-layouts.dashboard title="Manage Teachers">
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
            <a href="{{ route('admin.students.index') }}" class="nav-link">
                <i class="bi bi-people-fill me-2"></i> Manage Students
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.teachers.index') }}" class="nav-link active">
                <i class="bi bi-person-badge-fill me-2"></i> Manage Teachers
            </a>
        </li>
    </x-slot:sidebar>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('temporary_password'))
        <div class="alert alert-warning">
            <strong>Temporary password for {{ session('teacher_email') }}:</strong>
            <code class="fs-6">{{ session('temporary_password') }}</code>
            <div class="small mt-1">Share this securely with the teacher. It will not be shown again.</div>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">All Teachers</h5>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Teacher
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Specialization</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($teachers as $teacher)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $teacher->employee_id }}</span></td>
                                <td>
                                    {{ $teacher->user->name }}
                                    <div class="text-muted small">{{ $teacher->user->email }}</div>
                                </td>
                                <td>{{ $teacher->department->name }}</td>
                                <td>{{ $teacher->specialization ?? '—' }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'active' => 'success',
                                            'on_leave' => 'warning',
                                            'terminated' => 'secondary',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$teacher->status] ?? 'secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $teacher->status)) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this teacher? This will also delete their login account.');">
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
                                <td colspan="6" class="text-center text-muted py-4">No teachers yet. Add your first one.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $teachers->links() }}
        </div>
    </div>
</x-layouts.dashboard>
