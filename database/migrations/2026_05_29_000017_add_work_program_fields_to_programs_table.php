<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->foreignId('pic_id')->nullable()->after('member_id')->constrained('members')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->after('pic_id')->constrained('users')->nullOnDelete();
            $table->string('title')->nullable()->after('created_by');
            $table->text('objective')->nullable()->after('description');
            $table->text('target')->nullable()->after('objective');
            $table->string('audience')->nullable()->after('target');
            $table->date('planned_date')->nullable()->after('audience');
            $table->string('location')->nullable()->after('planned_date');
            $table->decimal('estimated_budget', 15, 2)->nullable()->after('location');
            $table->text('notes')->nullable()->after('estimated_budget');
        });

        DB::statement("ALTER TABLE programs MODIFY status ENUM('draft', 'planned', 'ongoing', 'completed', 'postponed', 'cancelled') NOT NULL DEFAULT 'draft'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE programs MODIFY status ENUM('planned', 'ongoing', 'completed', 'cancelled') NOT NULL DEFAULT 'planned'");

        Schema::table('programs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
            $table->dropConstrainedForeignId('pic_id');
            $table->dropColumn([
                'title',
                'objective',
                'target',
                'audience',
                'planned_date',
                'location',
                'estimated_budget',
                'notes',
            ]);
        });
    }
};
