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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('dob');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('password');
            $table->string('email', 100)->unique();
            $table->string('email_verification_token', 100)->nullable();
            $table->boolean('status')->default(1)->comment('0-> inactive_user, 1-> active_user');
            $table->boolean('email_verified_status')->default(0)->comment('0-> not_verified, 1-> verified');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
