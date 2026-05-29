<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meeting_notes', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('member_id')->constrained('users')->nullOnDelete();
            $table->date('meeting_date')->nullable()->after('title');
            $table->time('start_time')->nullable()->after('meeting_date');
            $table->time('end_time')->nullable()->after('start_time');
            $table->foreignId('leader_id')->nullable()->after('location')->constrained('members')->nullOnDelete();
            $table->foreignId('note_taker_id')->nullable()->after('leader_id')->constrained('members')->nullOnDelete();
            $table->text('participants')->nullable()->after('note_taker_id');
            $table->longText('discussion')->nullable()->after('content');
            $table->text('decisions')->nullable()->after('discussion');
            $table->text('follow_up')->nullable()->after('decisions');
            $table->foreignId('follow_up_pic_id')->nullable()->after('follow_up')->constrained('members')->nullOnDelete();
            $table->date('follow_up_deadline')->nullable()->after('follow_up_pic_id');
            $table->enum('follow_up_status', ['pending', 'in_progress', 'completed', 'cancelled'])->nullable()->after('follow_up_deadline');
            $table->timestamp('archived_at')->nullable()->after('follow_up_status');
        });
    }

    public function down(): void
    {
        Schema::table('meeting_notes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
            $table->dropConstrainedForeignId('follow_up_pic_id');
            $table->dropConstrainedForeignId('note_taker_id');
            $table->dropConstrainedForeignId('leader_id');
            $table->dropColumn([
                'meeting_date',
                'start_time',
                'end_time',
                'participants',
                'discussion',
                'decisions',
                'follow_up',
                'follow_up_deadline',
                'follow_up_status',
                'archived_at',
            ]);
        });
    }
};
