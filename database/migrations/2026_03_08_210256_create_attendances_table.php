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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
        $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
        $table->date('date');
        $table->time('check_in')->nullable();
        $table->time('check_out')->nullable();
        $table->enum('status', ['present', 'absent', 'late', 'half_day', 'work_from_home'])->default('present');
        $table->decimal('overtime_hours', 4, 2)->default(0);
        $table->text('note')->nullable();
        $table->timestamps();

        // One record per employee per day
        $table->unique(['employee_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
