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
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email', 80)->unique();
            $table->string('password');
            $table->string('original_pass', 8)->nullable();
            $table->string('phone')->nullable();
            $table->enum('gender', ['male', 'female', 'prefer_not_to_say'])->nullable();
            $table->date('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 2)->nullable();
            $table->string('zipcode', 20)->nullable();
            $table->bigInteger('location_id');
            $table->integer('plan_id');
            $table->bigInteger('primary_id')->nullable();
            $table->boolean('is_child')->nullable();
            $table->decimal('secondary_fee')->nullable();
            $table->string('membership_card_id', 20)->nullable();
            $table->string('avatar')->nullable();
            $table->text('note')->nullable();
            $table->string('customerID');
            $table->string('card_last4', 4)->nullable();
            $table->enum('card_type', ['visa', 'mc', 'amex', 'discover', 'diners_club', 'jcb', 'unknown'])->nullable();
            $table->enum('status', ['active', 'inactive', 'paused', 'suspended', 'pending'])->default('active');
            $table->date('pause_from')->nullable();
            $table->date('pause_to')->nullable();
            $table->string('podplay_id')->nullable();
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
