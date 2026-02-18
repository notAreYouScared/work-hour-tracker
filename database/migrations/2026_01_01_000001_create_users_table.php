<?php

use App\Enums\SkillTrade;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('active')->default(true);
            $table->string('skill_trade')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('manager_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();
            $table->unique(['manager_id', 'employee_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manager_employee');
        Schema::dropIfExists('users');
    }
};
