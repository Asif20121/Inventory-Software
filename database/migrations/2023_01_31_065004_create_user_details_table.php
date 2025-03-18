<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('image')->nullable();
            $table->string('client_category')->nullable();
            $table->string('client_code')->nullable();
            $table->string('client_type')->nullable();
            $table->string('company_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('trede_license')->nullable();
            $table->string('dob')->nullable();
            $table->string('opening_balance')->nullable();
            $table->string('family_member')->nullable();
            $table->string('ref_by')->nullable();
            $table->string('marketing_source')->nullable();
            $table->string('Joining_date')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->integer('add_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
