<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_device_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->string('employee_code');
            $table->dateTime('punch_time');
            $table->enum('punch_type', ['in', 'out', 'unknown'])->default('unknown');
            $table->string('device_serial')->nullable();
            $table->enum('status', ['matched', 'unmatched', 'duplicate'])->default('matched');
            $table->json('raw_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_device_logs');
    }
};
