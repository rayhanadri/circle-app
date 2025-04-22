<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'user_id')->constrained(table: 'users')->onDelete(action: 'cascade');
            $table->foreignId(column: 'project_id')->constrained(table: 'projects')->onDelete(action: 'cascade');
            $table->foreignId(column: 'related_submission_id')->nullable()->constrained(table: 'submissions')->onDelete(action: 'set null');
            $table->string(column: 'title');
            $table->string(column: 'description')->nullable();
            $table->string(column: 'type');
            $table->string(column: 'file');
            $table->string(column: 'status')->default(value: 'Pending');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('submissions');
    }
};
