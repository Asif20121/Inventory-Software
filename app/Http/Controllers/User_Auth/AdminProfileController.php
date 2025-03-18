<?php

namespace App\Http\Controllers\User_Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Admin_details;
use App\Models\Designation;
use App\Models\Department;
use App\Models\Company;
use App\Models\Religion;
use App\Models\Blood_group;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;


class AdminProfileController extends Controller
{

    public function view(){

          $profile_view = DB::table('admins as a')
         ->leftJoin('admin_details as ad'  ,'a.id','ad.admin_id')
         ->leftJoin('designations as d'    ,'d.id' ,'ad.designation_id')
         ->leftJoin('departments as dp'    ,'dp.id' ,'ad.department_id')
         ->leftJoin('companies as c'       ,'c.id' ,'ad.company_id')
         ->leftJoin('religions as r'       ,'r.id' ,'ad.Religion')
         ->leftJoin('blood_groups as br'   ,'br.id' ,'ad.b_group')
         ->orderBy('a.id','desc')
         ->select(
            'a.id',
            'a.name',
            'a.phone',
            'a.email',
            'd.designation_name',
            'dp.department_name',
            'c.company_name',
            'r.religion_name',
            'br.bloodgroup_name',
            'ad.card_no',
            'ad.nid_id',
            'ad.dob',
            'ad.gender',
            'ad.tin',
            'ad.ref_by',
            'ad.family_mn',
            'ad.family_mp',
            'ad.source',
            'ad.address',
            'ad.joining_date',
            'ad.admin_note',
            'ad.image',
         )
         ->where('a.id', Auth::user()->id)
         ->first();

        return view('dashboard.admin.profile_view',compact('profile_view'));
    }

    public function profile_print(){

        $profile_info_print = DB::table('admins as a')
        ->leftJoin('admin_details as ad'  ,'a.id','ad.admin_id')
        ->leftJoin('designations as d'    ,'d.id' ,'ad.designation_id')
        ->leftJoin('departments as dp'    ,'dp.id' ,'ad.department_id')
        ->leftJoin('companies as c'       ,'c.id' ,'ad.company_id')
        ->leftJoin('religions as r'       ,'r.id' ,'ad.Religion')
        ->leftJoin('blood_groups as br'   ,'br.id' ,'ad.b_group')
        ->orderBy('a.id','desc')
        ->select(
           'a.id',
           'a.name',
           'a.phone',
           'a.email',
           'd.designation_name',
           'dp.department_name',
           'c.company_name',
           'r.religion_name',
           'br.bloodgroup_name',
           'ad.card_no',
           'ad.nid_id',
           'ad.dob',
           'ad.gender',
           'ad.tin',
           'ad.ref_by',
           'ad.family_mn',
           'ad.family_mp',
           'ad.source',
           'ad.address',
           'ad.joining_date',
           'ad.admin_note',
           'ad.image',
        )
        ->where('a.id', Auth::user()->id)
        ->first();

       $pdf = Pdf::loadView('dashboard.admin.profile_print',compact('profile_info_print'));
       return $pdf->stream('Your_information.pdf');
   }

    public function edit()
    {
        $profile_edit = Admin::with('admin_detail_data')->where('id', Auth::user()->id)->first();
        return view('dashboard.admin.profile_edit',compact('profile_edit'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        $admin_data = Admin::find($id);
        $admin_data->name = $request->name;
        $admin_data->phone = $request->phone;
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
            'address' => $request->address,
            'family_mn' => $request->family_mn,
            'family_mp' => $request->family_mp,
            'image' => $fileName,
        ];

        $prev_det = count(Admin_details::where('admin_id', $id)->get());

        if ($prev_det > 0) {
            $user_details = Admin_details::where('admin_id', $id)->update($user_details_data);
        } else {
            $user_details_data['admin_id'] = $id;
            $user_details = Admin_details::insert($user_details_data);
        }

        if ($admin_data && $user_details) {
            return redirect()->back()->with('success', 'Update Successfully');
        } else {
            return redirect()->back()->with('error', 'Update Failed');
        }
    }

    public function change_password()
    {
        $id=Auth::user()->id;
        return view('dashboard.admin.change_password', compact('id'));
    }
    public function update_Password(Request $request, $id)
    {

        $this->validate(
            $request,
            [
                'old_password' => [ 'required', function ($attribute, $value, $fail) {
                        if (!\Hash::check($value, Auth::user()->password)) {
                            return $fail(__('The current password is incorrect'));
                        }
                    },
                    'min:6',
                    'max:50',
                ],
                'new_password' => ['required','min:6','max:50','regex:/[a-z]/','regex:/[A-Z]/'],
                'confirm_new_password' => 'required|same:new_password',
            ],
            [
                'new_password.regex' => "Password must be one capital letter and one small letter"
            ]
        );
        $admin_user = Admin::find($id);
        $admin_user->password = Hash::make($request->new_password);


        if ( $admin_user->update()) {
            // Auth::guard('admin')->logoutOtherDevices($request->old_password);
            Session::flush();
            return redirect(route('admin.dashboard'))->with('success', 'Password Updated');
        } else {
            return redirect()->back()->with('fail', 'Password Updated Failed');
        }
    }
}
