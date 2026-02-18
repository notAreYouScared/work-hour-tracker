<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weekly_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('week_start_date');
            $table->date('week_end_date');
            $table->unsignedSmallInteger('week_number');
            $table->enum('status', ['draft', 'submitted', 'approved', 'denied'])->default('draft');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('denied_at')->nullable();
            $table->text('manager_notes')->nullable();
            $table->timestamps();
            $table->unique(['employee_id', 'week_start_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_sheets');
    }
};
