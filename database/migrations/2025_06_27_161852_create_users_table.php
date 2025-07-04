<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password'); // Hash stored here
            $table->enum('role', ['applicant', 'company']); // Role-based access
            $table->timestamps(); // created_at and updated_at
        });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

