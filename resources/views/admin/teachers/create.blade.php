<x-layouts.dashboard title="Add Teacher">
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

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Add New Teacher</h5>

            @if ($departments->isEmpty())
                <div class="alert alert-warning">
                    You must create at least one active department before adding a teacher.
                    <a href="{{ route('admin.departments.create') }}" class="fw-semibold">Create one now</a>.
                </div>
            @else
                <form action="{{ route('admin.teachers.store') }}" method="POST">
                    @csrf

                    <h6 class="fw-bold text-muted small text-uppercase mb-3">Account Information</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-input-label for="name" value="Full Name" />
                            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <x-input-label for="email" value="Email Address" />
                            <x-text-input id="email" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" />
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold text-muted small text-uppercase mb-3">Professional Information</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
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

                        <div class="col-md-6 mb-3">
                            <x-input-label for="hire_date" value="Hire Date" />
                            <x-text-input id="hire_date" type="date" name="hire_date" :value="old('hire_date', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('hire_date')" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-input-label for="qualification" value="Qualification (optional)" />
                            <x-text-input id="qualification" type="text" name="qualification" :value="old('qualification')" placeholder="e.g. MSc Computer Science" />
                            <x-input-error :messages="$errors->get('qualification')" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <x-input-label for="specialization" value="Specialization (optional)" />
                            <x-text-input id="specialization" type="text" name="specialization" :value="old('specialization')" placeholder="e.g. Database Systems" />
                            <x-input-error :messages="$errors->get('specialization')" />
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold text-muted small text-uppercase mb-3">Personal Information</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <x-input-label for="gender" value="Gender" />
                            <select id="gender" name="gender" class="form-select" required>
                                <option value="">-- Select --</option>
                                <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                                <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <x-input-label for="date_of_birth" value="Date of Birth" />
                            <x-text-input id="date_of_birth" type="date" name="date_of_birth" :value="old('date_of_birth')" />
                            <x-input-error :messages="$errors->get('date_of_birth')" />
                        </div>

                        <div class="col-md-4 mb-3">
                            <x-input-label for="phone" value="Phone Number" />
                            <x-text-input id="phone" type="text" name="phone" :value="old('phone')" />
                            <x-input-error :messages="$errors->get('phone')" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="address" value="Address (optional)" />
                        <textarea id="address" name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" />
                    </div>

                    <div class="alert alert-info small">
                        A login account will be created automatically with a system-generated temporary password, which will be shown once after saving.
                    </div>

                    <button type="submit" class="btn btn-primary px-4">Save Teacher</button>
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </form>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
