<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->string('card_no')->nullable();
            $table->string('designation_id')->nullable();
            $table->string('department_id')->nullable();
            $table->string('company_id')->nullable();
            $table->string('nid_id')->nullable();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->string('b_group')->nullable();
            $table->string('tin')->nullable();
            $table->string('address')->nullable();
            $table->string('ref_by')->nullable();
            $table->string('family_mn')->nullable();
            $table->string('family_mp')->nullable();
            $table->string('source')->nullable();
            $table->string('joining_date')->nullable();
            $table->longText('admin_note')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('admin_details');
    }
}
