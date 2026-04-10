<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('job_postings', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
        $table->text('description')->nullable();
        $table->text('requirements')->nullable();
        $table->string('location')->nullable();
        $table->string('type')->default('full_time');
        $table->decimal('salary_min', 10, 2)->nullable();
        $table->decimal('salary_max', 10, 2)->nullable();
        $table->integer('positions')->default(1);
        $table->date('deadline')->nullable();
        $table->string('status')->default('open');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('job_postings');
}
};