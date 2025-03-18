@extends('dashboard.admin.layouts.master')
@php
    $data = isset($role) ? $role : '';
    $id = isset($data->id) ? $data->id : '';
    $role_name = isset($data->name) ? $data->name : '';

@endphp
@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $id ? 'Edit Role In Permission' : 'Add New Role In Permission' }} </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Role In Permission</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Create
                                </h3>
                                <div class="card-tools">
                                            <a class="btn btn-primary"
                                                href="{{ route('rpm.in_role_permission.list') }}">Role In Permission
                                                List</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">

                                <form action="{{ route('rpm.in_role_permission.update', $id) }}" method="POST">
                                    @csrf


                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Role Name <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" disabled class="form-control" value="{{ $role_name }}">
                                        </div>
                                    </div>

                                    <div class="form-group row p-2">
                                        <div class="form-check col-md-4">
                                            <input type="checkbox" class="form-check-input" id="all_permission">
                                            <label class="form-check-label" for="all_permission">
                                                <strong>All Permission (<span class="text-primary">Optional</span>)</strong>
                                            </label>
                                        </div>
                                    </div>
                                    <hr class="my-2">

                                    @php
                                        $i = 1;
                                    @endphp

                                    @if (isset($permission_group))
                                        @foreach ($permission_group as $group)
                                            @php
                                                $i++;
                                                $permission = App\Models\Admin::getPermissionByGroupName($group->group_name);
                                            @endphp

                                            <div class="form-group row p-2">
                                                <div class="form-check col-md-4">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="group_name{{ $i }}" value="{{ $group->group_name }}"
                                                        onclick="checkPermissionGroup('manageGroupCheck{{ $i }}',this)"
                                                        {{App\Models\Admin::rolHasPermissions( $role,$permission ) ? 'checked' : ''}}
                                                        >
                                                    <label class="form-check-label" for="group_name{{ $i }}">
                                                        <strong style="text-transform: capitalize;">{{ $group->group_name }}</strong>
                                                    </label>
                                                </div>

                                                <div class="form-check col-md-8 manageGroupCheck{{ $i }}">

                                                    @if (isset($permission))
                                                        @foreach ($permission as $per)
                                                            <input type="checkbox" class="form-check-input"
                                                            {{$role->hasPermissionTo($per->name) ? 'checked' : ''}}
                                                                name="permission[]" value="{{ $per->id }}"
                                                                id="permission{{ $per->id }}">
                                                            <label class="form-check-label" style="text-transform: capitalize;"
                                                                for="permission{{ $per->id }}">{{ $per->name }}</label>
                                                            <br>
                                                        @endforeach
                                                    @endif

                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="row mt-4">
                                        <div class="col text-right pt-5">
                                            <button class="btn btn-info">{{ $id ? 'Update' : 'Save' }}</button>
                                        </div>
                                    </div>

                                </form>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </section>
                    <!-- right col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@push('admin_js')
    <script>
        $("#all_permission").click(function() {
            if ($(this).is(':checked')) {
                $('input[type =checkbox]').prop('checked', true)
            } else {
                $('input[type =checkbox]').prop('checked', false)
            }
        })

        function checkPermissionGroup(permissionClass, groupId) {
            const groupIdName = $('#' + groupId.id)
            const checkClass = $('.' + permissionClass + ' input')

            if (groupIdName.is(':checked')) {
                checkClass.prop('checked', true)
            } else {
                checkClass.prop('checked', false)
            }

        }
    </script>
@endpush
