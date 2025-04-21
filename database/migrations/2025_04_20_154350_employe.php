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
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik')->unique();
            $table->string('email')->unique();
            $table->string('phone');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->string('foto');
            $table->string('address');
            $table->foreignId('division_id')->constrained('divisions');
            $table->foreignId('job_id')->constrained('employee_jobs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
