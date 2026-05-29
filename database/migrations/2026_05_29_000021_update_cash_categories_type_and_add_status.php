<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE cash_categories MODIFY type ENUM('income', 'expense', 'both') NULL");

        Schema::table('cash_categories', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('cash_categories', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        DB::statement("ALTER TABLE cash_categories MODIFY type ENUM('income', 'expense') NOT NULL");
    }
};
