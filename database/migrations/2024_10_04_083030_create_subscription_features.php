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
        Schema::create('subscription_features', function (Blueprint $table) {
            $table->id(); // ID chính cho bảng
            $table->foreignId('subscription_id')->constrained('subscriptions')->onDelete('cascade'); // Liên kết khóa ngoại với bảng Subscriptions
            $table->foreignId('feature_id')->constrained('features')->onDelete('cascade'); // Liên kết khóa ngoại với bảng Features
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_features');
    }
};
