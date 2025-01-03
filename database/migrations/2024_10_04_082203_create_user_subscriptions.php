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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id(); // 'user_subscription_id'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Liên kết khóa ngoại với bảng Users
            $table->foreignId('subscription_id')->constrained('subscriptions')->onDelete('cascade'); // Liên kết khóa ngoại với bảng Subscriptions
            $table->dateTime('purchase_date'); // Ngày mua bản quyền
            $table->dateTime('start_date'); // Ngày bắt đầu hiệu lực
            $table->dateTime('end_date'); // Ngày hết hạn bản quyền
            $table->string('driver_key')->nullable(); // Driver key của thiết bị
            $table->boolean('is_active')->default(true); // Trạng thái còn hiệu lực của bản quyền
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
