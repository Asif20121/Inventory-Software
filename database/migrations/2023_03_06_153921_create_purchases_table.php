<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('voucher')->nullable();
            $table->string('store')->nullable();
            $table->string('supplier')->nullable();
            $table->string('product_cost')->nullable();
            $table->string('tax')->nullable();
            $table->string('vat')->nullable();
            $table->string('shipping_cost')->nullable();
            $table->string('other_cost')->nullable();
            $table->string('discount')->nullable();
            $table->string('grand_total')->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('added_by')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
