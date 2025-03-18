<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Admin_details;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::where('role_type', '5')->first();

        if (is_null($admin)) {
            $admin           = new Admin();
            $admin->name     = "Super Admin";
            $admin->email    = "admin@itsheba24.com";
            $admin->role_type = "5";
            $admin->status = "1";
            $admin->password = Hash::make('password');
            $admin->save();


            DB::transaction(function () use ($admin) {
                $user_details_data = [
                    'admin_id' => $admin->id,
                    'card_no' => 'sup-001',
                ];

                $user_details = Admin_details::create($user_details_data);
            });
        }
    }
}
