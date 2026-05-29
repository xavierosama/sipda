<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->foreignId('activity_id')->nullable()->after('member_id')->constrained()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->after('activity_id')->constrained('users')->nullOnDelete();
            $table->date('received_or_sent_date')->nullable()->after('received_date');
            $table->string('category')->nullable()->after('subject');
            $table->enum('status', ['draft', 'sent', 'received', 'archived', 'cancelled'])->default('draft')->after('file_path');
            $table->text('notes')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('letters', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
            $table->dropConstrainedForeignId('activity_id');
            $table->dropColumn([
                'received_or_sent_date',
                'category',
                'status',
                'notes',
            ]);
        });
    }
};
