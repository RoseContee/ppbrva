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
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->bigInteger('member_id');
            $table->string('period');
            $table->decimal('amount');
            $table->boolean('paid')->default(false);
            $table->string('plan_name')->nullable();
            $table->decimal('plan_price')->nullable();
            $table->string('card_type', 11)->nullable();
            $table->string('card_last4', 4)->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
