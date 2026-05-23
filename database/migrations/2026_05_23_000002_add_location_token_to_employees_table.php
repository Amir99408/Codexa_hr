<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Employee;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->uuid('location_token')->nullable()->unique()->after('photo');
        });

        // Generate tokens for existing employees
        Employee::whereNull('location_token')->each(function (Employee $emp) {
            $emp->updateQuietly(['location_token' => Str::uuid()->toString()]);
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('location_token');
        });
    }
};
