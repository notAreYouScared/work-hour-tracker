<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weekly_sheet_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weekly_sheet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hour_template_id')->constrained()->restrictOnDelete();
            $table->decimal('monday_hours', 7, 2)->default(0);
            $table->decimal('tuesday_hours', 7, 2)->default(0);
            $table->decimal('wednesday_hours', 7, 2)->default(0);
            $table->decimal('thursday_hours', 7, 2)->default(0);
            $table->decimal('friday_hours', 7, 2)->default(0);
            $table->decimal('saturday_hours', 7, 2)->default(0);
            $table->decimal('sunday_hours', 7, 2)->default(0);
            $table->decimal('week_total', 8, 2)->default(0);
            $table->decimal('lifetime_total_snapshot', 10, 2)->default(0);
            $table->timestamps();
            $table->unique(['weekly_sheet_id', 'hour_template_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_sheet_entries');
    }
};
