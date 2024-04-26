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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->inadex();
            $table->string('title');
            $table->string('image');
            $table->double('total_raise_amount',15,2)->inadex();
            $table->double('total_raised_amount',15,2)->default(0)->inadex();
            $table->string('short_description',300)->nullable();
            $table->longText('description')->nullable();
            $table->enum('is_active', ['1', '0'])->default('0')->inadex();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
