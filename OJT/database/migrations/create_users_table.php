<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin','coordinator','supervisor','student'])->default('student');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('student_number')->nullable()->unique();
            $table->boolean('biometric_registered')->default(false);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->nullOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};