<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('image')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('dob');
            $table->text('address')->nullable();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->date('admission_date');
            $table->timestamps();
        });


        // Schema::create('students', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('user_id');
        //     $table->string('name');
        //     $table->string('email')->unique()->nullable();
        //     $table->string('phone',20)->nullable();
        //     $table->date('dob')->nullable();
        //     $table->text('address')->nullable();
        //     $table->unsignedBigInteger('class_id');
        //     $table->timestamps();

        //     // define id 
        //     $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
