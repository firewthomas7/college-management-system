<x-layouts.dashboard title="Edit Student">
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

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-1">Edit Student</h5>
            <p class="text-muted small mb-4">Student ID: <strong>{{ $student->student_id_number }}</strong> (cannot be changed)</p>

            <form action="{{ route('admin.students.update', $student) }}" method="POST">
                @csrf
                @method('PUT')

                <h6 class="fw-bold text-muted small text-uppercase mb-3">Account Information</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <x-input-label for="name" value="Full Name" />
                        <x-text-input id="name" type="text" name="name" :value="old('name', $student->user->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <x-input-label for="email" value="Email Address" />
                        <x-text-input id="email" type="email" name="email" :value="old('email', $student->user->email)" required />
                        <x-input-error :messages="$errors->get('email')" />
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold text-muted small text-uppercase mb-3">Academic Information</h6>
                <div class="mb-3">
                    <x-input-label for="program_id" value="Program" />
                    <select id="program_id" name="program_id" class="form-select" required>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}" @selected(old('program_id', $student->program_id) == $program->id)>
                                {{ $program->name }} ({{ $program->department->name }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('program_id')" />
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <x-input-label for="admission_date" value="Admission Date" />
                        <x-text-input id="admission_date" type="date" name="admission_date" :value="old('admission_date', $student->admission_date->format('Y-m-d'))" required />
                        <x-input-error :messages="$errors->get('admission_date')" />
                    </div>

                    <div class="col-md-4 mb-3">
                        <x-input-label for="current_year_level" value="Current Year Level" />
                        <x-text-input id="current_year_level" type="number" name="current_year_level" :value="old('current_year_level', $student->current_year_level)" min="1" max="7" required />
                        <x-input-error :messages="$errors->get('current_year_level')" />
                    </div>

                    <div class="col-md-4 mb-3">
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" class="form-select">
                            <option value="active" @selected(old('status', $student->status) === 'active')>Active</option>
                            <option value="graduated" @selected(old('status', $student->status) === 'graduated')>Graduated</option>
                            <option value="suspended" @selected(old('status', $student->status) === 'suspended')>Suspended</option>
                            <option value="withdrawn" @selected(old('status', $student->status) === 'withdrawn')>Withdrawn</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" />
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold text-muted small text-uppercase mb-3">Personal Information</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <x-input-label for="gender" value="Gender" />
                        <select id="gender" name="gender" class="form-select" required>
                            <option value="Male" @selected(old('gender', $student->gender) === 'Male')>Male</option>
                            <option value="Female" @selected(old('gender', $student->gender) === 'Female')>Female</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" />
                    </div>

                    <div class="col-md-4 mb-3">
                        <x-input-label for="date_of_birth" value="Date of Birth" />
                        <x-text-input id="date_of_birth" type="date" name="date_of_birth" :value="old('date_of_birth', optional($student->date_of_birth)->format('Y-m-d'))" />
                        <x-input-error :messages="$errors->get('date_of_birth')" />
                    </div>

                    <div class="col-md-4 mb-3">
                        <x-input-label for="phone" value="Phone Number" />
                        <x-text-input id="phone" type="text" name="phone" :value="old('phone', $student->phone)" />
                        <x-input-error :messages="$errors->get('phone')" />
                    </div>
                </div>

                <div class="mb-4">
                    <x-input-label for="address" value="Address (optional)" />
                    <textarea id="address" name="address" class="form-control" rows="2">{{ old('address', $student->address) }}</textarea>
                    <x-input-error :messages="$errors->get('address')" />
                </div>

                <button type="submit" class="btn btn-primary px-4">Update Student</button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </form>
        </div>
    </div>
</x-layouts.dashboard>
