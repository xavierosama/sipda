<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cash_transactions', function (Blueprint $table) {
            $table->foreignId('activity_id')->nullable()->after('member_id')->constrained()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->after('activity_id')->constrained('users')->nullOnDelete();
            $table->timestamp('archived_at')->nullable()->after('proof_file_path');
        });
    }

    public function down(): void
    {
        Schema::table('cash_transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
            $table->dropConstrainedForeignId('activity_id');
            $table->dropColumn('archived_at');
        });
    }
};
