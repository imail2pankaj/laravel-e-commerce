@extends('admin.layout.layout')
@section('meta-content')
    <title>Customer Table </title>
    <meta name="description" content="user table" />
@endsection

@section('css-section')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('content')




    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="card-header mb-0">Customer List</h5>

         @can('customers.create')
             <a href="{{ route('admin.customers.create') }}" class="btn btn-primary"><i class="ti tabler-plus icon-base me-2"></i> Add New</a>
         @endcan
                
      
        </div>
        
        <div class="card ">

            <div class="card-datatable text-nowrap p-4">
                  


                <table id="customersTable" data-route="{{ route('admin.customers.index') }}" class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>No </th>
                            <th>Name</th>
                            <th>email</th>
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
    <script src="{{ asset('assets/admin/js/datatable/customer.js')}}"></script>
    <script src="{{ asset('assets/admin/js/delete.js')}}"></script>
@endsection




