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
        Schema::table('user_projects', function (Blueprint $table) {
            //
            $table->string(column: 'user_role')->default('Staff'); // Add new column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_projects', function (Blueprint $table) {
            //
            $table->dropColumn('user_role');
        });
    }
};
