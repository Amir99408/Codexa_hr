<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->decimal('latitude',  10, 8);
            $table->decimal('longitude', 11, 8);
            $table->float('accuracy')->nullable();
            $table->timestamp('recorded_at')->index();
            $table->timestamps();

            $table->index(['employee_id', 'recorded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_locations');
    }
};
