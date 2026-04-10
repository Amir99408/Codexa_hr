<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            // Change integer day columns to decimal to support half-day values
            $table->decimal('present_days', 5, 1)->default(0)->change();
            $table->decimal('absent_days',  5, 1)->default(0)->change();

            // Add advance tracking columns (were missing entirely)
            $table->decimal('advance_deduction', 10, 2)->default(0)->after('absent_days');
            $table->foreignId('advance_id')->nullable()->constrained('advances')->nullOnDelete()->after('advance_deduction');
        });
    }

    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropForeign(['advance_id']);
            $table->dropColumn(['advance_deduction', 'advance_id']);
            $table->integer('present_days')->default(0)->change();
            $table->integer('absent_days')->default(0)->change();
        });
    }
};
