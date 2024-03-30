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
            $table->id("student_id");
            $table->string("first_name", 20)->nullable(false)->comment("this is the first name of the student");
            $table->string("last_name", 20)->nullable(false)->comment("this is the last name of the student");
            $table->integer("age")->nullable(false)->unsigned()->comment("this is the age of the student");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};