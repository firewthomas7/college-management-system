<x-layouts.dashboard title="Add Department">
    <x-slot:sidebar>
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.departments.index') }}" class="nav-link active">
                <i class="bi bi-building-fill me-2"></i> Manage Departments
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.programs.index') }}" class="nav-link">
                <i class="bi bi-mortarboard-fill me-2"></i> Manage Programs
            </a>
        </li>
    </x-slot:sidebar>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Add New Department</h5>

            <form action="{{ route('admin.departments.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <x-input-label for="name" value="Department Name" />
                        <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div class="col-md-4 mb-3">
                        <x-input-label for="code" value="Department Code" />
                        <x-text-input id="code" type="text" name="code" :value="old('code')" required placeholder="e.g. CS" />
                        <x-input-error :messages="$errors->get('code')" />
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

                <button type="submit" class="btn btn-primary px-4">Save Department</button>
                <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </form>
        </div>
    </div>
</x-layouts.dashboard>
