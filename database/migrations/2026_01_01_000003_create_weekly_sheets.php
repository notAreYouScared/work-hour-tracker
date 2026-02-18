<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('weekly_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('week_number');
            $table->date('week_ending_date');
            $table->string('status')->default('draft');
            $table->text('manager_comment')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['employee_id', 'week_ending_date']);
        });

        Schema::create('weekly_sheet_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weekly_sheet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hour_category_id')->constrained()->cascadeOnDelete();
            $table->decimal('monday', 6, 2)->default(0);
            $table->decimal('tuesday', 6, 2)->default(0);
            $table->decimal('wednesday', 6, 2)->default(0);
            $table->decimal('thursday', 6, 2)->default(0);
            $table->decimal('friday', 6, 2)->default(0);
            $table->decimal('saturday', 6, 2)->default(0);
            $table->decimal('sunday', 6, 2)->default(0);
            $table->decimal('week_total', 7, 2)->default(0);
            $table->decimal('lifetime_total', 8, 2)->default(0);
            $table->timestamps();

            $table->unique(['weekly_sheet_id', 'hour_category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_sheet_entries');
        Schema::dropIfExists('weekly_sheets');
    }
};
