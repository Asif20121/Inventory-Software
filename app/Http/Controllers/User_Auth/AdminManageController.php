<?php

namespace App\Http\Controllers\User_Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Admin_details;
use App\Models\Blood_group;
use App\Models\Company;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Logo_title;
use App\Models\Religion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use QrCode;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AdminManageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:admin.list'])->only(['admin_list', 'print_idcard', 'admin_view', 'admin_print']);
        $this->middleware(['permission:admin.create'])->only(['create']);
        $this->middleware(['permission:admin.edit'])->only(['edit']);
        $this->middleware(['permission:admin.delete'])->only(['delete']);
    }

    public function print_idcard($id)
    {
        $web_info = Logo_title::first();
        $web_url = isset($web_info->web_url) ? $web_info->web_url : 'No web url';
        $address = isset($web_info->address) ? $web_info->address : 'No Address';

        $employee_idcard = Admin::with('admin_detail_data')->find($id);
        $qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('L')->generate("website: $web_url Address:$address"));

        $pdf = Pdf::loadView('dashboard.manage_admin.idcard_print', compact('employee_idcard', 'qrcode'));
        return $pdf->stream('idcard.pdf');
    }

    public function admin_list(Request $request)
    {

        $admin_list = Admin::select('admins.*')->leftJoin('admin_details as add','admins.id','add.admin_id')->with('admin_detail_data')->orderBy('admins.id', 'desc');

        if ($request->designation != '') {
            $admin_list->where('add.designation_id', $request->designation);
        }
        if ($request->department != '') {
            $admin_list->where('add.department_id', $request->department);
        }

        if ($request->ajax()) {
            return DataTables::eloquent($admin_list)
                ->addIndexColumn()
                ->addColumn('img', function ($data) {
                    $image = isset($data['admin_detail_data']['image']) ? $data['admin_detail_data']['image'] : '';
                    return $image;
                })
                ->addColumn('emp_info', function ($data) {
                    $emp_info['name'] = isset($data['name']) ? $data['name'] : '';
                    $emp_info['phone'] = isset($data['phone']) ? $data['phone'] : '';
                    $emp_info['email'] = isset($data['email']) ? $data['email'] : '';
                    $emp_info['card_no'] = isset($data['admin_detail_data']['card_no']) ? $data['admin_detail_data']['card_no'] : '';
                    return $emp_info;
                })
                ->addColumn('designation', function ($data) {
                   return isset($data['admin_detail_data']['designation_data']['designation_name']) ? $data['admin_detail_data']['designation_data']['designation_name'] : '';

                })
                ->addColumn('department', function ($data) {
                    return isset($data['admin_detail_data']['department_data']['department_name']) ? $data['admin_detail_data']['department_data']['department_name'] : '';

                })
                ->addColumn('roles', function ($data) {
                    $roles = '';
                    foreach ($data->roles as $key => $r) {
                        $roles .= $r->name;
                    }
                    return $roles;
                })
                ->addColumn('action', function ($data) {
                    $route_data['editUrl'] = route('admin.admin_edit', $data->id);
                    // $route_data['deleteUrl'] = route('admin.admin_delete', $data->id);
                    $route_data['admin_view'] = route('admin.admin_view', $data->id);
                    $route_data['role_type'] = isset($data['role_type']) ? $data['role_type'] : '';
                    return $route_data;
                })
                ->rawColumns(['img', 'emp_info','designation', 'department', 'roles', 'action'])
                ->toJson();
        }

        $designation = Designation::select('id','designation_name')->orderBy('designation_name','asc')->get();
        $department = Department::select('id','department_name')->orderBy('department_name','asc')->get();
        return view('dashboard.manage_admin.list',compact('designation','department'));
    }

    public function admin_view($id)
    {

        $admin_view = Admin::with(['admin_detail_data.designation_data', 'roles'])->find($id);

        return view('dashboard.manage_admin.admin_view', compact('admin_view'));
    }

    public function admin_print($id)
    {

        $admin_details_print = Admin::with(['admin_detail_data.designation_data', 'roles'])->find($id);

        $pdf = Pdf::loadView('dashboard.manage_admin.admin_pdf', compact('admin_details_print'));
        return $pdf->stream('Employee_information.pdf');
    }

    public function create()
    {
        $data['designation'] = Designation::orderBy('id', 'desc')
            ->where('status', '1')
            ->get();
        $data['department'] = Department::orderBy('id', 'desc')
            ->where('status', '1')
            ->get();
        $data['company'] = Company::orderBy('id', 'desc')
            ->where('status', '1')
            ->get();
        $data['pre_religion'] = Religion::orderBy('id', 'desc')
            ->where('status', '1')
            ->get();
        $data['blood_group'] = Blood_group::orderBy('id', 'desc')
            ->where('status', '1')
            ->get();

        $data['role'] = Role::all();
        return view('dashboard.manage_admin.create')->with($data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => ['required', 'min:6', 'max:50', 'regex:/[a-z]/', 'regex:/[A-Z]/'],
            'phone' => 'required|min:11|max:16',
            'card_no' => 'required|max:100|unique:admin_details',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'dob' => 'nullable|date',
            'joining_date' => 'nullable|date',
        ], [
            'email.unique' => 'Email Must be unique',
            'password.regex' => "Password must be one capital letter and one small letter",
        ]);

        $user_data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => isset($request->status) ? $request->status : 0,
            'password' => Hash::make($request->password),
        ];

        $user = Admin::create($user_data);

        DB::transaction(function () use ($request, $user) {

            if ($request->role) {
                $user->assignRole($request->role);
            }

            $fileName = '';
            if ($request->file('image')) {
                $file_path = $request->file('image');
                $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                Storage::makeDirectory('public/employee', 'employee');
                Storage::makeDirectory('public/employee_thum', 'employee_thum');
                Image::make($file_path->path())->resize(400, 500)->save(storage_path('app/public/employee' . '/' . $fileName));
                Image::make($file_path->path())->resize(100, 80)->save(storage_path('app/public/employee_thum' . '/' . $fileName));
            }

            $user_details_data = [
                'admin_id' => $user->id,
                'card_no' => $request->card_no,
                'designation_id' => $request->designation_id,
                'department_id' => $request->department_id,
                'company_id' => $request->company_id,
                'nid_id' => $request->nid_id,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'religion' => $request->religion,
                'b_group' => $request->b_group,
                'tin' => $request->tin,
                'address' => $request->address,
                'ref_by' => $request->ref_by,
                'family_mn' => $request->family_mn,
                'family_mp' => $request->family_mp,
                'source' => $request->source,
                'joining_date' => $request->joining_date,
                'admin_note' => $request->admin_note,
                'image' => $fileName,
            ];

            $user_details = Admin_details::create($user_details_data);
        });

        if ($user) {
            return redirect()->route('admin.admin_list')->with('success', 'Registration Successfully');
        } else {
            return redirect()->back()->with('error', 'Registration Failed');
        }
    }

    public function edit($id)
    {
        $data['designation'] = Designation::orderBy('id', 'desc')
            ->where('status', '1')
            ->get();
        $data['department'] = Department::orderBy('id', 'desc')
            ->where('status', '1')
            ->get();
        $data['company'] = Company::orderBy('id', 'desc')
            ->where('status', '1')
            ->get();
        $data['pre_religion'] = Religion::orderBy('id', 'desc')
            ->where('status', '1')
            ->get();
        $data['blood_group'] = Blood_group::orderBy('id', 'desc')
            ->where('status', '1')
            ->get();

        $data['edit_data'] = Admin::with('admin_detail_data')->where('id', $id)->first();
        $data['role'] = Role::all();
        return view('dashboard.manage_admin.create')->with($data);
    }
    public function update(Request $request, $id)
    {
        if ($request->password) {
            $request->validate([
                'name' => 'required',
                'password' => ['required', 'min:6', 'max:50', 'regex:/[a-z]/', 'regex:/[A-Z]/'],
                'dob' => 'nullable|date',
                'joining_date' => 'nullable|date',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            ], [
                'password.regex' => "Password must be one capital letter and one small letter",
            ]);
        } else {
            $request->validate([
                'name' => 'required',
                'dob' => 'nullable|date',
                'joining_date' => 'nullable|date',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            ]);
        }

        $admin_data = Admin::find($id);
        $admin_data->name = $request->name;
        $admin_data->phone = $request->phone;
        if ($request->password) {
            $admin_data->password = Hash::make($request->password);
        }
        $admin_data->status = (isset($request->status) ? '1' : '0');
        $admin_data->update();

        $fileName = '';
        if ($request->file('image')) {
            if ($request->image_id != null || $request->image_id != '') {
                Storage::delete('public/employee/' . $request->image_id);
                Storage::delete('public/employee_thum/' . $request->image_id);
            }

            $file_path = $request->file('image');
            $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            Storage::makeDirectory('public/employee', 'employee');
            Storage::makeDirectory('public/employee_thum', 'employee_thum');
            Image::make($file_path->path())->resize(400, 500)->save(storage_path('app/public/employee' . '/' . $fileName));
            Image::make($file_path->path())->resize(100, 80)->save(storage_path('app/public/employee_thum' . '/' . $fileName));
        }else{
            $fileName = $request->image_id ;
        }

        $user_details_data = [
            'designation_id' => $request->designation_id,
            'department_id' => $request->department_id,
            'company_id' => $request->company_id,
            'nid_id' => $request->nid_id,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'b_group' => $request->b_group,
            'tin' => $request->tin,
            'address' => $request->address,
            'ref_by' => $request->ref_by,
            'family_mn' => $request->family_mn,
            'family_mp' => $request->family_mp,
            'source' => $request->source,
            'joining_date' => $request->joining_date,
            'admin_note' => $request->admin_note,
            'image' => $fileName,
        ];

        $prev_det = count(Admin_details::where('admin_id', $id)->get());

        if ($prev_det > 0) {
            $user_details = Admin_details::where('admin_id', $id)->update($user_details_data);
        } else {
            $user_details_data['admin_id'] = $id;
            $user_details = Admin_details::insert($user_details_data);
        }

        $admin_data->roles()->detach();
        if ($request->role) {
            $admin_data->assignRole($request->role);
        }

        if ($admin_data && $user_details) {
            return redirect()->route('admin.admin_list')->with('success', 'Update Successfully');
        } else {
            return redirect()->back()->with('error', 'Update Failed');
        }
    }

    public function delete($id)
    {
        $employee = Admin::findOrFail($id);
        $emp_details = Admin_details::where('admin_id', $id)->first();

        if (!is_null($employee)) {
            Storage::delete('public/employee/' . $emp_details->image);
            Storage::delete('public/employee_thum/' . $emp_details->image);
            $emp_details->delete();
            $employee->delete();
        }

        if ($employee) {
            return redirect()->back()->with('success', 'Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'Deleted Failed');
        }
    }
}
