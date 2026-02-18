<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hour_sections', function (Blueprint $table) {
            $table->id();
            $table->string('skill_trade');
            $table->string('name');
            $table->unsignedInteger('display_order')->default(1);
            $table->decimal('target_hours', 8, 2)->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('hour_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hour_section_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('details')->nullable();
            $table->string('area_affected')->nullable();
            $table->decimal('target_hours', 8, 2)->default(0);
            $table->unsignedInteger('display_order')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hour_categories');
        Schema::dropIfExists('hour_sections');
    }
};
