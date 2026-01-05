@extends('admin.layout.layout')
 @php
        $isEdit = isset($attribute);
@endphp


@section('meta-content')
    <title>{{ $isEdit ? 'Edit Attribute' : 'Create Attribute' }}</title>

    <meta name="description" content="Attribute Table" />
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
        $isEdit = isset($attribute);
    @endphp


    <div class="container-xxl flex grow 1 container-p-y">

             <h5 class="card-header mb-2">{{ $isEdit ? 'Edit Attribute' : 'Create Attribute' }}</h5>
        <div class="row g-6">
            <div class="col-md-6">
                          

                <div class="card">
                
                    <div class="card-body">


                        <form action="{{ $isEdit ? route('admin.attributes.update', $attribute->id) : route('admin.attributes.store') }}" method="POST" >
                            @csrf

                                @if($isEdit)
                                    @method('PUT')
                                @endif
                                
                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name"
                                   value="{{ old('name', $attribute->name ?? '') }}" >
                                <x-admin.error field="name" />
                            </div>

                             <!-- Slug -->
                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input 
                                    type="text" 
                                    class="form-control bg-light"
                                    name="slug"
                                    id="slug"
                                    value="{{ old('slug', $attribute->slug ?? '') }}"
                                    readonly
                                >
                                <x-admin.error field="slug" />
                            </div>


                            <!-- Status -->
                            <div class="mb-3">
                                    <div class="form-check mt-5">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" class="form-check-input" name="is_active" value="1"
                                            {{ old('is_active', $attribute->is_active ?? 1) ? 'checked' : '' }}>

                                        <label class="form-check-label">
                                            Active
                                        </label>
                                    </div>
                                <x-admin.error field="is_active" />
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
    <script src="{{ asset('assets/admin/js/forms-selects.js')}}"></script>
    <script>
        document.getElementById('name').addEventListener('keyup', function() {
            let title = this.value;

            let slug = title
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '') // remove special chars
                .replace(/\s+/g, '-')        // spaces to hyphens
                .replace(/-+/g, '-');       // multiple hyphens to single

            document.getElementById('slug').value = slug;
        });
    </script>


@endsection


