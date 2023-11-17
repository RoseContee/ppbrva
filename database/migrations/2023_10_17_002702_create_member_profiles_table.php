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
        Schema::create('member_profiles', function (Blueprint $table) {
            $table->id('member_id');
            $table->boolean('share_age_gender')->default(true);
            $table->string('dupr_id')->nullable();
            $table->string('gender', 10)->nullable();
            $table->tinyInteger('age')->nullable();
            $table->string('rating', 5)->nullable();
            $table->integer('matches')->nullable();
            $table->integer('wins')->nullable();
            $table->integer('losses')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_profiles');
    }
};
