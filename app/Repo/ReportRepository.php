<?php

namespace App\Repo;

use Illuminate\Support\Facades\DB;

class ReportRepository
{

    public function daily_sales()
    {
        $current_date = date('Y-m-d');
        $invoice = DB::select("
    select
    s.store_name,
    created.name as added_by,
    dcreated.card_no as added_card_no,
    inv.id as invoice_id,
    inv.invoice_no,inv.date,
    inv.status,p.total_amount,
    p.paid_amount,p.discount_amount,
    p.due_amount,
    p.paid_status,
    c.customer_name,
    c.email,c.phone
    from invoices as inv
    left join stores as s on inv.store_id = s.id
    left join payments as p on p.invoice_id = inv.id
    left join admins as created on created.id = inv.created_by
    left join admin_details as dcreated on created.id = dcreated.admin_id
    left join customers as c on c.id = p.customer_id
    where inv.date = '$current_date' and p.paid_status !=2 ORDER BY inv.id DESC
    ");

        return $invoice;
    }

    public function daily_sales_search($request)
    {
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $customer_id = $request->customer_id ? $request->customer_id : '';
        $employee_id = $request->employee_id ? $request->employee_id : '';
        $invoice_id = $request->invoice_id ? $request->invoice_id : '';
        if ($request->status_id == '1') {
            $status_id = '1';
        } elseif (($request->status_id == '2')) {
            $status_id = '0';
        } else {
            $status_id = '';
        }
        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond = "";
        $clause = " and";
        $sql_cond .= $from_date && $to_date != "" ? " $clause inv.date between '$from_date' and '$to_date' " : "";
        $sql_cond .= $customer_id != "" ? " $clause c.id = $customer_id" : "";
        $sql_cond .= $employee_id != "" ? " $clause created.id = $employee_id" : "";
        $sql_cond .= $invoice_id != "" ? " $clause inv.id = $invoice_id" : "";
        $sql_cond .= $status_id != "" ? " $clause p.paid_status = $status_id" : "";
        $sql_cond .= $store_id != "" ? " $clause s.id = $store_id" : "";

        $invoice = DB::select("
    select
    s.store_name,
    created.name as added_by,
    dcreated.card_no as added_card_no,
    inv.id as invoice_id,
    inv.invoice_no,inv.date,
    inv.status,p.total_amount,
    p.paid_amount,p.discount_amount,
    p.due_amount,
    p.paid_status,
    c.customer_name,
    c.email,c.phone
    from invoices as inv
    left join stores as s on inv.store_id = s.id
    left join payments as p on p.invoice_id = inv.id
    left join admins as created on created.id = inv.created_by
    left join admin_details as dcreated on created.id = dcreated.admin_id
    left join customers as c on c.id = p.customer_id
    where p.paid_status !=2 $sql_cond ORDER BY inv.id DESC
    ");

        return $invoice;
    }

    public function daily_sales_view($id)
    {
        $invoice = DB::select("
    select
    s.store_name,
    s.phone as store_phone,
    s.email as store_email,
    s.web_url as store_web_url,
    s.address as store_address,
    s.description as store_description,
    created.name as added_by,
    dcreated.card_no as added_card_no,
    updated.name as updated_by,
    dupdated.card_no as updated_by_card_no,
    inv.id as invoice_id,
    inv.invoice_no,inv.date,
    inv.status,
    inv.description,
    inv.updated_at as updated_date,
    p.total_amount,p.paid_amount,p.discount_amount, p.due_amount, p.paid_status,
    c.customer_name,c.email as customer_email,c.phone as customer_phone,c.address as customer_address
    from invoices as inv
    left join stores as s on inv.store_id = s.id
    left join payments as p on p.invoice_id = inv.id
    left join admins as created on created.id = inv.created_by
    left join admin_details as dcreated on created.id = dcreated.admin_id
    left join admins as updated on updated.id = inv.updated_by
    left join admin_details as dupdated on updated.id = dupdated.admin_id
    left join customers as c on c.id = p.customer_id
    where inv.id = '$id'
    ");

        $invoice_details_arr = [];
        foreach ($invoice as $inv) {
            $payment_details = DB::select("SELECT pd.id as payment_details_id, pd.invoice_id, pd.date, pd.current_paid_amount, pd.refound, pd.actual_paid, pd.payment_method,pd.cancel_date, pd.status,
        add_emp.name as receive_by_name,
        add_emp.email as receive_by_email,
        cancel_emp.name as cancel_by_name,
        cancel_emp.email as cancel_by_email
        from payment_details pd
        left join admins add_emp on add_emp.id = pd.updated_by
        left join admins cancel_emp on cancel_emp.id = pd.cancel_by
        where pd.invoice_id = $inv->invoice_id");
            $invoice_details = DB::select("SELECT x.`invoice_id`, x.`product_id`,x.`product_name`,x.`unit_price`,x.`unit_discount`,x.`unit_price_wd`, SUM(x.salesqty) AS saleqty, SUM(x.returnqty) AS retqty, (SUM(x.salesqty) - SUM(x.returnqty)) AS remainingqty,(SUM(x.selpwod) - SUM(x.cancelpwod)) AS item_price_wod, (SUM(x.selpwd) - SUM(x.cancelpwd)) AS item_price_wd
        FROM (
            SELECT `id`, `invoice_id`, `product_id`,`product_name`,`unit_price`,`unit_discount`,`unit_price_wd`, `status`, SUM(`qty`) AS salesqty, 0 AS returnqty,
            SUM(`selling_price_wod`) AS selpwod,0 AS cancelpwod,SUM(`selling_price_wd`) AS selpwd,0 AS cancelpwd
            FROM `invoice_details`
            WHERE `invoice_id` = '$inv->invoice_id' AND `status` = 1
            GROUP BY `id`, `invoice_id`, `product_id`,`product_name`,`unit_price`,`unit_discount`,`unit_price_wd`, `status`
            UNION
            SELECT `id`, `invoice_id`, `product_id`,`product_name`,`unit_price`,`unit_discount`,`unit_price_wd`, `status`, 0 AS salesqty, SUM(`qty`) AS returnqty,
            0 AS selpwod,SUM(`selling_price_wod`) AS cancelpwod,0 AS selpwd,SUM(`selling_price_wd`) AS cancelpwd
            FROM `invoice_details`
            WHERE `invoice_id` = '$inv->invoice_id' AND `status` = 2
            GROUP BY `id`, `invoice_id`, `product_id`,`product_name`,`unit_price`,`unit_discount`,`unit_price_wd`, `status`
        ) as x
        GROUP BY x.`invoice_id`, x.`product_id`,x.`product_name`,x.`unit_price`,x.`unit_discount`,x.`unit_price_wd`;");

            $cancel_invoice_list = DB::select(" SELECT invd.product_name,invd.qty,invd.unit_price,invd.unit_discount,invd.unit_price_wd,invd.selling_price_wod,invd.selling_price_wd,invd.updated_at as cancel_date,ad.name as cancel_by,ad_d.card_no as cancel_by_card_no FROM `invoice_details` as invd
        left join `admins` as ad on ad.id=invd.updated_by
        left join `admin_details` as ad_d on ad.id=ad_d.admin_id
        WHERE invd.invoice_id = '$inv->invoice_id' AND invd.status = 2");

            $item = [
                'store_name' => $inv->store_name,
                'store_phone' => $inv->store_phone,
                'store_email' => $inv->store_email,
                'store_web_url' => $inv->store_web_url,
                'store_address' => $inv->store_address,
                'store_description' => $inv->store_description,
                'description' => $inv->description,
                'added_by' => $inv->added_by,
                'added_card_no' => $inv->added_card_no,
                'updated_by' => $inv->updated_by,
                'updated_by_card_no' => $inv->updated_by_card_no,
                'updated_date' => $inv->updated_date,
                'invoice_id' => $inv->invoice_id,
                'invoice_no' => $inv->invoice_no,
                'date' => $inv->date,
                'status' => $inv->status,
                'total_amount' => $inv->total_amount,
                'paid_amount' => $inv->paid_amount,
                'discount_amount' => $inv->discount_amount,
                'due_amount' => $inv->due_amount,
                'paid_status' => $inv->paid_status,
                'customer_name' => $inv->customer_name,
                'customer_email' => $inv->customer_email,
                'customer_phone' => $inv->customer_phone,
                'customer_address' => $inv->customer_address,
                'payment_details' => $payment_details,
                'invoice_details' => $invoice_details,
                'cancel_invoice_list' => $cancel_invoice_list,
            ];
            array_push($invoice_details_arr, $item);

        }

        return $invoice_details_arr;
    }

    public function daily_cancel_inv()
    {
        $current_date = date('Y-m-d');
        $invoice = DB::select("
    select
    s.store_name,
    created.name as added_by,
    dcreated.card_no as added_card_no,
    inv.id as invoice_id,
    inv.invoice_no,inv.date,
    inv.status,p.total_amount,
    p.paid_amount,p.discount_amount,
    p.due_amount,
    p.paid_status,
    c.customer_name,
    c.email,c.phone
    from invoices as inv
    left join stores as s on inv.store_id = s.id
    left join payments as p on p.invoice_id = inv.id
    left join admins as created on created.id = inv.created_by
    left join admin_details as dcreated on created.id = dcreated.admin_id
    left join customers as c on c.id = p.customer_id
    where inv.date = '$current_date' and p.paid_status =2 ORDER BY inv.id DESC
    ");

        return $invoice;
    }

    public function daily_cancel_inv_search($request)
    {
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $customer_id = $request->customer_id ? $request->customer_id : '';
        $employee_id = $request->employee_id ? $request->employee_id : '';
        $invoice_id = $request->invoice_id ? $request->invoice_id : '';

        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond = "";
        $clause = " and";
        $sql_cond .= $from_date && $to_date != "" ? " $clause inv.date between '$from_date' and '$to_date' " : "";
        $sql_cond .= $customer_id != "" ? " $clause c.id = $customer_id" : "";
        $sql_cond .= $employee_id != "" ? " $clause created.id = $employee_id" : "";
        $sql_cond .= $invoice_id != "" ? " $clause inv.id = $invoice_id" : "";
        $sql_cond .= $store_id != "" ? " $clause s.id = $store_id" : "";

        $invoice = DB::select("
    select
    s.store_name,
    created.name as added_by,
    dcreated.card_no as added_card_no,
    inv.id as invoice_id,
    inv.invoice_no,inv.date,
    inv.status,p.total_amount,
    p.paid_amount,p.discount_amount,
    p.due_amount,
    p.paid_status,
    c.customer_name,
    c.email,c.phone
    from invoices as inv
    left join stores as s on inv.store_id = s.id
    left join payments as p on p.invoice_id = inv.id
    left join admins as created on created.id = inv.created_by
    left join admin_details as dcreated on created.id = dcreated.admin_id
    left join customers as c on c.id = p.customer_id
    where p.paid_status =2 $sql_cond ORDER BY inv.id DESC
    ");

        return $invoice;
    }

    public function monthly_sales()
    {
        $current_date = date('Y-m');
        $invoice = DB::select("SELECT sum(p.total_amount) as total_payable_amount , sum(p.paid_amount) as total_paid, sum(p.due_amount) as total_due from invoices as inv left join payments as p on inv.id=p.invoice_id where  inv.status !='2' and DATE_FORMAT(inv.date, '%Y-%m') = '$current_date'");
        return $invoice;
    }

    public function monthly_sales_search($request)
    {
        $from_date = $request->from_date ? date('Y-m', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m', strtotime($request->to_date)) : "";
        $customer_id = $request->customer_id ? $request->customer_id : '';
        $employee_id = $request->employee_id ? $request->employee_id : '';
        if ($request->status_id == '1') {
            $status_id = '1';
        } elseif (($request->status_id == '2')) {
            $status_id = '0';
        } else {
            $status_id = '';
        }
        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond = "";
        $clause = " and";
        $sql_cond .= $from_date && $to_date != "" ? " $clause DATE_FORMAT(inv.date, '%Y-%m') between '$from_date' and '$to_date' " : "";
        $sql_cond .= $customer_id != "" ? " $clause p.customer_id = $customer_id" : "";
        $sql_cond .= $employee_id != "" ? " $clause inv.created_by = $employee_id" : "";
        $sql_cond .= $status_id != "" ? " $clause p.paid_status = $status_id" : "";
        $sql_cond .= $store_id != "" ? " $clause inv.store_id = $store_id" : "";

        $invoice = DB::select("SELECT sum(p.total_amount) as total_payable_amount , sum(p.paid_amount) as total_paid, sum(p.due_amount) as total_due from invoices as inv left join payments as p on inv.id=p.invoice_id where  inv.status !='2' $sql_cond ");
        return $invoice;
    }

    public function yearly_sales()
    {
        $current_date = date('Y');
        $invoice = DB::select("SELECT sum(p.total_amount) as total_payable_amount , sum(p.paid_amount) as total_paid, sum(p.due_amount) as total_due from invoices as inv left join payments as p on inv.id=p.invoice_id where  inv.status !='2' and DATE_FORMAT(inv.date, '%Y') = '$current_date'");
        return $invoice;
    }

    public function yearly_sales_search($request)
    {
        $from_date = $request->from_date ? $request->from_date : '';
        $to_date = $request->to_date ? $request->to_date : "";
        $customer_id = $request->customer_id ? $request->customer_id : '';
        $employee_id = $request->employee_id ? $request->employee_id : '';
        if ($request->status_id == '1') {
            $status_id = '1';
        } elseif (($request->status_id == '2')) {
            $status_id = '0';
        } else {
            $status_id = '';
        }
        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond = "";
        $clause = " and";
        $sql_cond .= $from_date && $to_date != "" ? " $clause YEAR(inv.date) between '$from_date' and '$to_date' " : "";
        $sql_cond .= $customer_id != "" ? " $clause p.customer_id = $customer_id" : "";
        $sql_cond .= $employee_id != "" ? " $clause inv.created_by = $employee_id" : "";
        $sql_cond .= $status_id != "" ? " $clause p.paid_status = $status_id" : "";
        $sql_cond .= $store_id != "" ? " $clause inv.store_id = $store_id" : "";

        $invoice = DB::select("SELECT sum(p.total_amount) as total_payable_amount , sum(p.paid_amount) as total_paid, sum(p.due_amount) as total_due from invoices as inv left join payments as p on inv.id=p.invoice_id where  inv.status !='2' $sql_cond ");
        return $invoice;
    }

    public function rep_date_wise_cashier_report()
    {
        $current_date = date('Y-m-d');
        $invoice = DB::select("SELECT   payd.date as receive_date,ad.name,ad.id,addt.card_no, inv.date as inv_date, inv.id as inv_id, inv.invoice_no,st.id,st.store_name, sum(payd.actual_paid) as receive_amount
        FROM payment_details AS payd
        left join invoices as inv on inv.id = payd.invoice_id
        left join stores as st on st.id = inv.store_id
        left join admins as ad on ad.id = payd.updated_by
        left join admin_details as addt on ad.id = addt.admin_id
         WHERE payd.status= '1' and inv.status ='1' and payd.date = '$current_date'
        group by  inv.id,payd.date,ad.name,ad.id,addt.card_no, inv.date,st.store_name,st.id, inv.invoice_no order by  payd.date desc
        ");

        return $invoice;

    }

    public function rep_search_date_wise_cashier_report($request)
    {
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $employee_id = $request->employee_id ? $request->employee_id : '';
        $invoice_id = $request->invoice_id ? $request->invoice_id : '';

        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond = "";
        $clause = " and";
        $sql_cond .= $from_date && $to_date != "" ? " $clause payd.date between '$from_date' and '$to_date' " : "";
        $sql_cond .= $employee_id != "" ? " $clause ad.id = $employee_id" : "";
        $sql_cond .= $invoice_id != "" ? " $clause inv.id = $invoice_id" : "";
        $sql_cond .= $store_id != "" ? " $clause st.id  = $store_id" : "";

        $invoice = DB::select("SELECT   payd.date as receive_date,ad.name,ad.id,addt.card_no, inv.date as inv_date, inv.id as inv_id, inv.invoice_no,st.id,st.store_name, sum(payd.actual_paid) as receive_amount
        FROM payment_details AS payd
        left join invoices as inv on inv.id = payd.invoice_id
        left join stores as st on st.id = inv.store_id
        left join admins as ad on ad.id = payd.updated_by
        left join admin_details as addt on ad.id = addt.admin_id
         WHERE payd.status= '1' and inv.status ='1' $sql_cond
        group by  inv.id,payd.date,ad.name,ad.id,addt.card_no, inv.date,st.store_name,st.id, inv.invoice_no order by  payd.date desc
        ");

        return $invoice;
    }

    public function income_summary_report()
    {
        $current_date = date('Y-m');
        $invoice = DB::select("SELECT sum(payd.actual_paid) as receive_amount
        FROM payment_details AS payd
        left join invoices as inv on inv.id = payd.invoice_id
        left join stores as st on st.id = inv.store_id
        left join admins as ad on ad.id = payd.updated_by
        left join admin_details as addt on ad.id = addt.admin_id
         WHERE payd.status= '1' and inv.status !='2' and  DATE_FORMAT(payd.date,'%Y-%m')= '$current_date'
        ");

        return $invoice;
    }

    public function search_income_summary_report($request)
    {
        $from_date = $request->from_date ? date('Y-m', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m', strtotime($request->to_date)) : "";
        $employee_id = $request->employee_id ? $request->employee_id : '';
        $invoice_id = $request->invoice_id ? $request->invoice_id : '';

        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond = "";
        $clause = " and";
        $sql_cond .= $from_date && $to_date != "" ? " $clause DATE_FORMAT(payd.date,'%Y-%m') between '$from_date' and '$to_date' " : "";
        $sql_cond .= $employee_id != "" ? " $clause ad.id = $employee_id" : "";
        $sql_cond .= $invoice_id != "" ? " $clause inv.id = $invoice_id" : "";
        $sql_cond .= $store_id != "" ? " $clause st.id  = $store_id" : "";

        $invoice = DB::select("SELECT sum(payd.actual_paid) as receive_amount
        FROM payment_details AS payd
        left join invoices as inv on inv.id = payd.invoice_id
        left join stores as st on st.id = inv.store_id
        left join admins as ad on ad.id = payd.updated_by
        left join admin_details as addt on ad.id = addt.admin_id
         WHERE payd.status= '1' and inv.status !='2' $sql_cond
        ");

        return $invoice;

    }

}
