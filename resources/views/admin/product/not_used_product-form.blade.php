@extends('admin.layout.layout')
@section('meta-content')
    <title>Create Product</title>
    <meta name="description" content="Product Table" />
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
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/dropzone/dropzone.css')}}" />
@endsection


@section('content')




<div class="container-xxl flex-grow-1 container-p-y">

    <h5 class="card-header mb-2">Create Product</h5>

   <div class="card">
        <div class="card-body">

            <!-- FORM STARTS HERE -->
            <form id="product-form"
                action="{{ route('product.store') }}" 
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="row g-4">

                    <!-- LEFT COLUMN -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">

                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name') }}">
                                    <x-admin.error field="name" />
                                </div>

                                <!-- Slug -->
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control bg-light" name="slug" id="slug"
                                        value="{{ old('slug') }}" readonly>
                                    <x-admin.error field="slug" />
                                </div>

                                <!-- Short Description -->
                                <div class="mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea class="form-control" name="short_description" rows="2">{{ old('short_description') }}</textarea>
                                </div>

                                <!-- Brands -->
                                <div class="mb-3">
                                    <label class="form-label">Brands</label>
                                    <select name="brand" class="select2 form-select" required>
                                        <option value="" disabled>Select Brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ ucfirst($brand->name) }}</option>
                                        @endforeach
                                    </select>
                                    <x-admin.error field="brand" />
                                </div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="select2 form-select" required>
                                        <option value="" disabled>Select category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                        @endforeach
                                    </select>
                                    <x-admin.error field="category" />
                                </div>

                                <!-- Featured Image -->
                                <div class="mb-3">
                                    <label class="form-label">Featured Image</label>
                                    <input type="file" class="form-control" name="main_image">
                                    <x-admin.error field="main_image" />
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <div id="full-editor" class="border rounded"></div>
                                    <textarea name="description" id="description" class="d-none">{{ old('description') }}</textarea>
                                    <x-admin.error field="description" />
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN -->
                    <div class="col-lg-4">

                        <!-- Publish -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h6 class="mb-3">Publish</h6>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="published">Published</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                    <x-admin.error field="status" />
                                </div>

                                <!-- Active -->
                                <div class="form-check mt-5">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" class="form-check-input" name="is_active" value="1">
                                    <label class="form-check-label">Is Active</label>
                                </div>

                                
                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3">SEO</h6>

                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" class="form-control" name="meta_title"
                                        value="{{ old('meta_title') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input id="metaKeywords" class="form-control" name="meta_keywords"
                                        value="{{ old('meta_keywords') }}">
                                    <x-admin.error field="meta_keywords" />
                                </div>

                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="mt-3">
                            <button class="btn btn-primary w-100">Create Product</button>
                        </div>

                    </div>

                </div>

            </form>
            <!-- FORM ENDS HERE -->

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
    <script src="{{ asset('assets/admin/vendor/libs/dropzone/dropzone.js')}}"></script>
    {{-- ---------/ D and T ---------- --}}
    <script src="{{ asset('assets/admin/vendor/libs/typeahead-js/typeahead.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/@form-validation/popular.j')}}s"></script>
    <script src="{{ asset('assets/admin/vendor/libs/@form-validation/bootstrap5.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/@form-validation/auto-focus.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{ asset('assets/admin/js/custom/select.js')}}"></script>
    <script src="{{ asset('assets/admin/js/custom/editor.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/tagify/tagify.js')}}"></script>
    <script src="{{ asset('assets/admin/js/custom/tag.js')}}"></script>
    <script src="{{ asset('assets/admin/js/custom/dropzone-uploader.js')}}"></script>
    <script src="{{ asset('assets/admin/js/datatable/category.js')}}"></script>
    <script src="{{ asset('assets/admin/js/pageJs/category.js')}}"></script>

    <script src="{{ asset('assets/admin/vendor/libs/quill/quill.js')}}"></script>


  
  
{{-- <script src="{{ asset('assets/admin/js/app-ecommerce-product-add.js') }}"></script> --}}

 

@endsection