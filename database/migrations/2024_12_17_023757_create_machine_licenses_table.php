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
        Schema::create('machine_licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Liên kết với user
            $table->string('machine_key')->unique(); // Mã key máy duy nhất
            $table->string('machine_name')->nullable(); // Tên máy
            $table->text('machine_fingerprint')->nullable(); // Dấu vân tay máy
            $table->text('machine_details')->nullable(); // Thông tin chi tiết máy
            $table->enum('status', [
                'active',
                'inactive',
                'suspended',
                'blocked'
            ])->default('active');
            $table->enum('active_taxcode', [
                'active',
                'blocked'
            ])->default('blocked');
            $table->timestamp('last_activated_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Liên kết với bảng users
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_licenses');
    }
};
