<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->integer('internal_required_hours')->default(240);
            $table->integer('external_required_hours')->default(240);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('courses');
    }
};