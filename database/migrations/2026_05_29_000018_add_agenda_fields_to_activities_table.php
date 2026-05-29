<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->foreignId('pic_id')->nullable()->after('member_id')->constrained('members')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->after('pic_id')->constrained('users')->nullOnDelete();
            $table->string('title')->nullable()->after('created_by');
            $table->date('activity_date')->nullable()->after('title');
            $table->time('start_time')->nullable()->after('activity_date');
            $table->time('end_time')->nullable()->after('start_time');
            $table->text('notes')->nullable()->after('status');
        });

        DB::statement("ALTER TABLE activities MODIFY status ENUM('planned', 'ongoing', 'completed', 'postponed', 'cancelled') NOT NULL DEFAULT 'planned'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE activities MODIFY status ENUM('planned', 'ongoing', 'completed', 'cancelled') NOT NULL DEFAULT 'planned'");

        Schema::table('activities', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
            $table->dropConstrainedForeignId('pic_id');
            $table->dropColumn([
                'title',
                'activity_date',
                'start_time',
                'end_time',
                'notes',
            ]);
        });
    }
};
