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
        // Leave empty if columns already exist
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // Make sure to drop FK before dropping the column
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'active']);
        });
    }
};
