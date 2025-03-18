@php
    $data = isset($employee_manage_data) ? $employee_manage_data : '';

    $name = isset($data['name']) ? $data['name'] : '';
    $phone = isset($data['phone']) ? $data['phone'] : '';
    $email = isset($data['email']) ? $data['email'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $admin_type = isset($data['admin_type']) ? $data['admin_type'] : '';
    $role_type = isset($data['role_type']) ? $data['role_type'] : '';

    $card_no = isset($data['card_no']) && $data['card_no'] != '' ? $data['card_no'] : '';
    $designation_name = isset($data['designation_name']) && $data['designation_name'] != '' ? $data['designation_name'] : '';
    $company_name = isset($data['company_name']) && $data['company_name'] != '' ? $data['company_name'] : '';
    $department_name = isset($data['department_name']) && $data['department_name'] != '' ? $data['department_name'] : '';
    $nid_id = isset($data['nid_id']) && $data['nid_id'] != '' ? $data['nid_id'] : '';
    $dob = isset($data['dob']) && $data['dob'] != '' ? date('d-m-Y', strtotime($data['dob'])) : '';
    $gender = isset($data['gender']) && $data['gender'] != '' ? $data['gender'] : '';
    $religion_name = isset($data['religion_name']) && $data['religion_name'] != '' ? $data['religion_name'] : '';
    $bloodgroup_name = isset($data['bloodgroup_name']) && $data['bloodgroup_name'] != '' ? $data['bloodgroup_name'] : '';
    $tin = isset($data['tin']) && $data['tin'] != '' ? $data['tin'] : '';
    $address = isset($data['address']) && $data['address'] != '' ? $data['address'] : '';
    $ref_by = isset($data['ref_by']) && $data['ref_by'] != '' ? $data['ref_by'] : '';
    $family_mn = isset($data['family_mn']) && $data['family_mn'] != '' ? $data['family_mn'] : '';
    $family_mp = isset($data['family_mp']) && $data['family_mp'] != '' ? $data['family_mp'] : '';
    $source = isset($data['source']) && $data['source'] != '' ? $data['source'] : '';
    $joining_date = isset($data['joining_date']) && $data['joining_date'] != '' ? date('d-m-Y', strtotime($data['joining_date'])) : '';
    $admin_note = isset($data['admin_note']) && $data['admin_note'] != '' ? $data['admin_note'] : '';
    $image = isset($data['image']) && $data['image'] != '' ? $data['image'] : '';
    $id = isset($data['id']) ? $data['id'] : '';
@endphp
<style>
    .white_color {
        color: white;
    }

    .p-1 {
        padding: 5px;
    }

    .bg-rounded {
        border-radius: 10px;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="row px-3">

            <div class="col-sm-6 col-md-4 mt-2"><strong>Name</strong> :&nbsp; :{{ $name }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Email</strong> :&nbsp; {{ $email }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Phone</strong> :&nbsp; {{ $phone }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Card No</strong>:&nbsp; {{ $card_no }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Designation</strong>:&nbsp;{{ $designation_name }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Department</strong>:&nbsp;{{ $department_name }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Company</strong> :&nbsp;{{ $company_name }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Nid Id</strong>:&nbsp;{{ $nid_id }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Date of Birth</strong>:&nbsp;{{ $dob }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Gender</strong> :&nbsp;
                @if ($gender == 1)
                    Male
                @elseif ($gender == 2)
                    Female
                @elseif ($gender == 3)
                    Others
                @endif
            </div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Religion</strong> :&nbsp;{{ $religion_name }}
            </div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Blood group</strong>:&nbsp;{{ $bloodgroup_name }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Tin No</strong> :&nbsp;{{ $tin }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Address</strong> :&nbsp;{{ $address }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Reference By</strong>:&nbsp;{{ $ref_by }}</div>
            <div class="col-sm-6 col-md-4 mt-2">
                <strong>Family Member</strong>: <br />
                &nbsp;&nbsp; Name: {{ $family_mn }} <br>
                &nbsp;&nbsp; Phone: {{ $family_mp }}
            </div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Source</strong>:&nbsp; {{ $source }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Joining Date</strong>:&nbsp;{{ $joining_date }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Photo</strong>
                <div id="">
                    <img id="show_image"
                        src="{{ $image != '' ? URL::to('storage/employee/' . $image) : asset('no_image.png') }}"
                        style="width: 200px;height:200px" class="rounded elevation-2 m-2" alt="No Image">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Role</strong>:&nbsp;
                @foreach ($data['role_data'] as $roles)
                    <span class="bg-dark rounded p-1">{{ $roles->role != '' ? $roles->role : '' }}</span>
                @endforeach
            </div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Status</strong>:&nbsp;
                @if ($data['status'] == 1)
                    <span class="white_color p-1 bg-rounded" style="background-color:#28a745;">Active</span>
                @else
                    <span class="p-1 bg-rounded" style="background-color:#ffc107;">Inactive</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <a type="button" href="{{ route('admin.employe_print', $data['id']) }}"
                    class="btn-sm text-white btn-warning " target="_blank">Print</a>
            </div>
        </div>
    </div><!-- /.card-body -->
</div>
