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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id');
            $table->string('category')->comment('[location] + POS from clover / Category from admin');
            $table->string('detail')->comment('order ID from clover / Detail from admin');
            $table->decimal('price');
            $table->date('date');
            $table->enum('from', ['clover', 'admin'])->default('clover');
            $table->string('invoice_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
