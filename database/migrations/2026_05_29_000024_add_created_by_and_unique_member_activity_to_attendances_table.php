<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('member_id')->constrained('users')->nullOnDelete();
            $table->unique(['activity_id', 'member_id'], 'attendances_activity_member_unique');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropUnique('attendances_activity_member_unique');
            $table->dropConstrainedForeignId('created_by');
        });
    }
};
