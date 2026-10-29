<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('customers', 'full_name')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('full_name', 100);
            });
        }

        if (!Schema::hasColumn('customers', 'email')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('email', 100);
            });
        }

        if (!Schema::hasColumn('customers', 'phone')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('phone', 20)->nullable();
            });
        }

        Schema::table('customers', function (Blueprint $table) {
            $table->dateTime('created_at')->nullable(false)->change();
        });

        if (Schema::hasColumn('customers', 'updated_at')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn('updated_at');
            });
        }
    }

    public function down(): void
    {
        // Intentionally empty to avoid deleting customer data.
    }
};
