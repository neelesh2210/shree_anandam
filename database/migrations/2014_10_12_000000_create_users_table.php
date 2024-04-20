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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('parent_id')->nullable()->index();
            $table->string('name');
            $table->bigInteger('phone_number')->unique()->index();
            $table->longText('address');
            $table->string('password');
            $table->string('referral_code')->unique()->index();
            $table->string('referrer_code')->nullable()->index();
            $table->integer('number_of_child')->default(0)->index();
            $table->enum('is_block', ['1', '0'])->default('0');
            $table->enum('is_verify', ['1', '0'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
