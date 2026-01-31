<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('head_user_id')->nullable();
            $table->timestamps();

            $table->foreign('head_user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down() {
        Schema::dropIfExists('departments');
    }
};