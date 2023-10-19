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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('memberID', 20)->unique();
            $table->string('name');
            $table->string('email', 80)->unique();
            $table->string('password');
            $table->string('original_pass', 8)->nullable();
            $table->string('phone')->nullable();
            $table->bigInteger('location_id');
            $table->integer('plan_id');
            $table->string('avatar')->nullable();
            $table->string('customer_id');
            $table->string('card_id')->nullable();
            $table->string('card_last4', 4)->nullable();
            $table->boolean('active')->nullable()->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
