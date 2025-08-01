<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE `assets`
            MODIFY `status` ENUM('live', 'to_be_disposal', 'backup')
            NOT NULL DEFAULT 'live'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE `assets`
            MODIFY `status` ENUM('Available', 'Assigned', 'Maintenance', 'Backup', 'Disposed')
            NOT NULL DEFAULT 'Available'
        ");
    }
};
