@extends('admin.layout.layout')
 @php
        $isEdit = isset($attributeValue);
@endphp


@section('meta-content')
    <title>{{ $isEdit ? 'Edit Attribute Value' : 'Create Attribute Value' }}</title>

    <meta name="description" content="Attribute Value Table" />
@endsection

@section('css-section')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/flatpickr/flatpickr.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/@form-validation/form-validation.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/tagify/tagify.css')}}" />
@endsection


@section('content')




    <div class="container-xxl flex grow 1 container-p-y">

             <h5 class="card-header mb-2">{{ $isEdit ? 'Edit Attribute Value' : 'Create Attribute Value' }}</h5>
        <div class="row g-6">
            <div class="col-md-6">
                          

                <div class="card">
                
                    <div class="card-body">


                     <form action="{{ route('attributeValue.bulkStore') }}" method="POST">
                            @csrf

                            <!-- Attribute -->
                            <div class="mb-3">
                                <label class="form-label">Select Attribute</label>
                                <select name="attribute_id" class="select2 form-select" required>
                                    <option value="">Select Attribute</option>
                                    @foreach($attributes as $attribute)
                                        <option value="{{ $attribute->id }}">
                                            {{ ucfirst($attribute->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-admin.error field="attribute_id" />
                            </div>

                            <!-- Values -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Attribute Values <small class="text-muted">(For Multiple Values:use (,))</small>
                                </label>
                                <textarea name="values"
                                    id="attributeValues"
                                    class="form-control tagify info"
                                    rows="8"
                                    placeholder="For Multiple Values:Click Enter after add One"
                                    required>{{ old('values') }}</textarea>
                                <x-admin.error field="values" />
                            </div>

                            <button class="btn btn-primary w-100">Save Values</button>
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
    <script src="{{ asset('assets/admin/vendor/libs/tagify/tagify.js')}}"></script>
    <script src="{{ asset('assets/admin/js/custom/tag.js')}}"></script>
    <script src="{{ asset('assets/admin/js/pageJs/attribute-value.js') }}"></script>



@endsection


