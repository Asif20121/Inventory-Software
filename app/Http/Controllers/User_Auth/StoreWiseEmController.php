<?php

namespace App\Http\Controllers\User_Auth;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreWiseEmController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:admin.store_wise_list'])->only(['employe_list','employe_view','employe_print']);
    }
    public function employe_list()
    {

        $auth_id = Auth::user()->id;
        $emp_data = DB::select("select emp.id,emp.name,emp.email, emp.phone, emp.status, emp.created_at, emp.updated_at, ad.card_no, ad.image,d.designation_name,dp.department_name from store_permissions as sp
        left join store_permission_details as spd on spd.sp_id=sp.id
        left join admins as emp on sp.emp_id = emp.id
        left join admin_details as ad on emp.id=ad.admin_id
        left join designations as d on d.id=ad.designation_id
        left join departments as dp on dp.id=ad.department_id
        where sp.status=1 AND spd.store_id IN   (select spd.store_id from store_permissions as sp left join store_permission_details as spd on spd.sp_id = sp.id  where sp.emp_id = '$auth_id' and sp.status = '1') GROUP BY  emp.id,emp.name,emp.email, emp.phone, emp.status, emp.created_at, emp.updated_at, ad.card_no, ad.image,d.designation_name,dp.department_name");

        $employee_manage_data = [];

        foreach ($emp_data as $empd) {
            $role_data = DB::select("select roles.name as role from model_has_roles left join  roles on roles.id=model_has_roles.role_id where model_has_roles.model_id= '$empd->id' ");

            $item = ['id' => $empd->id, 'name' => $empd->name, 'email' => $empd->email, 'phone' => $empd->phone, 'status' => $empd->status, 'created_at' => $empd->created_at, 'updated_at' => $empd->updated_at, 'card_no' => $empd->card_no, 'image' => $empd->image, 'designation_name' => $empd->designation_name, 'department_name' => $empd->department_name, 'role_data' => $role_data];

            array_push($employee_manage_data, $item);
        }

        // return $employee_manage_data;

        return view('dashboard.storewiseemployee.storewise_list', compact('employee_manage_data'));

    }

    public function employe_view($id)
    {

        $auth_id = Auth::user()->id;
        $employee = DB::select("SELECT emp.id,emp.name,emp.email, emp.phone, emp.status, emp.created_at, emp.updated_at, ad.card_no,ad.nid_id,ad.dob,ad.gender,ad.tin,ad.ref_by,ad.family_mn,ad.family_mp,ad.source,ad.address,ad.joining_date,ad.admin_note, ad.image,d.designation_name,dp.department_name,c.company_name,r.religion_name,br.bloodgroup_name  from admins as emp
        left join admin_details as ad on emp.id=ad.admin_id
        left join designations as d on d.id=ad.designation_id
        left join companies as c on c.id=ad.company_id
        left join religions  as r on r.id=ad.religion
        left join blood_groups as br on br.id=ad.b_group
        left join departments as dp on dp.id=ad.department_id
         where emp.id = (select emp.id from store_permissions as sp left join store_permission_details as spd on spd.sp_id=sp.id left join admins as emp on sp.emp_id = emp.id  where sp.status=1 and emp.id='$id' AND spd.store_id IN   (select spd.store_id from store_permissions as sp left join store_permission_details as spd on spd.sp_id = sp.id  where sp.emp_id = '$auth_id'  and sp.status = '1') GROUP BY  emp.id)
         ");

        $employee_manage_arr = [];

        foreach ($employee as $empd) {
            $role_data = DB::select("select roles.name as role from model_has_roles left join  roles on roles.id=model_has_roles.role_id where model_has_roles.model_id= '$empd->id' ");

            $item = ['id' => $empd->id,
                'name' => $empd->name,
                'email' => $empd->email,
                'phone' => $empd->phone,
                'status' => $empd->status,
                'created_at' => $empd->created_at,
                'updated_at' => $empd->updated_at,
                'card_no' => $empd->card_no,
                'image' => $empd->image,
                'designation_name' => $empd->designation_name,
                'department_name' => $empd->department_name,
                'nid_id' => $empd->nid_id,
                'dob' => $empd->dob,
                'gender' => $empd->gender,
                'tin' => $empd->tin, 'ref_by' => $empd->ref_by,
                'family_mn' => $empd->family_mn,
                'family_mp' => $empd->family_mp,
                'source' => $empd->source,
                'address' => $empd->address,
                'joining_date' => $empd->joining_date,
                'admin_note' => $empd->admin_note,
                'image' => $empd->image,
                'designation_name' => $empd->designation_name,
                'department_name' => $empd->department_name,
                'company_name' => $empd->company_name,
                'religion_name' => $empd->religion_name,
                'bloodgroup_name' => $empd->bloodgroup_name,
                'role_data' => $role_data,
            ];

            array_push($employee_manage_arr, $item);
        }

        if ($employee_manage_arr) {
            $employee_manage_data = $employee_manage_arr[0];
            return view('dashboard.storewiseemployee.storewiseemployee_view', compact('employee_manage_data'));
        } else {
            return abort(404);
        }

    }

    public function employe_print($id)
    {

        $auth_id = Auth::user()->id;
        $employee = DB::select("SELECT emp.id,emp.name,emp.email, emp.phone, emp.status, emp.created_at, emp.updated_at, ad.card_no,ad.nid_id,ad.dob,ad.gender,ad.tin,ad.ref_by,ad.family_mn,ad.family_mp,ad.source,ad.address,ad.joining_date,ad.admin_note, ad.image,d.designation_name,dp.department_name,c.company_name,r.religion_name,br.bloodgroup_name  from admins as emp
        left join admin_details as ad on emp.id=ad.admin_id
        left join designations as d on d.id=ad.designation_id
        left join companies as c on c.id=ad.company_id
        left join religions  as r on r.id=ad.religion
        left join blood_groups as br on br.id=ad.b_group
        left join departments as dp on dp.id=ad.department_id
         where
         emp.id = (select emp.id from store_permissions as sp left join store_permission_details as spd on spd.sp_id=sp.id left join admins as emp on sp.emp_id = emp.id  where sp.status=1 and emp.id='$id' AND spd.store_id IN   (select spd.store_id from store_permissions as sp left join store_permission_details as spd on spd.sp_id = sp.id  where sp.emp_id = '$auth_id'  and sp.status = '1') GROUP BY  emp.id)
         ");

        $employee_manage_arr = [];

        foreach ($employee as $empd) {
            $role_data = DB::select("select roles.name as role from model_has_roles left join  roles on roles.id=model_has_roles.role_id where model_has_roles.model_id= '$empd->id' ");

            $item = ['id' => $empd->id,
                'name' => $empd->name,
                'email' => $empd->email,
                'phone' => $empd->phone,
                'status' => $empd->status,
                'created_at' => $empd->created_at,
                'updated_at' => $empd->updated_at,
                'card_no' => $empd->card_no,
                'image' => $empd->image,
                'designation_name' => $empd->designation_name,
                'department_name' => $empd->department_name,
                'nid_id' => $empd->nid_id,
                'dob' => $empd->dob,
                'gender' => $empd->gender,
                'tin' => $empd->tin, 'ref_by' => $empd->ref_by,
                'family_mn' => $empd->family_mn,
                'family_mp' => $empd->family_mp,
                'source' => $empd->source,
                'address' => $empd->address,
                'joining_date' => $empd->joining_date,
                'admin_note' => $empd->admin_note,
                'image' => $empd->image,
                'designation_name' => $empd->designation_name,
                'department_name' => $empd->department_name,
                'company_name' => $empd->company_name,
                'religion_name' => $empd->religion_name,
                'bloodgroup_name' => $empd->bloodgroup_name,
                'role_data' => $role_data,
            ];

            array_push($employee_manage_arr, $item);
        }

        $employee_manage_data = $employee_manage_arr[0];

        if ($employee_manage_data) {
            $pdf = Pdf::loadView('dashboard.storewiseemployee.storewise_pdf', compact('employee_manage_data'));
            return $pdf->stream('storewise_pdf.pdf');
        } else {
            return abort(404);
        }

    }

}
