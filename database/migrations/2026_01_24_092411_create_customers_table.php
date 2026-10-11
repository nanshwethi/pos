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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email");
            $table->string("phone")->unique();
            $table->longText("address")->nullable(true);
            $table->date("date_of_birth");
            $table->text('image')->nullable();
            $table->enum("gender", config('base.gender'));
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
