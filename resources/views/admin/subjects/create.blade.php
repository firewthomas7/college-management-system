<x-layouts.dashboard title="Add Subject">
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
            <a href="{{ route('admin.subjects.index') }}" class="nav-link active">
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
    </x-slot:sidebar>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Add New Subject</h5>

            @if ($programs->isEmpty())
                <div class="alert alert-warning">
                    You must create at least one active program before adding a subject.
                    <a href="{{ route('admin.programs.create') }}" class="fw-semibold">Create one now</a>.
                </div>
            @else
                <form action="{{ route('admin.subjects.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <x-input-label for="program_id" value="Program" />
                        <select id="program_id" name="program_id" class="form-select" required>
                            <option value="">-- Select Program --</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}" @selected(old('program_id') == $program->id)>
                                    {{ $program->name }} ({{ $program->department->name }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('program_id')" />
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <x-input-label for="name" value="Subject Name" />
                            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="e.g. Data Structures and Algorithms" />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <x-input-label for="code" value="Subject Code" />
                            <x-text-input id="code" type="text" name="code" :value="old('code')" required placeholder="e.g. CS201" />
                            <x-input-error :messages="$errors->get('code')" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <x-input-label for="year_level" value="Year Level" />
                            <x-text-input id="year_level" type="number" name="year_level" :value="old('year_level', 1)" min="1" max="7" required />
                            <x-input-error :messages="$errors->get('year_level')" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <x-input-label for="semester_number" value="Semester" />
                            <select id="semester_number" name="semester_number" class="form-select" required>
                                <option value="1" @selected(old('semester_number', 1) == 1)>Semester 1</option>
                                <option value="2" @selected(old('semester_number') == 2)>Semester 2</option>
                            </select>
                            <x-input-error :messages="$errors->get('semester_number')" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <x-input-label for="credit_hours" value="Credit Hours" />
                            <x-text-input id="credit_hours" type="number" name="credit_hours" :value="old('credit_hours', 3)" min="1" max="10" required />
                            <x-input-error :messages="$errors->get('credit_hours')" />
                        </div>
                    </div>

                    <div class="mb-3">
                        <x-input-label for="description" value="Description (optional)" />
                        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" class="form-select">
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" />
                    </div>

                    <button type="submit" class="btn btn-primary px-4">Save Subject</button>
                    <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </form>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
