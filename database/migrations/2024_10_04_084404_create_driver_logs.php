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
        Schema::create('device_logs', function (Blueprint $table) {
            $table->id(); // 'log_id'
            $table->foreignId('user_subscription_id')->constrained('user_subscriptions')->onDelete('cascade'); // Liên kết khóa ngoại với bảng User_Subscriptions
            $table->string('driver_key'); // Driver key của thiết bị
            $table->dateTime('log_date'); // Ngày ghi nhận
            $table->string('action'); // Hành động (VD: "Device Added", "Device Removed")
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_logs');
    }
};
