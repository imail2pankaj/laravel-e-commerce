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
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>


@endsection

@section('content')


    @php
        $isEdit = isset($product);
    @endphp



    @php
    $activeTab = session('active_tab',  'tabProduct');
    @endphp



<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="card-header mb-0">
            {{ isset($product) ? 'Edit Product' : 'Create Product' }}
        </h5>
    </div>

    <div class="card">

        <div class="card-datatable text-nowrap p-4">

              

            <!-- ===================================== -->
            <!--              TAB HEADERS              -->
            <!-- ===================================== -->
            <ul class="nav nav-tabs" id="productTab" role="tablist">

                <!-- Always show PRODUCT tab -->
                <li class="nav-item">
                    <button class="nav-link {{ $activeTab == 'tabProduct' ? 'active' : '' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tabProduct">
                        Product
                    </button>
                </li>

                <!-- Show SEO tab ONLY in edit mode -->
                @if(isset($product))

                   <li class="nav-item">
                        <button class="nav-link {{ $activeTab == 'tabVariants' ? 'active' : '' }}"
                            data-bs-toggle="tab"
                            data-bs-target="#tabVariants">
                           Variants
                        </button>
                    </li>

                   <li class="nav-item">
                        <button class="nav-link {{ $activeTab == 'tabImages' ? 'active' : '' }}"
                            data-bs-toggle="tab"
                            data-bs-target="#tabImages">
                            Images
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link {{ $activeTab == 'tabSEO' ? 'active' : '' }}"
                            data-bs-toggle="tab"
                            data-bs-target="#tabSEO">
                            SEO
                        </button>
                    </li>
                   
                @endif

                

            </ul>

            <div class="tab-content pt-3">

                <!-- ===================================== -->
                <!--              TAB 1: PRODUCT            -->
                <!-- ===================================== -->
                <div class="tab-pane fade {{ $activeTab == 'tabProduct' ? 'show active' : '' }}" id="tabProduct">

                    <form id="product-form"
                        action="{{isset($product) ? route('product.update', $product->id) : route('product.store') }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf
                        @if(isset($product))
                            @method('PUT')
                        @endif

                
                        <div class="row">
                            <div class="col-lg-8">

                                <div class="card mb-4">
                                    <div class="card-body">

                                        <!-- Product Name -->
                                        <div class="mb-3">
                                            <label class="form-label">Product Name</label>
                                            <input type="text"
                                                class="form-control"
                                                name="name"
                                                id="name"
                                                value="{{ old('name', $product->name ?? '') }}">
                                            <x-admin.error field="name" />
                                        </div>

                                        <!-- Slug -->
                                        <div class="mb-3">
                                            <label class="form-label">Slug</label>
                                            <input type="text"
                                                class="form-control bg-light"
                                                name="slug"
                                                id="slug"
                                                readonly
                                                value="{{ old('slug', $product->slug ?? '') }}">
                                            <x-admin.error field="slug" />
                                        </div>

                                        <!-- Short Description -->
                                        <div class="mb-3">
                                            <label class="form-label">Short Description</label>
                                            <textarea class="form-control"
                                                    name="short_description"
                                                    rows="2">{{ old('short_description', $product->short_description ?? '') }}</textarea>
                                                    
                                        </div>                             

                                        <!-- Description -->
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>

                                            <div id="full-editor" class="border rounded">
                                                {!! $product->description ?? '' !!}
                                            </div>

                                            <textarea name="description"
                                                    id="description"
                                                    class="d-none">{{ old('description', $product->description ?? '') }}</textarea>

                                            <x-admin.error field="description" />
                                        </div>

                                        <!-- Main Image -->
                                        <div class="mb-3">
                                            <label class="form-label">Featured Image</label>
                                            <input type="file" class="form-control" name="main_image">


                                            @if(isset($product) && $product->main_image)
                                                <img src="{{ asset('storage/' . $product->main_image) }}"
                                                    width="120"
                                                    class="mt-2 rounded border">
                                            @endif
                                        </div>


                                

                                    </div>
                                </div>

                            </div>

                            <!-- RIGHT SIDE -->
                            <div class="col-lg-4">

                                <div class="card mb-4">
                                    <div class="card-body">

                                         <h6 class="mb-3">Price and Stock</h6>

                                           <!-- Product SKU -->
                                        <div class="mb-3">
                                            <label class="form-label">Product SKU</label>

                                            @if(isset($product) && $product->sku)
                                                <input type="text" class="form-control bg-light" value="{{ $product->sku }}" readonly>
                                            @else
                                                <input type="text" class="form-control bg-light" value="(SKU will be auto-generated after saving)" readonly>
                                            @endif

                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Original Price</label>
                                            <input type="number"
                                                class="form-control"
                                                name="original_price"
                                                id="original_price"
                                                value="{{ old('original_price', $product->original_price ?? '') }}">
                                            <x-admin.error field="original_price" />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Selling Price</label>
                                            <input type="number"
                                                class="form-control"
                                                name="selling_price"
                                                id="selling_price"
                                                value="{{ old('selling_price', $product->selling_price ?? '') }}">
                                            <x-admin.error field="selling_price" />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Stock</label>
                                            <input type="number"
                                                class="form-control"
                                                name="stock"
                                                id="stock"
                                                value="{{ old('stock', $product->stock ?? '') }}">
                                            <x-admin.error field="stock" />
                                        </div>

                                      
                                        <hr>
                                         <h6 class="mb-3">Category and Brands</h6>


                                        <div class="mb-3">
                                            <label class="form-label">Brands</label>
                                            <select name="brand" class="select2 form-select" required>
                                                <option value="" disabled selected>Select Brand</option>

                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ isset($product) && $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label">Category</label>
                                            <select name="category" class="select2 form-select" required>
                                                <option value="" disabled selected>Select Category</option>

                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>


                                        <h6 class="mb-3">Publish</h6>

                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="published"
                                                    {{ (isset($product) && $product->status == 'published') ? 'selected' : '' }}>
                                                    Published
                                                </option>

                                                <option value="draft"
                                                    {{ (isset($product) && $product->status == 'draft') ? 'selected' : '' }}>
                                                    Draft
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Tags</label>
                                            <br>
                                            <input id="tags" name="tags" class="form-control">

                                        </div>

                                             <!-- Is Active -->
                                        <div class="form-check mt-4">
                                            <input type="hidden" name="is_active" value="0">

                                            <input type="checkbox"
                                                class="form-check-input"
                                                name="is_active"
                                                value="1"
                                                {{ isset($product) && $product->is_active ? 'checked' : '' }}>

                                            <label class="form-check-label">Is Active</label>
                                        </div>

                                    </div>
                                </div>

                                <button class="btn btn-primary w-100">
                                    {{ isset($product) ? 'Update Product' : 'Create Product' }}
                                </button>

                            </div>
                        </div>

                    </form>
                </div>

                <!-- ===================================== -->
                <!--              TAB 2: SEO               -->
                <!-- ===================================== -->
                @if(isset($product))
                <div class="tab-pane fade {{ $activeTab == 'tabSEO' ? 'show active' : '' }}" id="tabSEO">

                        <form action="{{ route('product.seo.update', $product->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="col-lg-8">

                                <div class="card mt-3">
                                    <div class="card-body">

                                        <h6 class="mb-3">SEO</h6>

                                        <!-- Meta Title -->
                                        <div class="mb-3">
                                            <label class="form-label">Meta Title</label>
                                            <input type="text"
                                                class="form-control"
                                                name="meta_title"
                                                value="{{ $product->meta_title }}">
                                        </div>

                                        <!-- Meta Description -->
                                        <div class="mb-3">
                                            <label class="form-label">Meta Description</label>
                                            <textarea class="form-control"
                                                    name="meta_description"
                                                    rows="2">{{ $product->meta_description }}</textarea>
                                        </div>

                                        <!-- Meta Keywords with Tagify -->
                                        @php
                                            $keywords = $product->meta_keywords
                                                ? collect(explode(',', $product->meta_keywords))
                                                    ->map(fn($k) => ['value' => trim($k)])
                                                : [];
                                        @endphp

                                        <div class="mb-3">
                                            <label class="form-label">Meta Keywords</label>
                                            <br>
                                            <input id="metaKeywords"
                                                class="form-control"
                                                name="meta_keywords"
                                                value='@json($keywords)'>
                                        </div>

                                        <button class="btn btn-primary w-100">Update SEO</button>
                                    </div>
                                </div>

                            </div>

                        </form>

                    </div>
                @endif

                <!-- ===================================== -->
                <!--              TAB 3: IMAGES             -->
                <!-- ===================================== -->

                @if(isset($product))
                    <div class="tab-pane fade {{ $activeTab == 'tabImages' ? 'show active' : '' }}" id="tabImages">

                        <form action="{{ route('product.image.upload') }}"
                            method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="col-lg-8 mt-3">
                                <div class="card">
                                    <div class="card-body">

                                        <h5 class="mb-3">Upload New Gallery Images</h5>

                                        <div class="mb-3">
                                            <input type="file"
                                                name="images[]"
                                                class="form-control"
                                                multiple
                                                accept="image/*"  required>
                                               
                                        </div>

                                        <button class="btn btn-primary">Upload Images</button>

                                        <h5 class="mt-4 mb-2">Gallery Images</h5>

                                        <div id="galleryContainer" class="d-flex flex-wrap gap-3">
                                            @foreach ($product->images as $img)
                                                <div class="position-relative image-box"
                                                    data-id="{{ $img->id }}"
                                                    style="width:120px;height:120px;">

                                                    <img src="{{ asset('storage/' . $img->image_path) }}"
                                                        class="border rounded"
                                                        style="width:120px;height:120px;object-fit:cover;">

                                                    <button type="button"
                                                            class="delete-image-btn btn btn-danger btn-sm"
                                                            style="position:absolute; top:-6px; right:-6px; border-radius:50%; padding:3px 7px;"
                                                            data-id="{{ $img->id }}">
                                                        ✕
                                                    </button>

                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                @endif

                 <!-- ===================================== -->
                <!--              TAB 4: Variants              -->
                <!-- ===================================== -->

                @if(isset($product))
                    <div class="tab-pane fade {{ $activeTab == 'tabVariants' ? 'show active' : '' }}" id="tabVariants">

                            @if(session('active_tab') == 'tabVariants' && $errors->any())
                                <div class="alert alert-danger">
                                    Please fill all required fields (original price, selling price, stock).
                                </div>
                            @endif

                        <h5 class="mb-3">Attributes & Values</h5>

                        <div id="attributeSection">
                            @foreach($attributes as $attribute)
                                <div class="border p-3 mb-3" data-attribute-id="{{ $attribute->id }}">
                                    <strong>{{ $attribute->name }}</strong>

                                    <div class="d-flex flex-wrap gap-3 mt-2">
                                        @foreach($attribute->values as $value)
                                            <label class="d-flex align-items-center gap-1">
                                                <input type="checkbox"
                                                    class="attribute-checkbox"
                                                    value="{{ $value->id }}"
                                                    data-attribute-id="{{ $attribute->id }}"
                                                    @if($product->attributeValues->contains($value->id)) checked @endif>
                                                {{ $value->value }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        <h5>Generated Variants</h5>

                        <form id="variantForm"
                            action="{{ route('product.variants.save', $product->id) }}"
                            method="POST"
                            enctype="multipart/form-data">

                            @csrf

                               <input type="hidden" name="active_tab" value="tabVariants">

                            <div id="selectedValuesHidden"></div>

                            <div id="variantTableContainer"></div>

                            <button type="submit" class="btn btn-primary mt-3">Save Variants</button>
                        </form>

                    </div>
                @endif



            </div>

        </div>
    </div>

</div>




@endsection

@section('js-section')

    <script>
        window.allTags = @json($allTags);
        window.productTags = @json(isset($product)
                                ? $product->tags->pluck('name')->toArray()
                                : []);


        window.deleteImageUrl = "{{ route('product.image.delete', ['id' => '__ID__']) }}";
        window.sortImageUrl = "{{ route('product.image.sort') }}";
        window.csrf = "{{ csrf_token() }}";  

        @if(isset($product))
            window.existingVariants = @json(
                $product->variants->load('values.attributeValue')
            );
        @else
            window.existingVariants = [];
        @endif

    </script>




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
     <script src="{{ asset('assets/admin/vendor/libs/quill/quill.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/tagify/tagify.js')}}"></script>
    <script src="{{ asset('assets/admin/js/custom/tag.js')}}"></script>
    <script src="{{ asset('assets/admin/js/datatable/product.js')}}"></script>
    <script src="{{ asset('assets/admin/js/pageJs/product.js')}}"></script>
   



@endsection

