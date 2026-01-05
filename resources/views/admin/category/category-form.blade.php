@extends('admin.layout.layout')
 @php
        $isEdit = isset($category);
@endphp


@section('meta-content')
    <title>{{ $isEdit ? 'Edit Category' : 'Create Category' }}</title>

    <meta name="description" content="Category Table" />
@endsection

@section('css-section')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/flatpickr/flatpickr.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/@form-validation/form-validation.css')}}" />

    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/quill/typography.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/quill/editor.css')}}" />
     <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/tagify/tagify.css')}}" />
@endsection


@section('content')

    @php
        $isEdit = isset($category);
    @endphp


    <div class="container-xxl flex grow 1 container-p-y">

        <h5 class="card-header mb-2">{{ $isEdit ? 'Edit Category' : 'Create Category' }}</h5>

        <div class="row g-4">

    <!-- LEFT COLUMN : MAIN CONTENT -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">

                        <form id="category-form"
                            action="{{ $isEdit ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" 
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            @if($isEdit)
                                @method('PUT')
                            @endif

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="name"
                                    id="name"
                                    value="{{ old('name', $category->name ?? '') }}"
                                >
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
                                    value="{{ old('slug', $category->slug ?? '') }}"
                                    readonly
                                >
                                <x-admin.error field="slug" />
                            </div>

                            <!-- Image -->
                            <div class="mb-3">
                                <label class="form-label">Category Image</label>
                                <input type="file" class="form-control" name="image">
                                <x-admin.error field="image" />

                                @if($isEdit && $category->image)
                                    <img 
                                        src="{{ asset('storage/'.$category->image) }}" 
                                        class="mt-2 rounded border"
                                        width="120"
                                    >
                                @endif
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Description</label>

                                <div id="full-editor" class="border rounded"></div>

                                <textarea
                                    name="description"
                                    id="description"
                                    class="d-none"
                                >{{ old('description', $category->description ?? '') }}</textarea>

                                <x-admin.error field="description" />
                            </div>




                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN : STATUS + SEO -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">

                        <h6 class="mb-3">Publish</h6>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="published" {{ old('status', $category->status ?? '') == 'published' ? 'selected' : '' }}>
                                    Published
                                </option>
                                <option value="draft" {{ old('status', $category->status ?? '') == 'draft' ? 'selected' : '' }}>
                                    Draft
                                </option>
                                <option value="inactive" {{ old('status', $category->status ?? '') == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>

                            <x-admin.error field="status" />
                        </div>

                        <!-- Featured -->
                        <div class="form-check mt-5">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" class="form-check-input" name="is_featured" value="1"
                                {{ old('is_featured', $category->is_featured ?? 0) ? 'checked' : '' }}>

                            <label class="form-check-label">
                                Featured Category
                            </label>
                        </div>

                    </div>
                </div>

                <!-- SEO CARD -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-3">SEO</h6>

                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input 
                                type="text" 
                                class="form-control"
                                name="meta_title"
                                value="{{ old('meta_title', $category->meta_title ?? '') }}"
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea 
                                class="form-control"
                                name="meta_description"
                                rows="2"
                            >{{ old('meta_description', $category->meta_description ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input
                                id="metaKeywords"
                                class="form-control"
                                name="meta_keywords"
                                value="{{ old('meta_keywords', $category->meta_keywords ?? '') }}"
                            />
                            <x-admin.error field="meta_keywords" />
                        </div>

                    </div>
                </div>

                <!-- SUBMIT -->
                <div class="mt-3">
                    <button class="btn btn-primary w-100">
                        {{ $isEdit ? 'Update Category' : 'Create Category' }}
                    </button>
                </div>

            </div>

                    </form>
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
    <script src="{{ asset('assets/admin/js/custom/editor.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/tagify/tagify.js')}}"></script>
    <script src="{{ asset('assets/admin/js/custom/tag.js')}}"></script>
    <script src="{{ asset('assets/admin/js/datatable/category.js')}}"></script>
    <script src="{{ asset('assets/admin/js/pageJs/category.js')}}"></script>

    <script src="{{ asset('assets/admin/vendor/libs/quill/quill.js')}}"></script>
  

 
  


     
@endsection