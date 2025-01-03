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
        Schema::create('keys', function (Blueprint $table) {
            $table->id();
            $table->integer('drive_id');
            $table->string('serial_key');
            $table->string('is_active');
            $table->date('start_date');
            $table->date('expiration_date');
            $table->timestamps();

            //$table->foreign('drive_id')->references('drive_id')->on('drives');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keys');
    }
};
