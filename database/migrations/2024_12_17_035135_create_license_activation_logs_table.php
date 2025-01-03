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
        // Bảng log kích hoạt license
        Schema::create('license_activation_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tax_license_id');
            $table->unsignedBigInteger('machine_license_id');
            $table->string('device_identifier'); // Mã định danh thiết bị
            $table->ipAddress('ip_address')->nullable(); // Địa chỉ IP
            $table->text('device_details')->nullable(); // Chi tiết thiết bị

            $table->enum('action', [
                'activated',
                'deactivated',
                'renewed',
                'blocked'
            ]);

            $table->foreign('tax_license_id')
                ->references('id')
                ->on('tax_licenses')
                ->onDelete('cascade');

            $table->foreign('machine_license_id')
                ->references('id')
                ->on('machine_licenses')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_activation_logs');
    }
};
