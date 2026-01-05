@extends('admin.layout.layout')
@section('meta-content')
    <title>Product Table </title>
    <meta name="description" content="product table" />
@endsection

@section('css-section')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('content')




    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="card-header mb-0">Product List</h5>

         @can('products.create')
             <a href="{{ route('product.create') }}" class="btn btn-primary"><i class="ti tabler-plus icon-base me-2"></i> Add New</a>
         @endcan
                
      
        </div>
        
        <div class="card ">
           
                <div class="card-datatable text-nowrap p-4">
                    
        
                        
                            <div class="row mb-3">

                                <div class="col-md-3">
                                    <select id="filterStatus" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="published">Published</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select id="filterCategory" class="form-select">
                                        <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select id="filterBrand" class="form-select">
                                        <option value="">All Brands</option>
                                        @foreach($brands as $b)
                                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>


                        <table id="productsTable" data-route="{{ route('product.list') }}" class="table table-bordered ">
                        <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Server-side data will populate here -->
                            </tbody>
                        </table>
        
                


                </div>
        
        </div>
    
        <hr class="my-12" />

    </div>

@endsection

@section('js-section')
    <script src="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
    <script src="{{ asset('assets/admin/js/datatable/universal.js')}}"></script>
    <script src="{{ asset('assets/admin/js/datatable/product.js')}}"></script>
    <script src="{{ asset('assets/admin/js/delete.js')}}"></script>
@endsection




