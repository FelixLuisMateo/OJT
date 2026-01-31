<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('school_years', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g. "2025-2026"
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('school_years');
    }
};