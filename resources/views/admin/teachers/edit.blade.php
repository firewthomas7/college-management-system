<x-layouts.dashboard title="Edit Teacher">
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
            <h5 class="fw-bold mb-1">Edit Teacher</h5>
            <p class="text-muted small mb-4">Employee ID: <strong>{{ $teacher->employee_id }}</strong> (cannot be changed)</p>

            <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST">
                @csrf
                @method('PUT')

                <h6 class="fw-bold text-muted small text-uppercase mb-3">Account Information</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <x-input-label for="name" value="Full Name" />
                        <x-text-input id="name" type="text" name="name" :value="old('name', $teacher->user->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <x-input-label for="email" value="Email Address" />
                        <x-text-input id="email" type="email" name="email" :value="old('email', $teacher->user->email)" required />
                        <x-input-error :messages="$errors->get('email')" />
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold text-muted small text-uppercase mb-3">Professional Information</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <x-input-label for="department_id" value="Department" />
                        <select id="department_id" name="department_id" class="form-select" required>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected(old('department_id', $teacher->department_id) == $department->id)>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('department_id')" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <x-input-label for="hire_date" value="Hire Date" />
                        <x-text-input id="hire_date" type="date" name="hire_date" :value="old('hire_date', $teacher->hire_date->format('Y-m-d'))" required />
                        <x-input-error :messages="$errors->get('hire_date')" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <x-input-label for="qualification" value="Qualification (optional)" />
                        <x-text-input id="qualification" type="text" name="qualification" :value="old('qualification', $teacher->qualification)" />
                        <x-input-error :messages="$errors->get('qualification')" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <x-input-label for="specialization" value="Specialization (optional)" />
                        <x-text-input id="specialization" type="text" name="specialization" :value="old('specialization', $teacher->specialization)" />
                        <x-input-error :messages="$errors->get('specialization')" />
                    </div>
                </div>

                <div class="mb-3">
                    <x-input-label for="status" value="Status" />
                    <select id="status" name="status" class="form-select">
                        <option value="active" @selected(old('status', $teacher->status) === 'active')>Active</option>
                        <option value="on_leave" @selected(old('status', $teacher->status) === 'on_leave')>On Leave</option>
                        <option value="terminated" @selected(old('status', $teacher->status) === 'terminated')>Terminated</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" />
                </div>

                <hr class="my-4">

                <h6 class="fw-bold text-muted small text-uppercase mb-3">Personal Information</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <x-input-label for="gender" value="Gender" />
                        <select id="gender" name="gender" class="form-select" required>
                            <option value="Male" @selected(old('gender', $teacher->gender) === 'Male')>Male</option>
                            <option value="Female" @selected(old('gender', $teacher->gender) === 'Female')>Female</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" />
                    </div>

                    <div class="col-md-4 mb-3">
                        <x-input-label for="date_of_birth" value="Date of Birth" />
                        <x-text-input id="date_of_birth" type="date" name="date_of_birth" :value="old('date_of_birth', optional($teacher->date_of_birth)->format('Y-m-d'))" />
                        <x-input-error :messages="$errors->get('date_of_birth')" />
                    </div>

                    <div class="col-md-4 mb-3">
                        <x-input-label for="phone" value="Phone Number" />
                        <x-text-input id="phone" type="text" name="phone" :value="old('phone', $teacher->phone)" />
                        <x-input-error :messages="$errors->get('phone')" />
                    </div>
                </div>

                <div class="mb-4">
                    <x-input-label for="address" value="Address (optional)" />
                    <textarea id="address" name="address" class="form-control" rows="2">{{ old('address', $teacher->address) }}</textarea>
                    <x-input-error :messages="$errors->get('address')" />
                </div>

                <button type="submit" class="btn btn-primary px-4">Update Teacher</button>
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </form>
        </div>
    </div>
</x-layouts.dashboard>
