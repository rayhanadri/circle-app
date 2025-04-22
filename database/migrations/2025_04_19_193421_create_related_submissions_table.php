<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('related_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'submissions_id')->constrained(table: 'submissions')->onDelete(action: 'cascade');
            $table->foreignId(column: 'related_submissions_id')->constrained(table: 'submissions')->onDelete(action: 'cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('related_submissions');
    }
};
