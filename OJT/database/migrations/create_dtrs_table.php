<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('dtrs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internship_id');
            $table->date('date');
            $table->time('time_in')->nullable();
            $table->integer('break_minutes')->default(0);
            $table->time('time_out')->nullable();
            $table->decimal('hours',5,2)->default(0);
            $table->enum('source', ['biometric','manual_upload','manual_entry'])->default('manual_entry');
            $table->string('uploaded_file_path')->nullable();
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('internship_id')->references('id')->on('internships')->cascadeOnDelete();
            $table->unique(['internship_id','date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dtrs');
    }
};