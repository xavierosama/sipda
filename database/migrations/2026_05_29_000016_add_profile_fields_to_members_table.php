<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('position_id');
            $table->string('birth_place')->nullable()->after('phone');
            $table->date('birth_date')->nullable()->after('birth_place');
            $table->enum('gender', ['male', 'female'])->nullable()->after('birth_date');
            $table->enum('member_status', ['active', 'inactive'])->default('active')->after('joined_at');
            $table->text('notes')->nullable()->after('member_status');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'full_name',
                'birth_place',
                'birth_date',
                'gender',
                'member_status',
                'notes',
            ]);
        });
    }
};
