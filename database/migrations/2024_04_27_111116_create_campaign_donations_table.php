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
        Schema::create('campaign_donations', function (Blueprint $table) {
            $table->id();
            $table->string('donation_number')->unique()->index();
            $table->string('receipt_number')->unique()->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('campaign_id')->index();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->double('donation_amount',15,2);
            $table->longText('user_detail');
            $table->longText('campaign_detail');
            $table->longText('document_detail');
            $table->longText('payment_detail')->nullable();
            $table->enum('payment_status', ['initiated', 'success', 'failed', 'cancelled'])->default('initiated')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_donations');
    }
};
