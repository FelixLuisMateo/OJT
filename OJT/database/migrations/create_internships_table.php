<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->enum('assignment_type', ['internal','external'])->default('internal');
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('company_name')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['assigned','in_progress','completed','cancelled'])->default('assigned');
            $table->decimal('rendered_hours',8,2)->default(0);
            $table->integer('required_hours')->default(240);
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('course_id')->references('id')->on('courses')->cascadeOnDelete();
            $table->foreign('supervisor_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('internships');
    }
};