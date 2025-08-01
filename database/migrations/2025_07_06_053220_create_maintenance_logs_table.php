<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('maintenance_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('asset_id')->constrained()->onDelete('cascade');
        $table->foreignId('performed_by')->constrained('users')->onDelete('cascade');
        $table->text('description');
        $table->enum('status', ['Pending', 'Completed'])->default('Pending');
        $table->timestamp('date')->useCurrent();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};
