<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internship_id');
            $table->unsignedBigInteger('evaluator_id');
            $table->tinyInteger('rating')->unsigned(); // 1-5
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->foreign('internship_id')->references('id')->on('internships')->cascadeOnDelete();
            $table->foreign('evaluator_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
};