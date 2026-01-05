@extends('admin.layout.layout')
@section('meta-content')
    <title>Edit Product</title>
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




<div class="container-xxl flex-grow-1 container-p-y">

    <h5 class="card-header mb-2">Edit Product</h5>

   <div class="card">
        <div class="card-body">


            <form id="product-form"
                action="{{ route('product.update', $product->id) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    <!-- LEFT SIDE -->
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
                                        value="{{ old('name', $product->name) }}">
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
                                        value="{{ old('slug', $product->slug) }}">
                                    <x-admin.error field="slug" />
                                </div>

                                <!-- Short Description -->
                                <div class="mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea class="form-control"
                                            name="short_description"
                                            rows="2">{{ old('short_description', $product->short_description) }}</textarea>
                                </div>

                                <!-- Brand -->
                                <div class="mb-3">
                                    <label class="form-label">Brands</label>
                                    <select name="brand" class="select2 form-select" required>
                                        <option value="" disabled>Select Brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                {{ ucfirst($brand->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-admin.error field="brand" />
                                </div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="select2 form-select" required>
                                        <option value="" disabled>Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ ucfirst($category->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-admin.error field="category" />
                                </div>

                                <!-- Main Image -->
                                <div class="mb-3">
                                    <label class="form-label">Featured Image</label>

                                    @if($product->main_image)
                                        <img src="{{ asset('storage/' . $product->main_image) }}"
                                            width="120"
                                            class="mb-2 rounded border">
                                    @endif

                                    <input type="file" class="form-control" name="main_image">
                                    <x-admin.error field="main_image" />
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label class="form-label">Description</label>

                                    <!-- your editor -->
                                    <div id="full-editor" class="border rounded">
                                        {!! $product->description !!}
                                    </div>

                                    <textarea name="description"
                                            id="description"
                                            class="d-none">{{ old('description', $product->description) }}</textarea>

                                    <x-admin.error field="description" />
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="col-lg-4">

                        <!-- Status -->
                        <div class="card mb-4">
                            <div class="card-body">

                                <h6 class="mb-3">Publish</h6>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="published" {{ $product->status == 'published' ? 'selected' : '' }}>
                                            Published
                                        </option>
                                        <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>
                                            Draft
                                        </option>
                                    
                                    </select>
                                </div>

                                <!-- Active -->
                                <div class="form-check mt-4">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox"
                                        class="form-check-input"
                                        name="is_active"
                                        value="1"
                                        {{ $product->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label">Is Active</label>
                                </div>

                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="card mb-4">
                            <div class="card-body">

                                <h6 class="mb-3">SEO</h6>

                                <!-- Meta Title -->
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text"
                                        class="form-control"
                                        name="meta_title"
                                        value="{{ old('meta_title', $product->meta_title) }}">
                                </div>

                                <!-- Meta Description -->
                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea class="form-control"
                                            name="meta_description"
                                            rows="2">{{ old('meta_description', $product->meta_description) }}</textarea>
                                </div>

                                <!-- Meta Keywords (Tagify) -->
                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input id="metaKeywords"
                                        class="form-control"
                                        name="meta_keywords"
                                        value="{{ old('meta_keywords', $metaKeywords) }}">
                                    <x-admin.error field="meta_keywords" />
                                </div>

                            </div>
                        </div>

                        <!-- Button -->
                        <button class="btn btn-primary w-100">Update Product</button>

                    </div>

                </div>

            </form>





            <hr class="my-4">
 
            <h4>Upload New Gallery Images</h4>

            <div class="card">
               <div class="card-body">
                    <form action="{{ route('product.image.upload') }}" 
                        method="POST" 
                        enctype="multipart/form-data">
                        
                        @csrf

                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="mb-3">
                            <input type="file" 
                                name="images[]" 
                                class="form-control"
                                multiple
                                accept="image/*">
                        </div>

                        <button class="btn btn-primary">Upload Images</button>
                    </form>

                    <h4 class="mt-4 mb-2">Gallery Images</h4>

                    <div id="galleryContainer" class="d-flex flex-wrap gap-3">

                        @foreach ($product->images as $img)
                            <div class="position-relative image-box"
                                data-id="{{ $img->id }}"
                                style="width:120px;height:120px;">

                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                    class="border rounded"
                                    style="width:120px;height:120px;object-fit:cover;">

                                <!-- SMALL X DELETE BUTTON -->
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
    {{-- <script src="{{ asset('assets/admin/js/custom/dropzone-uploader.js')}}"></script> --}}
    <script src="{{ asset('assets/admin/js/datatable/category.js')}}"></script>
    <script src="{{ asset('assets/admin/js/pageJs/category.js')}}"></script>

    <script src="{{ asset('assets/admin/vendor/libs/quill/quill.js')}}"></script>


  
  
{{-- <script src="{{ asset('assets/admin/js/app-ecommerce-product-add.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>



<script>
    
// Create delete URL with placeholder
let deleteUrl = "{{ route('product.image.delete', ['id' => '__ID__']) }}";

document.querySelectorAll('.delete-image-btn').forEach(btn => {
    btn.addEventListener('click', function () {

        // if (!confirm("Delete this image?")) return;

        let imageId = this.dataset.id;

        // Replace placeholder with real image ID
        let finalUrl = deleteUrl.replace('__ID__', imageId);

        // Parent container for instant removal
        let imageBox = this.closest('.image-box');

        fetch(finalUrl, {
            method: 'DELETE',
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                imageBox.remove();   // remove entire image box
            }
        });
    });
});
</script>
<script>
// 🎯 Make container sortable
let sortable = new Sortable(galleryContainer, {
    animation: 150,
    ghostClass: "bg-light",

    // ⭐ THIS is the correct event to detect sorting
    onEnd: function (evt) {
        saveSortOrder();
    }
});

// 🎯 Save order to server
function saveSortOrder() {

    let order = [];

    document.querySelectorAll('#galleryContainer .image-box').forEach((el, index) => {
        order.push({
            id: el.dataset.id,
            position: index + 1
        });
    });

    fetch("{{ route('product.image.sort') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ order: order })
    })
    .then(res => res.json())
    .then(data => {
        console.log("Sorting saved!", order);
    });
}
</script>





@endsection