<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('activity_id')->nullable()->after('member_id')->constrained()->nullOnDelete();
            $table->foreignId('uploaded_by')->nullable()->after('activity_id')->constrained('users')->nullOnDelete();
            $table->date('document_date')->nullable()->after('category');
            $table->timestamp('archived_at')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('uploaded_by');
            $table->dropConstrainedForeignId('activity_id');
            $table->dropColumn([
                'document_date',
                'archived_at',
            ]);
        });
    }
};
