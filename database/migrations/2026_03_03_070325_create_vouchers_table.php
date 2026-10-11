<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string("voucher_number");
            $table->bigInteger('customer_id')->nullable();
            $table->date('date');
            $table->integer('total');
            $table->integer('tax');
            $table->integer('net_total');
            $table->integer('cash');
            $table->integer('change');
            $table->integer('voucher_items_count')->default(0);
            $table->bigInteger('user_id');
            $table->enum('type', config("base.sale_type"));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
