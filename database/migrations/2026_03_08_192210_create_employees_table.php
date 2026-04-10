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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
        $table->string('emp_code')->unique();
        $table->string('first_name');
        $table->string('last_name');
        $table->string('phone')->nullable();
        $table->string('designation')->nullable();
        $table->enum('gender', ['male', 'female', 'other'])->nullable();
        $table->date('date_of_birth')->nullable();
        $table->date('join_date');
        $table->decimal('basic_salary', 10, 2)->default(0);
        $table->enum('status', ['active', 'inactive', 'terminated'])->default('active');
        $table->text('address')->nullable();
        $table->string('photo')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
