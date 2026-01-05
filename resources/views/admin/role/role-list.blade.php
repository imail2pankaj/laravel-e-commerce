@extends('admin.layout.layout')
@section('meta-content')
    <title>Role Table </title>
    <meta name="description" content="role table" />
@endsection

@section('css-section')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('content')




    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="card-header mb-0">Role List</h5>
         
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary"><i class="ti tabler-plus icon-base me-2"></i> Add New</a>
      
        </div>
        
        <div class="card ">

            <div class="card-datatable text-nowrap p-4">
                  
        

                <table id="rolesTable" data-route="{{ route('admin.roles.index') }}" class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>No </th>
                            <th>Role</th>
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
    <script src="{{ asset('assets/admin/js/datatable/role.js')}}"></script>
    <script src="{{ asset('assets/admin/js/delete.js')}}"></script>
@endsection




