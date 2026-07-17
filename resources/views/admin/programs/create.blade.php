<x-layouts.dashboard title="Add Program">
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

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Add New Program</h5>

            @if ($departments->isEmpty())
                <div class="alert alert-warning">
                    You must create at least one active department before adding a program.
                    <a href="{{ route('admin.departments.create') }}" class="fw-semibold">Create one now</a>.
                </div>
            @else
                <form action="{{ route('admin.programs.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <x-input-label for="department_id" value="Department" />
                        <select id="department_id" name="department_id" class="form-select" required>
                            <option value="">-- Select Department --</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('department_id')" />
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <x-input-label for="name" value="Program Name" />
                            <x-text-input id="name" type="text" name="name" :value="old('name')" required placeholder="e.g. BSc Computer Science" />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <x-input-label for="code" value="Program Code" />
                            <x-text-input id="code" type="text" name="code" :value="old('code')" required placeholder="e.g. BSC-CS" />
                            <x-input-error :messages="$errors->get('code')" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-input-label for="degree_level" value="Degree Level" />
                            <select id="degree_level" name="degree_level" class="form-select" required>
                                <option value="">-- Select Level --</option>
                                <option value="Diploma" @selected(old('degree_level') === 'Diploma')>Diploma</option>
                                <option value="Bachelor" @selected(old('degree_level') === 'Bachelor')>Bachelor</option>
                                <option value="Master" @selected(old('degree_level') === 'Master')>Master</option>
                            </select>
                            <x-input-error :messages="$errors->get('degree_level')" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <x-input-label for="duration_years" value="Duration (Years)" />
                            <x-text-input id="duration_years" type="number" name="duration_years" :value="old('duration_years', 4)" min="1" max="7" required />
                            <x-input-error :messages="$errors->get('duration_years')" />
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

                    <button type="submit" class="btn btn-primary px-4">Save Program</button>
                    <a href="{{ route('admin.programs.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </form>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
