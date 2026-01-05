@extends('admin.layout.layout')


@section('meta-content')
    <title> Create Coupon </title>

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

            <h5 class="card-header mb-2"> Create Coupon</h5>
        <div class="card">
            <div class="card-body">

       @php
    $isEdit = isset($coupon);
@endphp

<form action="{{ $isEdit ? route('admin.coupons.update', $coupon->id) : route('admin.coupons.store') }}"
      method="POST">

    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row">

        <!-- LEFT SIDE -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                    <!-- Coupon Code -->
                    <div class="mb-3">
                        <label class="form-label">Coupon Code *</label>

                        <div class="input-group">

                            <input type="text" 
                                   name="code" 
                                   id="couponCode" 
                                   class="form-control"
                                   value="{{ old('code', $coupon->code ?? '') }}"
                                   {{ $isEdit ? 'readonly' : '' }}
                                   required>

                            @if(!$isEdit)
                            <button type="button" id="generateCouponBtn"
                                class="btn btn-outline-primary">Generate</button>
                            @endif

                        </div>

                        <x-admin.error field="code" />
                    </div>

                    <!-- Coupon Name -->
                    <div class="mb-3">
                        <label class="form-label">Coupon Name *</label>
                        <input type="text" 
                               name="name" 
                               class="form-control"
                               value="{{ old('name', $coupon->name ?? '') }}">
                        <x-admin.error field="name" />
                    </div>

                    <!-- Apply Type -->
                    <div class="mb-3">
                        <label class="form-label">Apply Coupon To *</label>

                        <select name="apply_type" id="applyType" class="form-select">

                            @php
                                $applyTypeValue = old('apply_type', $coupon->apply_type ?? 'all');
                            @endphp

                            <option value="all"      {{ $applyTypeValue=='all' ? 'selected' : '' }}>All Products</option>
                            <option value="product"  {{ $applyTypeValue=='product' ? 'selected' : '' }}>Specific Products</option>
                            <option value="category" {{ $applyTypeValue=='category' ? 'selected' : '' }}>Specific Categories</option>
                            <option value="brand"    {{ $applyTypeValue=='brand' ? 'selected' : '' }}>Specific Brands</option>

                        </select>

                        <x-admin.error field="apply_type" />
                    </div>

                    <!-- Product Select -->
                    <div class="mb-3 {{ $applyTypeValue=='product' ? '' : 'd-none' }}" id="productSelectBox">
                        <label class="form-label">Select Products</label>

                        <select name="product_ids[]" class="form-select select2" multiple>

                            @php
                                $selectedProducts = old('product_ids', $isEdit ? $coupon->products->pluck('product_id')->toArray() : []);
                            @endphp

                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ in_array($product->id, $selectedProducts) ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach

                        </select>

                        <x-admin.error field="product_ids" />
                    </div>

                    <!-- Category Select -->
                    <div class="mb-3 {{ $applyTypeValue=='category' ? '' : 'd-none' }}" id="categorySelectBox">
                        <label class="form-label">Select Categories</label>

                        <select name="category_ids[]" class="form-select select2" multiple>

                            @php
                                $selectedCategories = old('category_ids', $isEdit ? $coupon->categories->pluck('category_id')->toArray() : []);
                            @endphp

                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ in_array($cat->id, $selectedCategories) ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach

                        </select>

                        <x-admin.error field="category_ids" />
                    </div>

                    <!-- Brand Select -->
                    <div class="mb-3 {{ $applyTypeValue=='brand' ? '' : 'd-none' }}" id="brandSelectBox">
                        <label class="form-label">Select Brands</label>

                        <select name="brand_ids[]" class="form-select select2" multiple>

                            @php
                                $selectedBrands = old('brand_ids', $isEdit ? $coupon->brands->pluck('brand_id')->toArray() : []);
                            @endphp

                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ in_array($brand->id, $selectedBrands) ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach

                        </select>

                        <x-admin.error field="brand_ids" />
                    </div>

                    <!-- Dates -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control"
                                   value="{{ old('start_date', $coupon->start_date ?? '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control"
                                   value="{{ old('end_date', $coupon->end_date ?? '') }}">
                             <x-admin.error field="end_date" />      
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Discount & Rules</h5></div>
                <div class="card-body">

                    <!-- Discount Type -->
                    <div class="mb-3">
                        <label class="form-label">Discount Type *</label>

                        @php
                            $discountTypeValue = old('discount_type', $coupon->discount_type ?? 'flat');
                        @endphp

                        <select name="discount_type" id="discountType" class="form-select">
                            <option value="flat" {{ $discountTypeValue=='flat' ? 'selected' : '' }}>Flat</option>
                            <option value="percent" {{ $discountTypeValue=='percent' ? 'selected' : '' }}>Percentage</option>
                        </select>

                        <x-admin.error field="discount_type" />
                    </div>

                    <!-- Discount Value -->
                    <div class="mb-3">
                        <label class="form-label">Discount Value *</label>
                        <input type="number" step="0.01" name="discount_value" class="form-control"
                               value="{{ old('discount_value', $coupon->discount_value ?? '') }}">
                        <x-admin.error field="discount_value" />
                    </div>

                    <!-- Max Discount -->
                    <div class="mb-3 {{ $discountTypeValue=='percent' ? '' : 'd-none' }}" id="maxDiscountBox">
                        <label class="form-label">Max Discount Amount</label>
                        <input type="number" step="0.01" name="max_discount" class="form-control"
                               value="{{ old('max_discount', $coupon->max_discount ?? '') }}">
                        <x-admin.error field="max_discount" />
                    </div>

                    <!-- Minimum Order Amount -->
                    <div class="mb-3">
                        <label class="form-label">Min Order Amount</label>
                        <input type="number" step="0.01" name="min_order_amount" class="form-control"
                               value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}">
                        <x-admin.error field="min_order_amount" />
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', $coupon->status ?? 1)=='1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $coupon->status ?? 1)=='0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <x-admin.error field="status" />
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="mt-3 text-end">
        <button class="btn btn-primary">
            {{ $isEdit ? 'Update Coupon' : 'Save Coupon' }}
        </button>
    </div>

</form>





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

    // SHOW MAX DISCOUNT BASED ON DISCOUNT TYPE
    $('#discountType').on('change', function () {
        if ($(this).val() === 'percent') {
            $('#maxDiscountBox').removeClass('d-none');
        } else {
            $('#maxDiscountBox').addClass('d-none');
        }
    });

    // SHOW / HIDE BOXES BASED ON APPLY TYPE
    $('#applyType').on('change', function () {

        let type = $(this).val();

        $('#productSelectBox').addClass('d-none');
        $('#categorySelectBox').addClass('d-none');
        $('#brandSelectBox').addClass('d-none');

        if (type === 'product') $('#productSelectBox').removeClass('d-none');
        if (type === 'category') $('#categorySelectBox').removeClass('d-none');
        if (type === 'brand') $('#brandSelectBox').removeClass('d-none');
    });


    // GENERATE COUPON CODE (Create Mode Only)
    @if(!$isEdit)
    $('#generateCouponBtn').on('click', function () {

        let chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        let code = "";

        for (let i = 0; i < 8; i++) {
            code += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        $('#couponCode').val(code);
    });
    @endif


    // INITIAL LOAD
    $(document).ready(function () {

        // Handle discount_type on reload
        $('#discountType').trigger('change');

        // Use old value or edit-value for apply_type
        $('#applyType').trigger('change');

    });

</script>




@endsection


