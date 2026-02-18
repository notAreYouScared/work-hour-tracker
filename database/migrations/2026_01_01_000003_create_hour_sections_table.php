<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hour_sections', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('skill_trade_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->decimal('target_hours', 8, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('hour_lines', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('hour_section_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->string('area_affected')->nullable();
            $table->decimal('target_hours', 8, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hour_lines');
        Schema::dropIfExists('hour_sections');
    }
};
