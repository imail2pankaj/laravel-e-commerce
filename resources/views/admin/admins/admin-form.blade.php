@extends('admin.layout.layout')
 @php
        $isEdit = isset($admin);
@endphp


@section('meta-content')
    <title>{{ $isEdit ? 'Edit Admin' : 'Create Admin' }}</title>

    <meta name="description" content="admins Table" />
@endsection

@section('css-section')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/flatpickr/flatpickr.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/@form-validation/form-validation.css')}}" />
@endsection


@section('content')



    <div class="container-xxl flex grow 1 container-p-y">

             <h5 class="card-header mb-2">{{ $isEdit ? 'Edit Admin' : 'Create Admin' }}</h5>
        <div class="row g-6">
            <div class="col-md-6">
                          

                <div class="card">
                
                    <div class="card-body">


                        <form action="{{ $isEdit ? route('admin.users.update', $admin->id) : route('admin.users.store') }}" method="POST">
                            @csrf

                                @if($isEdit)
                                    @method('PUT')
                                @endif
                                
                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name"
                                   value="{{ old('name', $admin->name ?? '') }}" >
                                <x-admin.error field="name" />
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" value="{{ old('email', $admin->email ?? '') }}">
                                <x-admin.error field="email" />
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password @if($isEdit)<small class="text-muted">(leave blank if not changing)</small>@endif</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter password" >
                                <x-admin.error field="password" />
                            </div>

                               <!-- ROLE -->
                            <div class="mb-3">
                                <label class="form-label">Select Role</label>

                                @php
                                    // 1) Start with old() value if exist (after validation error)
                                    $selectedRole = old('role');

                                    // 2) If no old value and we are in edit mode, get amins's role
                                    if (!$selectedRole && isset($admin) && $admin) {
                                        $selectedRole = $admin->roles()->pluck('name')->first();
                                    }
                                @endphp

                                <select name="role" class="select2 form-select" required>
                                    <option value="" disabled {{ $selectedRole ? '' : 'selected' }}>Select Role</option>

                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ $selectedRole == $role->name ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>

                                <x-admin.error field="role" />
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('js-section')

    <!-- Vendors JS -->
    {{-- selection input --}}
    <script src="{{ asset('assets/admin/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
    {{-- date and time input --}}
    <script src="{{ asset('assets/admin/vendor/libs/moment/moment.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/flatpickr/flatpickr.js')}}"></script>
     <script src="{{ asset('assets/admin/vendor/libs/select2/select2.js')}}"></script>

    {{-- ---------/ D and T ---------- --}}
    <script src="{{ asset('assets/admin/vendor/libs/typeahead-js/typeahead.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/@form-validation/popular.j')}}s"></script>
    <script src="{{ asset('assets/admin/vendor/libs/@form-validation/bootstrap5.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/@form-validation/auto-focus.js')}}"></script>
      <script src="{{ asset('assets/admin/js/custom/select.js')}}"></script>
    


@endsection