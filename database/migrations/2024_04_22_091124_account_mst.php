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
        Schema::create('account_company', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('account_name');
            $table->string('account_mst');
            $table->string('account_password');
            $table->string('status');
            $table->timestamps();

            //$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_company');
    }
};
