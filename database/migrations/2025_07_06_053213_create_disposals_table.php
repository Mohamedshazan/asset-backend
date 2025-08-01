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
    Schema::create('disposals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('asset_id')->constrained()->onDelete('cascade');
        $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');
        $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
        $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
        $table->dateTime('disposal_date')->nullable();
        $table->decimal('finance_valuation', 10, 2)->nullable();
        $table->enum('status', ['Requested', 'Approved', 'Verified', 'Completed'])->default('Requested');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposals');
    }
};
