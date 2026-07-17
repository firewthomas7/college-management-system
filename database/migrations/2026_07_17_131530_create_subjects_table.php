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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->string('name');            // e.g. "Data Structures and Algorithms"
            $table->string('code')->unique();  // e.g. "CS201"
            $table->unsignedTinyInteger('credit_hours')->default(3);
            $table->unsignedTinyInteger('year_level')->default(1);   // which program year this is taught in
            $table->unsignedTinyInteger('semester_number')->default(1); // 1 = first semester, 2 = second semester
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
