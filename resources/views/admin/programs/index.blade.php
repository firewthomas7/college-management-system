<x-layouts.dashboard title="Manage Programs">
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
            <a href="{{ route('admin.programs.index') }}" class="nav-link active">
                <i class="bi bi-mortarboard-fill me-2"></i> Manage Programs
            </a>
        </li>
    </x-slot:sidebar>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">All Programs</h5>
        <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Program
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Level</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($programs as $program)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $program->code }}</span></td>
                                <td>{{ $program->name }}</td>
                                <td>{{ $program->department->name }}</td>
                                <td>{{ $program->degree_level }}</td>
                                <td>{{ $program->duration_years }} yrs</td>
                                <td>
                                    @if ($program->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.programs.edit', $program) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this program?');">
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
                                <td colspan="7" class="text-center text-muted py-4">No programs yet. Add your first one.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $programs->links() }}
        </div>
    </div>
</x-layouts.dashboard>
