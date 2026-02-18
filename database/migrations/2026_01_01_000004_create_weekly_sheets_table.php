<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('weekly_sheets', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('week_ending')->index();
            $table->unsignedSmallInteger('week_number');
            $table->string('status')->default('draft')->index();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('denial_reason')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'week_ending']);
        });

        Schema::create('weekly_sheet_entries', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('weekly_sheet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hour_line_id')->constrained()->cascadeOnDelete();
            $table->decimal('monday', 6, 2)->default(0);
            $table->decimal('tuesday', 6, 2)->default(0);
            $table->decimal('wednesday', 6, 2)->default(0);
            $table->decimal('thursday', 6, 2)->default(0);
            $table->decimal('friday', 6, 2)->default(0);
            $table->decimal('saturday', 6, 2)->default(0);
            $table->decimal('sunday', 6, 2)->default(0);
            $table->decimal('week_total', 8, 2)->default(0);
            $table->decimal('lifetime_total', 10, 2)->default(0);
            $table->timestamps();
            $table->unique(['weekly_sheet_id', 'hour_line_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_sheet_entries');
        Schema::dropIfExists('weekly_sheets');
    }
};
