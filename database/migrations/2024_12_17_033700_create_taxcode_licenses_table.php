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
        // Bảng quản lý mã số thuế
        Schema::create('tax_licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('machine_license_id');
            $table->string('tax_code')->unique(); // Mã số thuế
            $table->string('business_name')->nullable(); // Tên doanh nghiệp

            $table->enum('status', [
                'pending',     // Chờ xác nhận
                'active',      // Đang hoạt động
                'expired',     // Đã hết hạn
                'suspended',   // Tạm ngừng
                'revoked'      // Bị thu hồi
            ])->default('pending');

            $table->date('registration_date')->nullable(); // Ngày đăng ký
            $table->date('activation_date')->nullable(); // Ngày kích hoạt
            $table->date('expiry_date')->nullable(); // Ngày hết hạn

            $table->integer('max_devices')->default(1); // Số thiết bị tối đa được phép
            $table->integer('current_devices')->default(0); // Số thiết bị đang sử dụng

            $table->text('additional_info')->nullable(); // Thông tin bổ sung

            // Khóa ngoại với bảng machine_licenses
            $table->foreign('machine_license_id')
                ->references('id')
                ->on('machine_licenses')
                ->onDelete('cascade');

            $table->unique(['machine_license_id', 'tax_code']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxcode_lincenses');
    }
};
