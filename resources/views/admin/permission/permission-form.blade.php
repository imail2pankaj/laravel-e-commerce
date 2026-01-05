@extends('admin.layout.layout')

{{-- Section for
<meta> Content --}}
@section('meta-content')
    <title>Permission Table </title>

    <meta name="description" content="Permission table" />
@endsection
{{-- / Section for
<meta> Content --}}


{{-- Section for CSS--}}
@section('css-section')



@endsection
{{-- / Section for CSS--}}



@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Scrollable -->
        <div class="card shadow-sm">
            <h5 class="card-header bg-primary text-white">Role Permissions</h5>

 

            <form action="{{ route('role.permissions.update') }}" method="POST">
                @csrf

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th style="min-width: 220px;">Permission</th>
                                @foreach($roles as $role)
                                    <th>{{ ucfirst($role->name) }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td class="fw-semibold text-capitalize">
                                        {{ str_replace('-', ' ', $permission->name) }}
                                    </td>

                                    @foreach($roles as $role)
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input type="checkbox" class="form-check-input"
                                                    name="permissions[{{ $role->id }}][]" value="{{ $permission->name }}"
                                                    @if($role->permissions->contains('name', $permission->name)) checked @endif>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end p-3">
                    <button type="submit" class="btn btn-success px-4">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!--/ Scrollable -->

        <hr class="my-12" />


    </div>
@endsection

{{-- Section for JS--}}
@section('js-section')

@endsection
{{-- Section for JS--}}