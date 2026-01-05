@extends('admin.layout.layout')
@section('meta-content')
    <title>Inventory Table </title>
    <meta name="description" content="product table" />
@endsection

@section('css-section')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/select2/select2.css')}}" />
@endsection

@section('content')




    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="card-header mb-0">Inventory List</h5>

            
        </div>


        
        <div class="card ">

            <div class="card-datatable text-nowrap p-4">

                <div class="row mb-3 pt-3">
    
                   <!-- Product Dropdown -->
                    <div class="col-md-4">
                        <select id="filterProductSelect" class="form-select select2">
                            <option value="">All Products</option>

                            @foreach($products as $product)
                                <option value="{{ $product->name }}">{{ $product->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-4">
                        <select id="filterStatus" class="form-select">
                            <option value="">All</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="table-responsive">
                    <table id="inventoryTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Variant SKU</th>
                                <th>Original Price</th>
                                <th>Selling Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($variants as $key => $variant)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $variant->product->name }}</td>
                                <td>{{ $variant->sku }}</td>

                                <td>
                                    <input type="number"
                                        class="form-control original-price-input"
                                        data-id="{{ $variant->id }}"
                                        value="{{ $variant->original_price }}">
                                </td>

                                <td>
                                <input type="number"
                                    class="form-control selling-price-input"
                                    data-id="{{ $variant->id }}"
                                    value="{{ $variant->selling_price }}">
                                </td>

                                <td>
                                <input type="number"
                                    class="form-control stock-input"
                                    data-id="{{ $variant->id }}"
                                    value="{{ $variant->stock }}">
                                </td>

                                <td>
                                    <label class="switch switch-primary">
                                        <input type="checkbox"
                                            class="switch-input status-toggle"
                                            data-id="{{ $variant->id }}"
                                            {{ $variant->status ? 'checked' : '' }}>
                                        <span class="switch-toggle-slider"></span>
                                    </label>

                                    <span class="d-none status-text">
                                        {{ $variant->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
  

    </div>

@endsection

@section('js-section')
    <script>
        window.inventoryConfig = {
            csrfToken: "{{ csrf_token() }}",
            updateUrl: "{{ route('product.variants.updateInventory') }}"
        };
    </script>
    <script src="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
    <script src="{{ asset('assets/admin/js/datatable/universal.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{ asset('assets/admin/js/custom/select.js')}}"></script>
    <script src="{{ asset('assets/admin/js/pageJs/inventory.js')}}"></script>
    <script src="{{ asset('assets/admin/js/delete.js')}}"></script>
    
@endsection




