<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->string('brand');
            $table->string('model');
            $table->string('device_name')->unique();
            $table->string('os')->nullable();
            $table->string('serial_number')->unique();
            

        

            // ✅ Strictly limited to required statuses
            $table->enum('status', ['Live', 'To Be Disposal', 'Backup'])->default('Live');


            // ✅ Assignment status and employee reference
            $table->enum('active', ['Assigned', 'Not Assigned'])->default('Not Assigned');
            $table->string('employee')->nullable(); // optional: can be a name or email

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};