<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->text('issue')->nullable(); // Optional issue/description
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
            $table->enum('status', ['Pending', 'In Progress', 'Resolved'])->default('Pending');
            $table->text('resolution')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_requests');
    }
};
