@extends('admin.layout.layout')
 @php
        $isEdit = isset($role);
@endphp


@section('meta-content')
    <title>{{ $isEdit ? 'Edit Role' : 'Create Role' }}</title>

    <meta name="description" content="Role Table" />
@endsection

@section('css-section')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/flatpickr/flatpickr.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/@form-validation/form-validation.css')}}" />
@endsection


@section('content')

    @php
        $isEdit = isset($role);
    @endphp


    <div class="container-xxl flex grow 1 container-p-y">

             <h5 class="card-header">{{ $isEdit ? 'Edit Role' : 'Create Role' }}</h5>
        <div class="row g-6">
            <div class="col-md-6">
                          
                <div class="card">
                
                    <div class="card-body">


                        <form action="{{ $isEdit ? route('admin.roles.update', $role->id) : route('admin.roles.store') }}" method="POST">
                            @csrf

                                @if($isEdit)
                                    @method('PUT')
                                @endif
                                
                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Role Name"
                                   value="{{ old('name', $role->name ?? '') }}" >
                                <x-admin.error field="name" />
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
    {{-- ---------/ D and T ---------- --}}
    <script src="{{ asset('assets/admin/vendor/libs/typeahead-js/typeahead.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/@form-validation/popular.j')}}s"></script>
    <script src="{{ asset('assets/admin/vendor/libs/@form-validation/bootstrap5.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/@form-validation/auto-focus.js')}}"></script>


@endsection