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
            $table->id();
            $table->string('invoiceID')->unique();
            $table->bigInteger('member_id');
            $table->string('period');
            $table->decimal('amount');
            $table->boolean('paid')->default(false);
            $table->string('card_type', 11)->nullable();
            $table->string('card_last4', 4)->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->string('reason')->nullable();
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
