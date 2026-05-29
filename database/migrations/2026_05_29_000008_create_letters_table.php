<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('letter_number')->unique();
            $table->enum('type', ['incoming', 'outgoing']);
            $table->string('subject');
            $table->string('sender')->nullable();
            $table->string('recipient')->nullable();
            $table->date('letter_date')->nullable();
            $table->date('received_date')->nullable();
            $table->string('file_path')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
