
@extends('admin.layout.layout')
@section('meta-content')
    <title>Attribute Table </title>
    <meta name="description" content="user table" />
@endsection

@section('css-section')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.css')}}" />
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

@endsection

@section('content')




    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="card-header mb-0">Attribute Value List</h5>

            <div class="attribute-btn">
                @can('attributes.create')
                    <a href="{{ route('attributeValue.create') }}" class="btn btn-primary"><i class="ti tabler-plus icon-base me-2"></i> Add Value</a>
                @endcan
                        
            </div>
        </div>
        
        <div class="card ">

            <div class="card-datatable text-nowrap p-4">
                  

             <div class="accordion" id="attributeAccordion">

                @foreach($attributes as $attribute)
                    <div class="accordion-item mb-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#attr_{{ $attribute->id }}">
                                {{ ucfirst($attribute->name) }}
                                <span class="ms-2 text-muted">
                                    ({{ $attribute->values->count() }} values)
                                </span>
                            </button>
                        </h2>

                        <div id="attr_{{ $attribute->id }}" class="accordion-collapse collapse">
                            <div class="accordion-body">

                                <table class="table table-bordered sortable-table"
                                    data-attribute-id="{{ $attribute->id }}">
                                    <thead>
                                        <tr>
                                            @can('attributes.edit')
                                            <th width="40"></th>
                                             @endcan
                                            <th>Value</th>
                                            <th>Order</th>
                                            <th>Status</th>
                                            <th width="120">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($attribute->values as $value)
                                        <tr data-id="{{ $value->id }}">
                                            @can('attributes.edit')
                                                <td class="drag-handle">☰</td>
                                             @endcan
                                            <td>{{ $value->value }}</td>
                                            <td>{{ $value->sort_order }}</td>
                                            <td>
                                                {!! $value->is_active
                                                    ? '<span class="badge bg-success">Active</span>'
                                                    : '<span class="badge bg-secondary">Inactive</span>' !!}
                                            </td>
                                            <td>
                                                @can('attributes.edit')
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-primary editValueBtn"
                                                        data-id="{{ $value->id }}"
                                                        data-value="{{ $value->value }}"
                                                        data-status="{{ $value->is_active }}"
                                                        data-attribute="{{ $attribute->name }}"
                                                    >
                                                        Edit
                                                    </button>
                                                @endcan

                                                @can('attributes.delete')
                                                    <button
                                                    type="button"
                                                    class="btn btn-sm btn-danger delete-record"
                                                    data-route="{{ route('attributeValue.delete', $value->id) }}"
                                                    >
                                                    Delete
                                                    </button>
                                                @endcan

                                            </td>
                                       

                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editValueModal" tabindex="-1">
                        <div class="modal-dialog">
                            <form id="editValueForm">
                                @csrf
                                @method('PUT')

                                <input type="hidden" id="edit_value_id">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Attribute Value</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <!-- Attribute (Read Only) -->
                                        <div class="mb-3">
                                            <label class="form-label">Attribute</label>
                                            <input type="text"
                                                id="edit_attribute_name"
                                                class="form-control bg-light"
                                                readonly>
                                        </div>

                                        <!-- Value -->
                                        <div class="mb-3">
                                            <label class="form-label">Value</label>
                                            <input type="text"
                                                name="value"
                                                id="edit_value"
                                                class="form-control"
                                                required>
                                            <div class="text-danger small" id="valueError"></div>
                                        </div>

                                        <!-- Status -->
                                        <div class="form-check">
                                            <input type="checkbox"
                                                class="form-check-input"
                                                id="edit_is_active"
                                                name="is_active"
                                                value="1">
                                            <label class="form-check-label">Active</label>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                class="btn btn-primary">
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                @endforeach


                
             </div>


            </div>
        </div>
    
        <hr class="my-12" />

    </div>

@endsection

@section('js-section')
    <script src="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
    <script src="{{ asset('assets/admin/js/datatable/universal.js')}}"></script>
    <script src="{{ asset('assets/admin/js/delete.js')}}"></script>
    <script>
        window.AttributeValueConfig = {
            sortUrl: "{{ route('attributeValue.sort') }}",
            updateUrlTemplate: "{{ route('attributeValue.update', ':id') }}",
            csrfToken: "{{ csrf_token() }}"
        };
    </script>

    <script src="{{ asset('assets/admin/js/pageJs/attribute-value.js') }}"></script>



@endsection




