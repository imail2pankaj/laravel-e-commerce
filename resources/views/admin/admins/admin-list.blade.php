@extends('admin.layout.layout')
@section('meta-content')
    <title>Admins Table </title>
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
            <h5 class="card-header mb-0">Admins List</h5>
        @can('admins.create')
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="ti tabler-plus icon-base me-2"></i> Add New</a>
         @endcan
        </div>
        
        <div class="card ">

            <div class="card-datatable text-nowrap p-4">
                  
         
                
                {{-- <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Filter by Role</label>
                        <select id="filterRole" class="form-select">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Filter by City</label>
                        <select id="filterCity" class="form-select">
                            <option value="">All Cities</option>
                            <option value="Surat">Surat</option>
                            <option value="Ahmedabad">Ahmedabad</option>
                            <option value="Rajkot">Rajkot</option>
                        </select>
                    </div>
                </div> --}}

                <table id="adminsTable" data-route="{{ route('admin.users.index') }}" class="table table-bordered ">
                    <thead>
                        <tr>
                            <th>No </th>
                            <th>Name</th>
                            <th>Roles</th>
                            <th>Email</th>
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
    <script src="{{ asset('assets/admin/js/datatable/admin.js')}}"></script>
    <script src="{{ asset('assets/admin/js/delete.js')}}"></script>
@endsection




