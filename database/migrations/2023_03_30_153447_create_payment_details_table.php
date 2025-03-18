<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id')->nullable();
            $table->date('date')->nullable();
            $table->double('current_paid_amount')->nullable();
            $table->double('refound')->nullable();
            $table->double('actual_paid')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('cancel_by')->nullable();
            $table->date('cancel_date')->nullable();
            $table->integer('updated_by')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('payment_details');
    }
}
