<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function employee_auto_search(Request $request)
    {
        if ($request->has('employee')) {
            $variable = $request->input('employee');
            return DB::table('admins as u')
                ->join('admin_details as d', 'u.id', 'd.admin_id')
                ->whereRaw("upper(u.name) like upper('%$variable%')")
                ->orWhereRaw("upper(u.email) like upper('%$variable%')")
                ->orWhereRaw("upper(u.phone) like upper('%$variable%')")
                ->orWhereRaw("upper(d.card_no) like upper('%$variable%')")
                ->select(
                    'u.id',
                    'u.name',
                    'u.email',
                    'u.phone',
                    'd.card_no',
                )
                ->limit(20)
                ->get();
        }
    }

    public function store_wise_product_search(Request $request)
    {
        $search_data = $request->product;
        $store = $request->store;
        return DB::table('product_details as pd')
            ->leftJoin('stores as s', 'pd.store_id', 's.id')
            ->leftJoin('products as p', 'pd.product_id', 'p.id')
            ->leftJoin('units as u', 'p.unit_id', 'u.id')
            ->where('s.id', $store)
            ->where('p.status', '1')
            ->where('pd.status', '1')
            ->whereRaw("upper(p.product_name) like upper('%$search_data%')")
            ->orWhereRaw("upper(p.product_code) like upper('%$search_data%')")
            ->select(
                'p.id as product_id',
                'p.product_name',
                'p.product_code',
                'u.unit_name',
                'pd.qty',
                'pd.current_sales_price',
                'pd.discount',
            )
            ->limit(20)
            ->get();
    }

    public function customer_search(Request $request)
    {
        $search_data = $request->product;

        return DB::table('customers')
            ->where('status', '1')
            ->where(function ($query) use ($search_data) {
                $query->whereRaw("upper(customer_name) like upper('%$search_data%')")
                    ->orWhereRaw("upper(email) like upper('%$search_data%')")
                    ->orWhereRaw("upper(phone) like upper('%$search_data%')");
            })
            ->limit(20)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function store_wise_invoice_search(Request $request)
    {
        $auth_id = Auth::user()->id;
        return DB::select("
        select s.store_name,inv.id as invoice_id,inv.invoice_no,inv.date,inv.status,p.total_amount,p.paid_amount,p.discount_amount,p.due_amount,p.paid_status,c.customer_name,c.email,c.phone
        from store_permissions as sp
        left join store_permission_details as spd on spd.sp_id = sp.id
        left join stores as s on spd.store_id = s.id
        right join invoices as inv on inv.store_id = s.id
        left join payments as p on p.invoice_id = inv.id
        left join customers as c on c.id = p.customer_id
        where sp.emp_id = $auth_id and sp.status = '1' and (
        inv.invoice_no LIKE '%$request->invoice%'
        )
        ORDER BY inv.id DESC
        LIMIT 20
        ");

    }

    public function invoice_search_auto(Request $request)
    {
        $auth_id = Auth::user()->id;
        return DB::select("
        select
        inv.id as invoice_id,
        inv.invoice_no,
        inv.date,
        inv.status,
        c.customer_name,
        c.email,
        c.phone
        from invoices as inv
        left join payments as p on p.invoice_id = inv.id
        left join customers as c on c.id = p.customer_id
        where  (inv.invoice_no LIKE '%$request->invoice%')
        ORDER BY inv.id DESC
        LIMIT 20
        ");

    }

    public function store_wise_employee_auto(Request $request)
    {
        // $auth_id = Auth::user()->id;
        // $permitted_store = DB::select("select spd.store_id from store_permissions as sp left join store_permission_details as spd on spd.sp_id = sp.id  where sp.emp_id = '$auth_id' and sp.status = '1' ");

        // $req_data = $request->employee;
        // return $emp_details = DB::table('store_permissions as sp')
        //     ->where('sp.status', '1')
        //     ->leftJoin('store_permission_details as spd', 'spd.sp_id', 'sp.id')
        //     ->leftJoin('admins as emp', 'sp.emp_id', 'emp.id')
        //     ->where(function ($query) use ($permitted_store) {
        //         foreach ($permitted_store as $con) {
        //             $query->orWhere('spd.store_id', '=', $con->store_id);
        //         }
        //     })
        //     ->where(function ($query) use ($req_data) {
        //         $query->whereRaw("upper(name) like upper('%$req_data%')")
        //             ->orWhereRaw("upper(email) like upper('%$req_data%')")
        //             ->orWhereRaw("upper(phone) like upper('%$req_data%')");
        //     })
        //     ->select(
        //         'sp.emp_id',
        //         'emp.id',
        //         'emp.name',
        //         'emp.email',
        //         'emp.phone',
        //     )
        //     ->groupBy(
        //         'sp.emp_id',
        //         'emp.id',
        //         'emp.name',
        //         'emp.email',
        //         'emp.phone',
        //     )
        //     ->get();

        $req_data = $request->employee;
        $auth_id = Auth::user()->id;
        return $emp_data = DB::select("select emp.id, emp.name, emp.email, emp.phone, ad.card_no from store_permissions as sp left join store_permission_details as spd on spd.sp_id=sp.id left join admins as emp on sp.emp_id = emp.id left join admin_details as ad on emp.id=ad.admin_id
        where sp.status=1 and ( upper(emp.name) like upper('%$req_data%') or upper(emp.phone) like upper('%$req_data%') or upper(ad.card_no) like upper('%$req_data%') ) AND spd.store_id IN   (select spd.store_id from  store_permissions as sp left join store_permission_details as spd on spd.sp_id = sp.id  where sp.emp_id = '$auth_id' and sp.status = '1') GROUP BY  emp.id,emp.name,emp.email, emp.phone,ad.card_no");

    }
}
