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
        Schema::create('member_friend', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member1_id');
            $table->boolean('member1_email')->default(false);
            $table->boolean('member1_phone')->default(false);
            $table->bigInteger('member2_id');
            $table->boolean('member2_email')->default(false);
            $table->boolean('member2_phone')->default(false);
            $table->enum('status', ['', 'pending', 'accepted'])->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_friend');
    }
};
